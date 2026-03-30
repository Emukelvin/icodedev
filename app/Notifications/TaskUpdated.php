<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskUpdated extends Notification
{
    use Queueable;

    public function __construct(
        protected Task $task,
        protected string $updateType = 'status',
        protected string $detail = ''
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

        $subjects = [
            'status' => "Task Status Updated — {$siteName}",
            'comment' => "New Comment on Task — {$siteName}",
            'file' => "File Uploaded to Task — {$siteName}",
        ];

        return (new MailMessage)
            ->subject($subjects[$this->updateType] ?? "Task Update — {$siteName}")
            ->view('emails.task-updated', [
                'user' => $notifiable,
                'task' => $this->task,
                'updateType' => $this->updateType,
                'detail' => $this->detail,
                'siteName' => $siteName,
                'icon' => match($this->updateType) { 'comment' => '💬', 'file' => '📎', default => '📋' },
                'title' => match($this->updateType) { 'comment' => 'New Comment', 'file' => 'File Uploaded', default => 'Task Updated' },
                'subtitle' => $this->task->title,
                'greeting' => "Hello {$notifiable->name},",
                'actionUrl' => url('/client/projects/' . ($this->task->project?->slug ?? $this->task->project_id)),
                'actionText' => 'View Project',
                'projectUrl' => url('/client/projects/' . ($this->task->project?->slug ?? $this->task->project_id)),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        $messages = [
            'status' => "Task \"{$this->task->title}\" status changed to {$this->detail}.",
            'comment' => "New comment on task \"{$this->task->title}\".",
            'file' => "A file was uploaded to task \"{$this->task->title}\".",
        ];

        return [
            'type' => 'task_updated',
            'message' => $messages[$this->updateType] ?? "Task \"{$this->task->title}\" was updated.",
            'task_id' => $this->task->id,
            'project_id' => $this->task->project_id,
            'update_type' => $this->updateType,
        ];
    }

    public static function isEnabled(): bool
    {
        return (Setting::getAllCached()['notify_task_updated'] ?? '1') === '1';
    }
}
