<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification
{
    use Queueable;

    public function __construct(protected Task $task) {}

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
            ->subject("New Task Assigned: {$this->task->title} — {$siteName}")
            ->view('emails.task-updated', [
                'user' => $notifiable,
                'task' => $this->task,
                'updateType' => 'status',
                'detail' => 'Assigned to you',
                'siteName' => $siteName,
                'icon' => '📋',
                'title' => 'New Task Assigned',
                'subtitle' => $this->task->project?->title,
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/developer/tasks/' . $this->task->id),
                'actionText' => 'View Task',
                'projectUrl' => url('/developer/tasks/' . $this->task->id),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_assigned',
            'message' => "New task assigned: \"{$this->task->title}\"",
            'task_id' => $this->task->id,
            'project_id' => $this->task->project_id,
            'priority' => $this->task->priority,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_task_assigned'] ?? '1') === '1';
    }
}
