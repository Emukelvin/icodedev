<?php

namespace App\Notifications;

use App\Models\QuoteRequest;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteRequestReceived extends Notification
{
    use Queueable;

    public function __construct(protected QuoteRequest $quote) {}

    public function via(object $notifiable): array
    {
        if (!self::isEnabled()) {
            return [];
        }
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $s = Setting::getAllCached();
        $siteName = $s['site_name'] ?? 'ICodeDev';

        return (new MailMessage)
            ->subject("Quote Request Received — {$siteName}")
            ->view('emails.quote-received', [
                'quote' => $this->quote,
                'siteName' => $siteName,
                'icon' => '📝',
                'title' => 'Quote Request Received',
                'subtitle' => "We'll get back to you shortly",
                'greeting' => "Hello {$this->quote->name},",
            ]);
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_quote_request'] ?? '1') === '1';
    }
}
