@extends('layouts.dashboard')
@section('title', $project->title . ' - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('developer.projects') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1"><h1 class="text-2xl font-black text-white">{{ $project->title }}</h1><p class="text-sm text-white/50 mt-1">{{ $project->client->name }}</p></div>
    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span>
</div>

<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><p class="text-sm text-white/50">Progress</p><p class="text-2xl font-black text-primary-400">{{ $project->progress }}%</p><div class="w-full bg-white/10 rounded-full h-2 mt-2"><div class="bg-primary-500 h-2 rounded-full" style="width:{{ $project->progress }}%"></div></div></div>
    <div class="stat-card"><p class="text-sm text-white/50">Total Tasks</p><p class="text-2xl font-black text-white">{{ $project->tasks->count() }}</p></div>
    <div class="stat-card"><p class="text-sm text-white/50">My Tasks</p><p class="text-2xl font-black text-white">{{ $project->tasks->where('assigned_to', auth()->id())->count() }}</p></div>
    <div class="stat-card"><p class="text-sm text-white/50">Deadline</p><p class="text-2xl font-black text-white">{{ $project->deadline?->format('M d') ?? '-' }}</p></div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Description</h2><div class="prose max-w-none text-white/70">{!! nl2br(e($project->description)) !!}</div></div>

        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">My Tasks</h2>
            <div class="space-y-3">
                @foreach($project->tasks->where('assigned_to', auth()->id()) as $task)
                <a href="{{ route('developer.tasks.show', $task) }}" class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/4 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-500' : ($task->priority === 'high' ? 'bg-orange-500' : 'bg-white/30') }}"></span>
                        <span class="font-semibold text-sm text-white/90">{{ $task->title }}</span>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->status === 'done' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Updates</h2>
            <div class="space-y-4">
                @foreach($project->updates()->with('user')->latest()->take(10)->get() as $update)
                <div class="border-l-4 border-primary-500 pl-4"><div class="flex gap-2 mb-1"><span class="font-semibold text-sm text-white/90">{{ $update->user->name }}</span><span class="text-xs text-white/50">{{ $update->created_at->diffForHumans() }}</span></div><p class="text-white/70 text-sm">{{ $update->content }}</p></div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Team</h3>
            <div class="space-y-2">
                @if($project->manager)<div class="flex items-center gap-2 p-2"><div class="w-8 h-8 bg-amber-500/15 ring-1 ring-amber-500/20 rounded-full flex items-center justify-center text-amber-400 font-bold text-xs">PM</div><div><p class="font-semibold text-sm text-white/90">{{ $project->manager->name }}</p><p class="text-xs text-white/50">Manager</p></div></div>@endif
                @foreach($project->developers as $dev)<div class="flex items-center gap-2 p-2"><div class="w-8 h-8 bg-blue-500/15 ring-1 ring-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">{{ substr($dev->name, 0, 1) }}</div><div><p class="font-semibold text-sm text-white/90">{{ $dev->name }}</p><p class="text-xs text-white/50">Developer</p></div></div>@endforeach
            </div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Files</h3>
            <div class="space-y-2 mb-4">@foreach($project->files as $file)<a href="{{ Storage::url($file->path) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/4 text-sm text-white/90" target="_blank"><i class="fas fa-file text-white/30"></i><span class="truncate">{{ $file->original_name }}</span></a>@endforeach</div>
            <form action="{{ route('developer.projects.files.store', $project) }}" method="POST" enctype="multipart/form-data">@csrf<input type="file" name="file" class="input-field text-sm mb-2" required><button type="submit" class="btn-secondary w-full text-sm"><i class="fas fa-upload mr-1"></i> Upload</button></form>
        </div>
    </div>
</div>
@endsection
