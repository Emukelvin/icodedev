<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification
{
    use Queueable;

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
        $siteName = $s['site_name'] ?? 'ICodeDev';

        return (new MailMessage)
            ->subject("Welcome to {$siteName}!")
            ->view('emails.welcome', [
                'user' => $notifiable,
                'siteName' => $siteName,
                'icon' => '🎉',
                'title' => 'Welcome Aboard!',
                'subtitle' => "Your account is ready",
                'greeting' => "Hi {$notifiable->name},",
                'actionUrl' => url('/client/dashboard'),
                'actionText' => 'Go to Dashboard',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'welcome',
            'message' => 'Welcome! Your account has been created successfully.',
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_welcome'] ?? '1') === '1';
    }
}
