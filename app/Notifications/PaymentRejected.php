<?php

namespace App\Notifications;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification
{
    use Queueable;

    public function __construct(protected Payment $payment) {}

    public function via(object $notifiable): array
    {
        if (!self::isEnabled()) {
            return ['database'];
        }
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $s = Setting::getAllCached();
        $cs = $s['currency_symbol'] ?? '₦';
        $siteName = $s['site_name'] ?? 'ICodeDev';

        return (new MailMessage)
            ->subject("Payment Not Approved — {$siteName}")
            ->view('emails.payment-rejected', [
                'user' => $notifiable,
                'payment' => $this->payment,
                'cs' => $cs,
                'siteName' => $siteName,
                'icon' => '⚠️',
                'iconBg' => '#ef4444',
                'title' => 'Payment Not Approved',
                'subtitle' => "Reference: {$this->payment->reference}",
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/payments'),
                'actionText' => 'View Payment Details',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        $cs = Setting::getAllCached()['currency_symbol'] ?? '₦';
        return [
            'type' => 'payment_rejected',
            'message' => "Payment of {$cs}" . number_format($this->payment->amount, 2) . " was not approved.",
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'reference' => $this->payment->reference,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_payment_received'] ?? '1') === '1';
    }
}
