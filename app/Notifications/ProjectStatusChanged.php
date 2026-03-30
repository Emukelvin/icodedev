<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        protected Project $project,
        protected string $oldStatus,
        protected string $newStatus
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
            ->subject("Project Update: {$this->project->title} — {$siteName}")
            ->view('emails.project-status-changed', [
                'user' => $notifiable,
                'project' => $this->project,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'siteName' => $siteName,
                'icon' => '🔄',
                'title' => 'Project Status Updated',
                'subtitle' => $this->project->title,
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/projects/' . $this->project->slug),
                'actionText' => 'View Project',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'project_status',
            'message' => "Project \"{$this->project->title}\" status changed to " . ucfirst(str_replace('_', ' ', $this->newStatus)),
            'project_id' => $this->project->id,
            'project_slug' => $this->project->slug,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_project_status'] ?? '1') === '1';
    }
}
