<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $assignedProjects = $user->assignedProjects()->with('client', 'service')->latest()->get();
        $tasks = $user->tasks()->with('project')->where('status', '!=', 'done')->orderBy('due_date')->get();
        $completedTasks = $user->tasks()->where('status', 'done')->count();
        $pendingTasks = $user->tasks()->where('status', '!=', 'done')->count();

        $stats = [
            'total_projects' => $assignedProjects->count(),
            'active_projects' => $assignedProjects->where('status', 'in_progress')->count(),
            'total_tasks' => $user->tasks()->count(),
            'completed_tasks' => $completedTasks,
            'pending_tasks' => $pendingTasks,
        ];

        return view('developer.dashboard', compact('assignedProjects', 'tasks', 'stats'));
    }
}
