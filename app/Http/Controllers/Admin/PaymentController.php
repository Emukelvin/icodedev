<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use App\Models\CryptoWallet;
use App\Notifications\InvoiceSent;
use App\Notifications\PaymentReceived;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('user', 'project');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20);
        $totalRevenue = Payment::successful()->sum('amount');
        $monthlyRevenue = Payment::successful()->whereMonth('created_at', now()->month)->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'monthlyRevenue'));
    }

    public function showPayment(Payment $payment)
    {
        $payment->load(['user', 'project']);
        return view('admin.payments.show', compact('payment'));
    }

    public function showInvoice(Invoice $invoice)
    {
        $invoice->load(['user', 'project', 'items']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function invoices(Request $request)
    {
        $query = Invoice::with('user', 'project');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function createInvoice()
    {
        $clients = User::where('role', 'client')->orderBy('name')->get();
        $invoice = new Invoice;
        return view('admin.invoices.form', compact('invoice', 'clients'));
    }

    public function clientProjects(User $user)
    {
        $projects = Project::where('client_id', $user->id)
            ->select('id', 'title', 'status', 'budget', 'total_paid')
            ->orderBy('title')
            ->get()
            ->map(function ($project) {
                $balance = $project->budget - $project->total_paid;
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'status' => $project->status,
                    'budget' => (float) $project->budget,
                    'total_paid' => (float) $project->total_paid,
                    'balance' => round($balance, 2),
                    'is_paid' => $balance <= 0,
                ];
            });

        return response()->json($projects);
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'due_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,sent,pending,paid,overdue,cancelled',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $tax = (float) ($validated['tax'] ?? 0);
        $discount = (float) ($validated['discount'] ?? 0);
        $total = $subtotal + $tax - $discount;

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateNumber(),
            'user_id' => $validated['user_id'],
            'project_id' => $validated['project_id'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
            'status' => $validated['status'] ?? 'draft',
            'due_date' => $validated['due_date'],
            'notes' => $validated['notes'],
        ]);

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function sendInvoice(Invoice $invoice)
    {
        $invoice->update(['status' => 'sent']);

        if ($invoice->user) {
            $invoice->user->notify(new InvoiceSent($invoice));
        }

        return back()->with('success', 'Invoice sent to client.');
    }

    public function editInvoice(Invoice $invoice)
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.invoices.form', compact('invoice', 'clients'));
    }

    public function updateInvoice(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'status' => 'required|in:draft,sent,pending,paid,overdue,cancelled',
            'due_date' => 'required|date',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = collect($validated['items'])->sum(fn($i) => $i['quantity'] * $i['unit_price']);
        $tax = (float) ($validated['tax'] ?? 0);
        $discount = (float) ($validated['discount'] ?? 0);
        $total = $subtotal + $tax - $discount;

        $invoice->update([
            'user_id' => $validated['user_id'],
            'project_id' => $validated['project_id'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'notes' => $validated['notes'] ?? null,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => $total,
        ]);

        $invoice->items()->delete();
        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroyInvoice(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted.');
    }

    public function refundPayment(Payment $payment)
    {
        $payment->update(['status' => 'refunded']);

        if ($payment->project_id) {
            $payment->project->decrement('total_paid', $payment->amount);
        }

        return back()->with('success', 'Payment refunded.');
    }

    public function approvePayment(Request $request, Payment $payment)
    {
        $payment->update([
            'status' => 'successful',
            'admin_notes' => $request->admin_notes,
        ]);

        if ($payment->project_id) {
            $payment->project->increment('total_paid', $payment->amount);
        }

        // Try to match by direct invoice_id first, then fallback to project matching
        $invoice = $payment->invoice_id
            ? Invoice::find($payment->invoice_id)
            : Invoice::where('project_id', $payment->project_id)
                ->where('user_id', $payment->user_id)
                ->whereIn('status', ['sent', 'pending'])
                ->first();

        if ($invoice) {
            $invoice->update(['status' => 'paid', 'paid_date' => now()]);
        }

        if ($payment->user) {
            $payment->user->notify(new PaymentReceived($payment));
        }

        return back()->with('success', 'Payment approved.');
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        $payment->update([
            'status' => 'failed',
            'admin_notes' => $request->admin_notes,
        ]);

        // Revert invoice status from pending back to sent so client can retry
        $invoice = $payment->invoice_id
            ? Invoice::find($payment->invoice_id)
            : null;

        if ($invoice && $invoice->status === 'pending') {
            $invoice->update(['status' => 'sent']);
        }

        return back()->with('success', 'Payment rejected.');
    }

    // ─── CRYPTO WALLETS ──────────────────────────────────────

    public function cryptoWallets()
    {
        $wallets = CryptoWallet::orderBy('sort_order')->get();
        return view('admin.payments.crypto-wallets', compact('wallets'));
    }

    public function storeCryptoWallet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'network' => 'nullable|string|max:50',
            'wallet_address' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        CryptoWallet::create($request->only(['name', 'symbol', 'network', 'wallet_address', 'icon', 'is_active', 'sort_order']));

        return back()->with('success', 'Crypto wallet added.');
    }

    public function updateCryptoWallet(Request $request, CryptoWallet $wallet)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'symbol' => 'required|string|max:10',
            'network' => 'nullable|string|max:50',
            'wallet_address' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $wallet->update($request->only(['name', 'symbol', 'network', 'wallet_address', 'icon', 'is_active', 'sort_order']));

        return back()->with('success', 'Crypto wallet updated.');
    }

    public function destroyCryptoWallet(CryptoWallet $wallet)
    {
        $wallet->delete();
        return back()->with('success', 'Crypto wallet deleted.');
    }
}
