<?php

namespace App\Notifications;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceSent extends Notification
{
    use Queueable;

    public function __construct(protected Invoice $invoice) {}

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
            ->subject("Invoice #{$this->invoice->invoice_number} — {$siteName}")
            ->view('emails.invoice-sent', [
                'user' => $notifiable,
                'invoice' => $this->invoice,
                'cs' => $cs,
                'siteName' => $siteName,
                'icon' => '📄',
                'title' => 'New Invoice',
                'subtitle' => "Invoice #{$this->invoice->invoice_number}",
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/invoices/' . $this->invoice->id),
                'actionText' => 'View & Pay Invoice',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        $cs = Setting::getAllCached()['currency_symbol'] ?? '₦';
        return [
            'type' => 'invoice_sent',
            'message' => "Invoice #{$this->invoice->invoice_number} for {$cs}" . number_format($this->invoice->total, 2) . " is ready.",
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->total,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_invoice_sent'] ?? '1') === '1';
    }
}
