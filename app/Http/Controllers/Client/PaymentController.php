<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\CryptoWallet;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Notifications\PaymentReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = auth()->user()->payments()->latest()->paginate(15);
        return view('client.payments.index', compact('payments'));
    }

    public function invoices()
    {
        $invoices = auth()->user()->invoices()->with('project')->latest()->paginate(15);
        return view('client.payments.invoices', compact('invoices'));
    }

    public function showInvoice(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $invoice->load(['items', 'project', 'user']);
        $cryptoWallets = CryptoWallet::active()->get();
        $settings = Setting::getAllCached();
        return view('client.payments.invoice-detail', compact('invoice', 'cryptoWallets', 'settings'));
    }

    // ─── INITIATE PAYMENT ────────────────────────────────────────
    public function initiate(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'gateway' => 'required|in:paystack,flutterwave,bank_transfer,crypto',
            'proof_of_payment' => 'required_if:gateway,bank_transfer,crypto|nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'crypto_wallet_id' => 'required_if:gateway,crypto|nullable|exists:crypto_wallets,id',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        // Prevent paying already-paid invoices
        if ($invoice->status === 'paid') {
            return back()->with('error', 'This invoice has already been paid.');
        }

        // Prevent paying invoices that already have a pending payment under review
        if ($invoice->status === 'pending') {
            return back()->with('error', 'A payment for this invoice is already under review. Please wait for approval.');
        }

        // Prevent duplicate pending payments for online gateways
        if (in_array($request->gateway, ['paystack', 'flutterwave'])) {
            $existingPending = Payment::where('invoice_id', $invoice->id)
                ->where('gateway', $request->gateway)
                ->where('status', 'pending')
                ->where('created_at', '>=', now()->subMinutes(30))
                ->exists();

            if ($existingPending) {
                return back()->with('error', 'A payment is already being processed for this invoice. Please wait or try again shortly.');
            }
        }

        // Check if payment method is enabled
        $settings = Setting::getAllCached();
        $gatewayMap = [
            'paystack' => 'enable_paystack',
            'flutterwave' => 'enable_flutterwave',
            'bank_transfer' => 'enable_bank_transfer',
            'crypto' => 'enable_crypto',
        ];
        if (($settings[$gatewayMap[$request->gateway]] ?? '0') !== '1') {
            return back()->with('error', 'This payment method is currently unavailable.');
        }

        $reference = 'PAY-' . strtoupper(Str::random(16));

        $description = "Payment for Invoice #{$invoice->invoice_number}";
        if ($request->gateway === 'crypto' && $request->crypto_wallet_id) {
            $wallet = CryptoWallet::find($request->crypto_wallet_id);
            if ($wallet) {
                $description .= " via {$wallet->name} ({$wallet->network})";
            }
        }

        $paymentData = [
            'user_id' => auth()->id(),
            'project_id' => $invoice->project_id,
            'invoice_id' => $invoice->id,
            'reference' => $reference,
            'amount' => $invoice->total,
            'currency' => $settings['currency_code'] ?? 'NGN',
            'gateway' => $request->gateway,
            'status' => 'pending',
            'description' => $description,
        ];

        // Handle proof of payment upload for bank transfer & crypto
        if (in_array($request->gateway, ['bank_transfer', 'crypto']) && $request->hasFile('proof_of_payment')) {
            $paymentData['proof_of_payment'] = $request->file('proof_of_payment')->store('proofs', 'public');
        }

        $payment = Payment::create($paymentData);

        if ($request->gateway === 'paystack') {
            return $this->initiatePaystack($payment);
        }

        if ($request->gateway === 'flutterwave') {
            return $this->initiateFlutterwave($payment);
        }

        // Bank transfer & crypto: payment is pending, admin will approve
        // Update invoice status to pending (awaiting payment approval)
        $invoice->update(['status' => 'pending']);

        ActivityLog::log('payment_initiated', "Manual payment of " . ($settings['currency_symbol'] ?? '₦') . number_format($payment->amount, 2) . " submitted for review", $payment);

        return redirect()->route('client.payments.index')
            ->with('success', 'Payment submitted! Your proof of payment is under review. You will be notified once approved.');
    }

    // ─── PAYSTACK: REDIRECT CALLBACK ─────────────────────────────
    public function paystackCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference || !preg_match('/^PAY-[A-Z0-9]{16}$/', $reference)) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Invalid payment reference.');
        }

        $payment = Payment::where('reference', $reference)
            ->where('gateway', 'paystack')
            ->first();

        if (!$payment) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment not found.');
        }

        // Already processed (idempotency guard)
        if ($payment->status === 'successful') {
            return redirect()->route('client.payments.index')
                ->with('success', 'Payment already confirmed!');
        }

        // Verify with Paystack server-side
        $result = $this->verifyPaystackTransaction($reference);

        if (!$result) {
            Log::error('Paystack verification API failed', ['reference' => $reference]);
            return redirect()->route('client.payments.index')
                ->with('error', 'Unable to verify payment. If you were charged, it will be confirmed automatically.');
        }

        if (($result['data']['status'] ?? '') === 'success') {
            // Verify amount matches (Paystack returns amount in kobo)
            $paidAmountKobo = (int) ($result['data']['amount'] ?? 0);
            $expectedAmountKobo = (int) round($payment->amount * 100);

            if ($paidAmountKobo < $expectedAmountKobo) {
                Log::warning('Paystack amount mismatch', [
                    'reference' => $reference,
                    'expected' => $expectedAmountKobo,
                    'received' => $paidAmountKobo,
                ]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $result['data'],
                    'admin_notes' => "Amount mismatch: expected {$expectedAmountKobo} kobo, got {$paidAmountKobo} kobo",
                ]);
                return redirect()->route('client.payments.index')
                    ->with('error', 'Payment amount mismatch. Please contact support.');
            }

            $this->markPaymentSuccessful($payment, $result['data']['reference'], $result['data'], 'Paystack');

            return redirect()->route('client.payments.index')
                ->with('success', 'Payment successful! Thank you.');
        }

        $payment->update([
            'status' => 'failed',
            'gateway_response' => $result['data'] ?? null,
        ]);

        return redirect()->route('client.payments.index')
            ->with('error', 'Payment was not successful. Please try again.');
    }

    // ─── FLUTTERWAVE: REDIRECT CALLBACK ──────────────────────────
    public function flutterwaveCallback(Request $request)
    {
        $txRef = $request->query('tx_ref');
        $transactionId = $request->query('transaction_id');
        $status = $request->query('status');

        if (!$txRef || !preg_match('/^PAY-[A-Z0-9]{16}$/', $txRef)) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Invalid payment reference.');
        }

        $payment = Payment::where('reference', $txRef)
            ->where('gateway', 'flutterwave')
            ->first();

        if (!$payment) {
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment not found.');
        }

        // Already processed (idempotency guard)
        if ($payment->status === 'successful') {
            return redirect()->route('client.payments.index')
                ->with('success', 'Payment already confirmed!');
        }

        // If Flutterwave says cancelled/failed in redirect, mark failed
        if ($status === 'cancelled') {
            $payment->update(['status' => 'failed', 'admin_notes' => 'Cancelled by user at gateway']);
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment was cancelled.');
        }

        if (!$transactionId || !is_numeric($transactionId)) {
            $payment->update(['status' => 'failed', 'admin_notes' => 'Missing transaction_id in callback']);
            return redirect()->route('client.payments.index')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        // Verify with Flutterwave server-side
        $result = $this->verifyFlutterwaveTransaction($transactionId);

        if (!$result) {
            Log::error('Flutterwave verification API failed', ['transaction_id' => $transactionId, 'tx_ref' => $txRef]);
            return redirect()->route('client.payments.index')
                ->with('error', 'Unable to verify payment. If you were charged, it will be confirmed automatically.');
        }

        if (($result['data']['status'] ?? '') === 'successful' && ($result['data']['tx_ref'] ?? '') === $payment->reference) {
            // Verify amount and currency match
            $paidAmount = (float) ($result['data']['amount'] ?? 0);
            $paidCurrency = $result['data']['currency'] ?? '';
            $expectedAmount = (float) $payment->amount;

            if ($paidAmount < $expectedAmount) {
                Log::warning('Flutterwave amount mismatch', [
                    'tx_ref' => $txRef,
                    'expected' => $expectedAmount,
                    'received' => $paidAmount,
                ]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $result['data'],
                    'admin_notes' => "Amount mismatch: expected {$expectedAmount}, got {$paidAmount}",
                ]);
                return redirect()->route('client.payments.index')
                    ->with('error', 'Payment amount mismatch. Please contact support.');
            }

            if (strtoupper($paidCurrency) !== strtoupper($payment->currency)) {
                Log::warning('Flutterwave currency mismatch', [
                    'tx_ref' => $txRef,
                    'expected' => $payment->currency,
                    'received' => $paidCurrency,
                ]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $result['data'],
                    'admin_notes' => "Currency mismatch: expected {$payment->currency}, got {$paidCurrency}",
                ]);
                return redirect()->route('client.payments.index')
                    ->with('error', 'Payment currency mismatch. Please contact support.');
            }

            $this->markPaymentSuccessful($payment, $result['data']['flw_ref'] ?? $transactionId, $result['data'], 'Flutterwave');

            return redirect()->route('client.payments.index')
                ->with('success', 'Payment successful! Thank you.');
        }

        $payment->update([
            'status' => 'failed',
            'gateway_response' => $result['data'] ?? null,
        ]);

        return redirect()->route('client.payments.index')
            ->with('error', 'Payment was not successful. Please try again.');
    }

    // ─── PAYSTACK: WEBHOOK (server-to-server) ────────────────────
    public function paystackWebhook(Request $request)
    {
        // Verify HMAC signature from Paystack
        $signature = $request->header('x-paystack-signature');
        $secret = config('services.paystack.secret_key');

        if (!$signature || !$secret) {
            Log::warning('Paystack webhook: missing signature or secret');
            return response()->json(['status' => 'error'], 400);
        }

        $computedSignature = hash_hmac('sha512', $request->getContent(), $secret);

        if (!hash_equals($computedSignature, $signature)) {
            Log::warning('Paystack webhook: invalid signature', [
                'ip' => $request->ip(),
            ]);
            return response()->json(['status' => 'error'], 400);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? '';

        Log::info('Paystack webhook received', ['event' => $event]);

        if ($event === 'charge.success') {
            $data = $payload['data'] ?? [];
            $reference = $data['reference'] ?? '';

            if (!$reference) {
                return response()->json(['status' => 'ok']);
            }

            $payment = Payment::where('reference', $reference)
                ->where('gateway', 'paystack')
                ->first();

            if (!$payment || $payment->status === 'successful') {
                // Already processed or not found — return 200 to stop retries
                return response()->json(['status' => 'ok']);
            }

            // Verify amount (kobo)
            $paidAmountKobo = (int) ($data['amount'] ?? 0);
            $expectedAmountKobo = (int) round($payment->amount * 100);

            if ($paidAmountKobo < $expectedAmountKobo) {
                Log::warning('Paystack webhook: amount mismatch', [
                    'reference' => $reference,
                    'expected' => $expectedAmountKobo,
                    'received' => $paidAmountKobo,
                ]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $data,
                    'admin_notes' => "Webhook: amount mismatch ({$paidAmountKobo} vs {$expectedAmountKobo} kobo)",
                ]);
                return response()->json(['status' => 'ok']);
            }

            $this->markPaymentSuccessful($payment, $data['reference'], $data, 'Paystack');
        }

        return response()->json(['status' => 'ok']);
    }

    // ─── FLUTTERWAVE: WEBHOOK (server-to-server) ─────────────────
    public function flutterwaveWebhook(Request $request)
    {
        // Verify secret hash header from Flutterwave
        $secretHash = config('services.flutterwave.secret_hash');
        $signature = $request->header('verif-hash');

        if (!$secretHash || !$signature || $signature !== $secretHash) {
            Log::warning('Flutterwave webhook: invalid verif-hash', [
                'ip' => $request->ip(),
            ]);
            return response()->json(['status' => 'error'], 400);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? '';
        $data = $payload['data'] ?? [];

        Log::info('Flutterwave webhook received', ['event' => $event]);

        if ($event === 'charge.completed' && ($data['status'] ?? '') === 'successful') {
            $txRef = $data['tx_ref'] ?? '';

            if (!$txRef) {
                return response()->json(['status' => 'ok']);
            }

            $payment = Payment::where('reference', $txRef)
                ->where('gateway', 'flutterwave')
                ->first();

            if (!$payment || $payment->status === 'successful') {
                return response()->json(['status' => 'ok']);
            }

            // Re-verify with Flutterwave API for security (don't trust webhook data alone)
            $transactionId = $data['id'] ?? null;
            if ($transactionId) {
                $verifyResult = $this->verifyFlutterwaveTransaction($transactionId);

                if (!$verifyResult || ($verifyResult['data']['status'] ?? '') !== 'successful') {
                    Log::warning('Flutterwave webhook: server verification failed', ['tx_ref' => $txRef]);
                    return response()->json(['status' => 'ok']);
                }

                $data = $verifyResult['data']; // Use verified data
            }

            // Verify amount and currency
            $paidAmount = (float) ($data['amount'] ?? 0);
            $paidCurrency = $data['currency'] ?? '';

            if ($paidAmount < (float) $payment->amount) {
                Log::warning('Flutterwave webhook: amount mismatch', [
                    'tx_ref' => $txRef,
                    'expected' => $payment->amount,
                    'received' => $paidAmount,
                ]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $data,
                    'admin_notes' => "Webhook: amount mismatch ({$paidAmount} vs {$payment->amount})",
                ]);
                return response()->json(['status' => 'ok']);
            }

            if ($paidCurrency && strtoupper($paidCurrency) !== strtoupper($payment->currency)) {
                Log::warning('Flutterwave webhook: currency mismatch', ['tx_ref' => $txRef]);
                $payment->update([
                    'status' => 'failed',
                    'gateway_response' => $data,
                    'admin_notes' => "Webhook: currency mismatch ({$paidCurrency} vs {$payment->currency})",
                ]);
                return response()->json(['status' => 'ok']);
            }

            $this->markPaymentSuccessful($payment, $data['flw_ref'] ?? $transactionId, $data, 'Flutterwave');
        }

        return response()->json(['status' => 'ok']);
    }

    // ─── INITIATE PAYSTACK ───────────────────────────────────────
    protected function initiatePaystack(Payment $payment)
    {
        $settings = Setting::getAllCached();

        $data = [
            'email' => auth()->user()->email,
            'amount' => (int) round($payment->amount * 100), // Convert to kobo
            'currency' => strtoupper($payment->currency ?? 'NGN'),
            'reference' => $payment->reference,
            'callback_url' => route('payment.paystack.callback'),
            'metadata' => [
                'payment_id' => $payment->id,
                'invoice_id' => $payment->invoice_id,
                'user_id' => auth()->id(),
                'custom_fields' => [
                    [
                        'display_name' => 'Invoice',
                        'variable_name' => 'invoice_number',
                        'value' => $payment->description,
                    ],
                ],
            ],
        ];

        $secret = config('services.paystack.secret_key');

        if (!$secret) {
            Log::error('Paystack secret key not configured');
            $payment->update(['status' => 'failed', 'admin_notes' => 'Paystack secret key missing']);
            return back()->with('error', 'Payment gateway not properly configured. Please contact support.');
        }

        try {
            $response = Http::withToken($secret)
                ->timeout(30)
                ->retry(2, 1000)
                ->post(config('services.paystack.base_url', 'https://api.paystack.co') . '/transaction/initialize', $data);

            $result = $response->json();

            Log::info('Paystack init response', [
                'reference' => $payment->reference,
                'status' => $result['status'] ?? false,
                'http_status' => $response->status(),
            ]);

            if ($response->successful() && ($result['status'] ?? false) && !empty($result['data']['authorization_url'])) {
                return redirect($result['data']['authorization_url']);
            }

            $errorMsg = $result['message'] ?? 'Unknown error';
            Log::error('Paystack initialization failed', [
                'reference' => $payment->reference,
                'error' => $errorMsg,
                'response' => $result,
            ]);

            $payment->update(['status' => 'failed', 'admin_notes' => "Init failed: {$errorMsg}"]);
            return back()->with('error', 'Could not initiate payment. Please try again.');

        } catch (\Exception $e) {
            Log::error('Paystack init exception', [
                'reference' => $payment->reference,
                'error' => $e->getMessage(),
            ]);
            $payment->update(['status' => 'failed', 'admin_notes' => 'Connection error: ' . $e->getMessage()]);
            return back()->with('error', 'Payment service is temporarily unavailable. Please try again.');
        }
    }

    // ─── INITIATE FLUTTERWAVE ────────────────────────────────────
    protected function initiateFlutterwave(Payment $payment)
    {
        $settings = Setting::getAllCached();
        $siteName = $settings['site_name'] ?? 'ICodeDev';
        $invoiceLogo = $settings['invoice_logo'] ?? $settings['logo_url'] ?? '';

        $data = [
            'tx_ref' => $payment->reference,
            'amount' => (float) $payment->amount,
            'currency' => strtoupper($payment->currency ?? 'NGN'),
            'redirect_url' => route('payment.flutterwave.callback'),
            'payment_options' => 'card,banktransfer,ussd,mobilemoney',
            'customer' => [
                'email' => auth()->user()->email,
                'name' => auth()->user()->name,
                'phonenumber' => auth()->user()->phone ?? '',
            ],
            'meta' => [
                'payment_id' => $payment->id,
                'invoice_id' => $payment->invoice_id,
            ],
            'customizations' => [
                'title' => "{$siteName} Payment",
                'description' => $payment->description,
                'logo' => $invoiceLogo ? asset($invoiceLogo) : '',
            ],
        ];

        $secret = config('services.flutterwave.secret_key');

        if (!$secret) {
            Log::error('Flutterwave secret key not configured');
            $payment->update(['status' => 'failed', 'admin_notes' => 'Flutterwave secret key missing']);
            return back()->with('error', 'Payment gateway not properly configured. Please contact support.');
        }

        try {
            $response = Http::withToken($secret)
                ->timeout(30)
                ->retry(2, 1000)
                ->post(config('services.flutterwave.base_url', 'https://api.flutterwave.com/v3') . '/payments', $data);

            $result = $response->json();

            Log::info('Flutterwave init response', [
                'reference' => $payment->reference,
                'status' => $result['status'] ?? '',
                'http_status' => $response->status(),
            ]);

            if ($response->successful() && ($result['status'] ?? '') === 'success' && !empty($result['data']['link'])) {
                return redirect($result['data']['link']);
            }

            $errorMsg = $result['message'] ?? 'Unknown error';
            Log::error('Flutterwave initialization failed', [
                'reference' => $payment->reference,
                'error' => $errorMsg,
                'response' => $result,
            ]);

            $payment->update(['status' => 'failed', 'admin_notes' => "Init failed: {$errorMsg}"]);
            return back()->with('error', 'Could not initiate payment. Please try again.');

        } catch (\Exception $e) {
            Log::error('Flutterwave init exception', [
                'reference' => $payment->reference,
                'error' => $e->getMessage(),
            ]);
            $payment->update(['status' => 'failed', 'admin_notes' => 'Connection error: ' . $e->getMessage()]);
            return back()->with('error', 'Payment service is temporarily unavailable. Please try again.');
        }
    }

    // ─── VERIFY PAYSTACK TRANSACTION ─────────────────────────────
    protected function verifyPaystackTransaction(string $reference): ?array
    {
        $secret = config('services.paystack.secret_key');

        if (!$secret) {
            return null;
        }

        try {
            $response = Http::withToken($secret)
                ->timeout(30)
                ->retry(2, 1000)
                ->get(config('services.paystack.base_url', 'https://api.paystack.co') . "/transaction/verify/{$reference}");

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                return $result;
            }

            Log::error('Paystack verify failed', [
                'reference' => $reference,
                'http_status' => $response->status(),
                'response' => $result,
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Paystack verify exception', [
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    // ─── VERIFY FLUTTERWAVE TRANSACTION ──────────────────────────
    protected function verifyFlutterwaveTransaction(string|int $transactionId): ?array
    {
        $secret = config('services.flutterwave.secret_key');

        if (!$secret) {
            return null;
        }

        try {
            $response = Http::withToken($secret)
                ->timeout(30)
                ->retry(2, 1000)
                ->get(config('services.flutterwave.base_url', 'https://api.flutterwave.com/v3') . "/transactions/{$transactionId}/verify");

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? '') === 'success') {
                return $result;
            }

            Log::error('Flutterwave verify failed', [
                'transaction_id' => $transactionId,
                'http_status' => $response->status(),
                'response' => $result,
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Flutterwave verify exception', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    // ─── MARK PAYMENT SUCCESSFUL (shared logic) ──────────────────
    protected function markPaymentSuccessful(Payment $payment, string $gatewayReference, array $gatewayResponse, string $gatewayName): void
    {
        // Use DB transaction for atomicity
        DB::transaction(function () use ($payment, $gatewayReference, $gatewayResponse, $gatewayName) {
            // Lock the row to prevent race conditions between webhook + callback
            $payment = Payment::lockForUpdate()->find($payment->id);

            // Double-check idempotency inside the lock
            if ($payment->status === 'successful') {
                return;
            }

            $payment->update([
                'status' => 'successful',
                'gateway_reference' => $gatewayReference,
                'gateway_response' => $gatewayResponse,
            ]);

            if ($payment->project_id) {
                $payment->project->increment('total_paid', $payment->amount);
            }

            // Mark invoice as paid
            $invoice = $payment->invoice_id
                ? Invoice::find($payment->invoice_id)
                : Invoice::where('project_id', $payment->project_id)
                    ->where('user_id', $payment->user_id)
                    ->whereIn('status', ['sent', 'pending'])
                    ->first();

            if ($invoice && $invoice->status !== 'paid') {
                $invoice->update(['status' => 'paid', 'paid_date' => now()]);
            }

            $settings = Setting::getAllCached();
            ActivityLog::log(
                'payment_success',
                "Payment of " . ($settings['currency_symbol'] ?? '₦') . number_format($payment->amount, 2) . " successful via {$gatewayName}",
                $payment
            );

            // Notify user (don't let mail failures crash the payment flow)
            try {
                if ($payment->user) {
                    $payment->user->notify(new PaymentReceived($payment));
                }
            } catch (\Exception $e) {
                Log::warning("Payment notification failed for payment #{$payment->id}: " . $e->getMessage());
            }
        });
    }
}
