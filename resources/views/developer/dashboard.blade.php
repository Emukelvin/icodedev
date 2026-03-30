@extends('layouts.dashboard')
@section('title', 'Developer Dashboard - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-sm text-white/50 mt-1">Here's an overview of your tasks and projects</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Assigned Projects</p><p class="text-2xl font-black text-primary-400">{{ $stats['total_projects'] }}</p></div><div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-project-diagram text-primary-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Open Tasks</p><p class="text-2xl font-black text-blue-400">{{ $stats['pending_tasks'] }}</p></div><div class="w-12 h-12 bg-blue-500/15 ring-1 ring-blue-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-tasks text-blue-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">In Progress</p><p class="text-2xl font-black text-amber-400">{{ $stats['active_projects'] }}</p></div><div class="w-12 h-12 bg-amber-500/15 ring-1 ring-amber-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-spinner text-amber-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Completed Tasks</p><p class="text-2xl font-black text-emerald-400">{{ $stats['completed_tasks'] }}</p></div><div class="w-12 h-12 bg-emerald-500/15 ring-1 ring-emerald-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-check-circle text-emerald-400"></i></div></div></div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <div class="flex items-center justify-between mb-5"><h2 class="text-sm font-bold text-white/40 uppercase tracking-wider">My Tasks</h2><a href="{{ route('developer.tasks.index') }}" class="text-primary-400 text-sm hover:text-primary-300">View All</a></div>
        <div class="space-y-3">
            @forelse($tasks as $task)
            <a href="{{ route('developer.tasks.show', $task) }}" class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/4 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-500' : ($task->priority === 'high' ? 'bg-orange-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-white/30')) }}"></span>
                    <div><h3 class="font-semibold text-sm text-white/90">{{ $task->title }}</h3><p class="text-xs text-white/50">{{ $task->project?->title }}</p></div>
                </div>
                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($task->status === 'review' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
            </a>
            @empty
            <p class="text-white/30 text-center py-8">No tasks assigned.</p>
            @endforelse
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <div class="flex items-center justify-between mb-5"><h2 class="text-sm font-bold text-white/40 uppercase tracking-wider">My Projects</h2><a href="{{ route('developer.projects') }}" class="text-primary-400 text-sm hover:text-primary-300">View All</a></div>
        <div class="space-y-3">
            @forelse($assignedProjects as $project)
            <a href="{{ route('developer.projects.show', $project) }}" class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/4 transition-all duration-300">
                <div><h3 class="font-semibold text-sm text-white/90">{{ $project->title }}</h3><p class="text-xs text-white/50">{{ $project->client->name }}</p></div>
                <div class="text-right"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span><div class="w-16 bg-white/10 rounded-full h-1.5 mt-1"><div class="bg-primary-500 h-1.5 rounded-full" style="width:{{ $project->progress }}%"></div></div></div>
            </a>
            @empty
            <p class="text-white/30 text-center py-8">No projects assigned.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
