<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectUpdate;
use App\Models\ProjectFile;
use App\Models\ActivityLog;
use App\Notifications\DeveloperAssigned;
use App\Notifications\ProjectStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('client', 'service', 'manager');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $projects = $query->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->where('is_active', true)->get();
        $developers = User::whereIn('role', ['developer', 'manager'])->where('is_active', true)->get();
        $managers = User::whereIn('role', ['admin', 'manager'])->where('is_active', true)->get();
        $services = \App\Models\Service::where('is_active', true)->get();
        $project = new Project;
        return view('admin.projects.form', compact('project', 'clients', 'developers', 'managers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            'manager_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'status' => 'required|in:pending,in_progress,review,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'technologies' => 'nullable|string',
            'developers' => 'nullable|array',
            'developers.*' => 'exists:users,id',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        unset($validated['developers']);
        $project = Project::create($validated);

        if ($request->filled('developers')) {
            $project->developers()->attach($request->developers);
        }

        ActivityLog::log('project_created', "Project '{$project->title}' created", $project);

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'service', 'manager', 'developers', 'updates.user', 'files.user', 'tasks.assignedUser', 'comments.user', 'payments', 'invoices']);
        $developers = User::whereIn('role', ['developer', 'manager'])->where('is_active', true)->get();
        return view('admin.projects.show', compact('project', 'developers'));
    }

    public function edit(Project $project)
    {
        $clients = User::where('role', 'client')->where('is_active', true)->get();
        $developers = User::whereIn('role', ['developer', 'manager'])->where('is_active', true)->get();
        $managers = User::whereIn('role', ['admin', 'manager'])->where('is_active', true)->get();
        $services = \App\Models\Service::where('is_active', true)->get();
        return view('admin.projects.form', compact('project', 'clients', 'developers', 'managers', 'services'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            'manager_id' => 'nullable|exists:users,id',
            'service_id' => 'nullable|exists:services,id',
            'status' => 'required|in:pending,in_progress,review,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'progress' => 'nullable|integer|min:0|max:100',
            'technologies' => 'nullable|string',
            'live_url' => 'nullable|url|max:255',
            'repository_url' => 'nullable|url|max:255',
            'developers' => 'nullable|array',
            'developers.*' => 'exists:users,id',
        ]);

        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }

        if ($validated['status'] === 'completed' && $project->status !== 'completed') {
            $validated['completed_at'] = now();
            $validated['progress'] = 100;
        }

        $oldStatus = $project->status;

        unset($validated['developers']);
        $project->update($validated);

        if ($request->has('developers')) {
            $oldDeveloperIds = $project->developers()->pluck('users.id')->toArray();
            $project->developers()->sync($request->developers ?? []);

            $newDeveloperIds = $request->developers ?? [];
            if ($oldDeveloperIds != $newDeveloperIds && $project->client && !empty($newDeveloperIds)) {
                $developerNames = User::whereIn('id', $newDeveloperIds)->pluck('name')->toArray();
                $project->client->notify(new DeveloperAssigned($project, $developerNames));
            }
        }

        if ($oldStatus !== $project->status && $project->client) {
            $project->client->notify(new ProjectStatusChanged($project, $oldStatus, $project->status));
        }

        ActivityLog::log('project_updated', "Project '{$project->title}' updated", $project);

        return redirect()->route('admin.projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    public function addUpdate(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'status' => 'nullable|in:pending,in_progress,review,completed',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        ProjectUpdate::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'progress_percentage' => $request->progress_percentage,
        ]);

        if ($request->filled('progress_percentage')) {
            $project->update(['progress' => $request->progress_percentage]);
        }
        if ($request->filled('status')) {
            $project->update(['status' => $request->status]);
        }

        return back()->with('success', 'Project update added.');
    }

    public function uploadFile(Request $request, Project $project)
    {
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

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted.');
    }
}
