<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormReceived extends Notification
{
    use Queueable;

    public function __construct(protected ContactSubmission $contact) {}

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
            ->subject("We Received Your Message — {$siteName}")
            ->view('emails.contact-received', [
                'contact' => $this->contact,
                'siteName' => $siteName,
                'icon' => '📩',
                'title' => 'Message Received',
                'subtitle' => "We'll respond within 24 hours",
                'greeting' => "Hello {$this->contact->name},",
            ]);
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_contact_form'] ?? '1') === '1';
    }
}
