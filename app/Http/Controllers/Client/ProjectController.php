<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\ProjectComment;
use App\Models\Service;
use App\Models\ActivityLog;
use App\Notifications\ProjectCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->clientProjects()
            ->with('service', 'manager')
            ->latest()
            ->paginate(10);

        return view('client.projects.index', compact('projects'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('client.projects.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:10000',
            'service_id' => 'required|exists:services,id',
            'requirements' => 'nullable|string|max:20000',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $validated['client_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['status'] = 'pending';

        $project = Project::create($validated);

        ActivityLog::log('project_created', 'New project request submitted', $project);

        auth()->user()->notify(new ProjectCreated($project));

        return redirect()->route('client.projects.show', $project)
            ->with('success', 'Project request submitted successfully!');
    }

    public function show(Project $project)
    {
        $this->authorizeClient($project);

        $project->load(['service', 'manager', 'developers', 'updates', 'files', 'tasks', 'comments.user', 'comments.replies.user']);

        return view('client.projects.show', compact('project'));
    }

    public function uploadFile(Request $request, Project $project)
    {
        $this->authorizeClient($project);

        $request->validate([
            'file' => 'required|file|max:20480',
            'description' => 'nullable|string|max:500',
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
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    public function addComment(Request $request, Project $project)
    {
        $this->authorizeClient($project);

        $request->validate([
            'body' => 'required|string|max:5000',
            'parent_id' => 'nullable|exists:project_comments,id',
        ]);

        ProjectComment::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Comment added.');
    }

    public function downloads()
    {
        $deliverables = ProjectFile::whereHas('project', function ($q) {
                $q->where('client_id', auth()->id());
            })
            ->where('is_deliverable', true)
            ->with('project')
            ->latest()
            ->paginate(20);

        return view('client.downloads', compact('deliverables'));
    }

    protected function authorizeClient(Project $project): void
    {
        if ($project->client_id !== auth()->id()) {
            abort(403);
        }
    }
}
