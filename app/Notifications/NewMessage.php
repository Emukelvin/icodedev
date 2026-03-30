<?php

namespace App\Notifications;

use App\Models\Message;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewMessage extends Notification
{
    use Queueable;

    public function __construct(protected Message $message) {}

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
        $senderName = $this->message->user?->name ?? 'Someone';

        $role = $notifiable->role ?? 'client';
        $dashboardPrefix = match($role) {
            'admin' => '/admin',
            'manager' => '/admin',
            'developer' => '/developer',
            default => '/client',
        };

        return (new MailMessage)
            ->subject("New Message from {$senderName} — {$siteName}")
            ->view('emails.message-received', [
                'user' => $notifiable,
                'senderName' => $senderName,
                'messageBody' => $this->message->body,
                'siteName' => $siteName,
                'icon' => '💬',
                'title' => 'New Message',
                'subtitle' => "From {$senderName}",
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url($dashboardPrefix . '/messages/' . $this->message->conversation_id),
                'actionText' => 'View Conversation',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_message',
            'message' => "{$this->message->user?->name} sent you a message.",
            'conversation_id' => $this->message->conversation_id,
            'sender_name' => $this->message->user?->name,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_new_message'] ?? '1') === '1';
    }
}
