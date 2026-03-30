<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    use Queueable;

    public function __construct(protected Project $project) {}

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
            ->subject("Project Submitted — {$siteName}")
            ->view('emails.project-created', [
                'user' => $notifiable,
                'project' => $this->project,
                'siteName' => $siteName,
                'icon' => '🚀',
                'title' => 'Project Submitted',
                'subtitle' => $this->project->title,
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/projects/' . $this->project->id),
                'actionText' => 'View Project',
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'project_created',
            'message' => "Your project \"{$this->project->title}\" has been submitted.",
            'project_id' => $this->project->id,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_project_created'] ?? '1') === '1';
    }
}
