@extends('layouts.dashboard')
@section('title', 'My Projects - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Assigned Projects</h1>
    <p class="text-sm text-white/50 mt-1">Projects you're currently working on</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
    <a href="{{ route('developer.projects.show', $project) }}" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 hover:border-white/12 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span>
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($project->priority === 'high' ? 'bg-orange-500/15 text-orange-400 ring-1 ring-orange-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst($project->priority) }}</span>
        </div>
        <h3 class="font-bold text-lg text-white group-hover:text-primary-400 transition mb-1">{{ $project->title }}</h3>
        <p class="text-sm text-white/50 mb-4">{{ $project->client->name }}</p>
        <div class="flex items-center gap-2 mb-2"><div class="flex-1 bg-white/10 rounded-full h-2"><div class="bg-primary-500 h-2 rounded-full" style="width:{{ $project->progress }}%"></div></div><span class="text-sm font-semibold text-white/90">{{ $project->progress }}%</span></div>
        <div class="flex items-center justify-between text-xs text-white/50 mt-3">
            <span><i class="fas fa-tasks mr-1"></i>{{ $project->tasks_count ?? $project->tasks()->count() }} tasks</span>
            <span>{{ $project->deadline?->format('M d, Y') ?? '-' }}</span>
        </div>
    </a>
    @empty
    <div class="col-span-3 text-center py-12"><p class="text-white/30">No projects assigned.</p></div>
    @endforelse
</div>
@endsection
