@extends('layouts.dashboard')
@section('title', $project->title . ' - Admin - ICodeDev')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.projects.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1"><h1 class="text-2xl font-black text-white">{{ $project->title }}</h1><p class="text-sm text-white/50 mt-1">{{ $project->client->name }} &middot; {{ $project->service?->title }}</p></div>
    <a href="{{ route('admin.projects.edit', $project) }}" class="btn-secondary"><i class="fas fa-edit mr-1"></i> Edit</a>
</div>

<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><p class="text-sm text-white/50">Status</p><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span></div>
    <div class="stat-card"><p class="text-sm text-white/50">Progress</p><p class="text-2xl font-bold gradient-text">{{ $project->progress }}%</p><div class="w-full bg-white/8 rounded-full h-2 mt-2"><div class="bg-linear-to-r from-primary-500 to-primary-400 h-2 rounded-full" style="width:{{ $project->progress }}%"></div></div></div>
    <div class="stat-card"><p class="text-sm text-white/50">Budget</p><p class="text-2xl font-bold text-white">{{ $cs }}{{ number_format($project->budget, 2) }}</p></div>
    <div class="stat-card"><p class="text-sm text-white/50">Deadline</p><p class="text-2xl font-bold text-white">{{ $project->deadline?->format('M d') ?? '-' }}</p></div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h2 class="font-bold text-white mb-4">Description</h2><div class="prose max-w-none text-white/70">{!! nl2br(e($project->description)) !!}</div></div>

        {{-- Add Update --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="font-bold text-white mb-4">Project Updates</h2>
            <form action="{{ route('admin.projects.updates.store', $project) }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-2"><input type="text" name="content" class="input-field" placeholder="Post an update..." required><button type="submit" class="btn-primary">Post</button></div>
            </form>
            <div class="space-y-4">
                @foreach($project->updates()->with('user')->latest()->get() as $update)
                <div class="border-l-2 border-primary-500/50 pl-4"><div class="flex gap-2 mb-1"><span class="font-semibold text-sm text-white/90">{{ $update->user->name }}</span><span class="text-xs text-white/30">{{ $update->created_at->diffForHumans() }}</span></div><p class="text-white/60 text-sm">{{ $update->content }}</p></div>
                @endforeach
            </div>
        </div>

        {{-- Comments --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="font-bold text-white mb-4">Comments</h2>
            <div class="space-y-4">
                @foreach($project->comments()->with('user')->latest()->get() as $comment)
                <div class="flex gap-3"><div class="w-8 h-8 bg-primary-500/15 rounded-full flex items-center justify-center text-primary-400 font-bold text-sm shrink-0 ring-1 ring-primary-500/20">{{ substr($comment->user->name, 0, 1) }}</div><div><div class="flex gap-2 mb-1"><span class="font-semibold text-sm text-white/90">{{ $comment->user->name }}</span><span class="text-xs text-white/30">{{ $comment->created_at->diffForHumans() }}</span></div><p class="text-white/60 text-sm">{{ $comment->body }}</p></div></div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h3 class="font-bold text-white mb-4">Team</h3>
            <div class="space-y-2">
                @if($project->manager)<div class="flex items-center gap-2 p-2 rounded-xl hover:bg-white/4 transition-colors"><div class="w-8 h-8 bg-amber-500/15 rounded-full flex items-center justify-center text-amber-400 font-bold text-xs ring-1 ring-amber-500/20">PM</div><div><p class="font-semibold text-sm text-white/90">{{ $project->manager->name }}</p><p class="text-xs text-white/40">Project Manager</p></div></div>@endif
                @foreach($project->developers as $dev)<div class="flex items-center gap-2 p-2 rounded-xl hover:bg-white/4 transition-colors"><div class="w-8 h-8 bg-blue-500/15 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs ring-1 ring-blue-500/20">{{ substr($dev->name, 0, 1) }}</div><div><p class="font-semibold text-sm text-white/90">{{ $dev->name }}</p><p class="text-xs text-white/40">Developer</p></div></div>@endforeach
            </div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h3 class="font-bold text-white mb-4">Files</h3>
            <div class="space-y-2 mb-4">@foreach($project->files as $file)<a href="{{ Storage::url($file->path) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/4 text-sm text-white/70 transition-colors" target="_blank"><i class="fas fa-file text-white/30"></i><span class="truncate">{{ $file->original_name }}</span></a>@endforeach</div>
            <form action="{{ route('admin.projects.files.store', $project) }}" method="POST" enctype="multipart/form-data">@csrf<input type="file" name="file" class="input-field text-sm mb-2" required><button type="submit" class="btn-secondary w-full text-sm"><i class="fas fa-upload mr-1"></i> Upload</button></form>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6"><h3 class="font-bold text-white mb-4">Tasks</h3>
            <div class="space-y-2">@foreach($project->tasks()->latest()->take(5)->get() as $task)<div class="flex items-center justify-between p-2 rounded-xl hover:bg-white/4 transition-colors"><span class="text-sm {{ $task->status === 'done' ? 'line-through text-white/30' : 'text-white/70' }}">{{ $task->title }}</span><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->status === 'done' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span></div>@endforeach</div>
        </div>
    </div>
</div>
@endsection
