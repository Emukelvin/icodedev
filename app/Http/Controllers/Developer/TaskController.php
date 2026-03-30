<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskAttachment;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ActivityLog;
use App\Notifications\TaskUpdated;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('project');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('project')) {
            $query->where('project_id', $request->project);
        }

        $tasks = $query->orderByRaw("FIELD(status, 'in_progress', 'todo', 'review', 'done')")
            ->orderBy('due_date')
            ->paginate(20);

        return view('developer.tasks.index', compact('tasks'));
    }

    public function kanban()
    {
        $tasks = auth()->user()->tasks()->with('project')->get()->groupBy('status');

        return view('developer.tasks.kanban', compact('tasks'));
    }

    public function show(Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $task->load(['project', 'comments.user', 'attachments']);
        return view('developer.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:todo,in_progress,review,done',
        ]);

        $task->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'done' ? now() : null,
        ]);

        ActivityLog::log('task_status_updated', "Task '{$task->title}' status changed to {$request->status}", $task);

        try {
            if ($task->project && $task->project->client) {
                $task->project->client->notify(new TaskUpdated($task, 'status', $request->status));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('success', 'Task status updated.');
    }

    public function addComment(Request $request, Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:5000']);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        try {
            if ($task->project && $task->project->client) {
                $task->project->client->notify(new TaskUpdated($task, 'comment', $request->body));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('success', 'Comment added.');
    }

    public function uploadAttachment(Request $request, Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403);
        }

        $request->validate(['file' => 'required|file|max:20480']);

        $file = $request->file('file');
        $path = $file->store('task-attachments/' . $task->id, 'public');

        TaskAttachment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        try {
            if ($task->project && $task->project->client) {
                $task->project->client->notify(new TaskUpdated($task, 'file', $file->getClientOriginalName()));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('success', 'File uploaded.');
    }

    public function projects()
    {
        $projects = auth()->user()->assignedProjects()->with('client', 'service', 'tasks')->latest()->get();
        return view('developer.projects.index', compact('projects'));
    }

    public function projectShow(Project $project)
    {
        if (!$project->developers()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }

        $project->load(['client', 'tasks.assignedUser', 'files', 'updates', 'comments.user']);
        return view('developer.projects.show', compact('project'));
    }

    public function uploadProjectFile(Request $request, Project $project)
    {
        if (!$project->developers()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|max:51200',
            'description' => 'nullable|string|max:500',
            'is_deliverable' => 'nullable|boolean',
        ]);

        $file = $request->file('file');
        $path = $file->store('project-files/' . $project->id, 'public');

        ProjectFile::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'description' => $request->description,
            'is_deliverable' => $request->boolean('is_deliverable'),
        ]);

        return back()->with('success', 'File uploaded.');
    }
}
