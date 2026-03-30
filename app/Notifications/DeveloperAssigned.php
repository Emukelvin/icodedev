<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeveloperAssigned extends Notification
{
    use Queueable;

    public function __construct(
        protected Project $project,
        protected array $developerNames = []
    ) {}

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
            ->subject("Team Assigned to Your Project — {$siteName}")
            ->view('emails.developer-assigned', [
                'user' => $notifiable,
                'project' => $this->project,
                'developerNames' => $this->developerNames,
                'siteName' => $siteName,
                'icon' => '👥',
                'title' => 'Team Assigned',
                'subtitle' => $this->project->title,
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/projects/' . $this->project->slug),
                'actionText' => 'View Project',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'developer_assigned',
            'message' => "A development team has been assigned to \"{$this->project->title}\".",
            'project_id' => $this->project->id,
            'project_slug' => $this->project->slug,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_developer_assigned'] ?? '1') === '1';
    }
}
