<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('project', 'assignedUser', 'creator');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tasks = $query->latest()->paginate(20);
        $projects = Project::all();
        $developers = User::whereIn('role', ['developer', 'manager'])->get();

        return view('admin.tasks.index', compact('tasks', 'projects', 'developers'));
    }

    public function create()
    {
        $projects = Project::whereNotIn('status', ['completed', 'cancelled'])->get();
        $developers = User::whereIn('role', ['developer', 'manager'])->where('is_active', true)->get();
        $task = new Task;
        return view('admin.tasks.form', compact('task', 'projects', 'developers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'todo';

        $task = Task::create($validated);

        if ($task->assigned_to && $task->assignedUser) {
            $task->assignedUser->notify(new TaskAssigned($task));
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created.');
    }

    public function edit(Task $task)
    {
        $projects = Project::whereNotIn('status', ['completed', 'cancelled'])->get();
        $developers = User::whereIn('role', ['developer', 'manager'])->where('is_active', true)->get();
        return view('admin.tasks.form', compact('task', 'projects', 'developers'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:todo,in_progress,review,done',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
        ]);

        if ($validated['status'] === 'done' && $task->status !== 'done') {
            $validated['completed_at'] = now();
        }

        $oldAssignedTo = $task->assigned_to;

        $task->update($validated);

        if ($validated['assigned_to'] && $validated['assigned_to'] != $oldAssignedTo && $task->assignedUser) {
            $task->assignedUser->notify(new TaskAssigned($task));
        }

        return back()->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted.');
    }
}
