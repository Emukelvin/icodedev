<?php

namespace App\Notifications;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterSubscribed extends Notification
{
    use Queueable;

    public function __construct(protected string $email) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $s = Setting::getAllCached();
        $siteName = $s['site_name'] ?? 'ICodeDev';

        return (new MailMessage)
            ->subject("Welcome to the {$siteName} Newsletter! 📬")
            ->view('emails.newsletter-subscribed', [
                'email' => $this->email,
                'siteName' => $siteName,
                'siteUrl' => config('app.url'),
                'icon' => '📬',
                'title' => "You're In!",
                'subtitle' => 'Newsletter subscription confirmed',
                'greeting' => 'Hello there,',
                'actionUrl' => config('app.url') . '/blog',
                'actionText' => 'Read Our Blog',
            ]);
    }
}
