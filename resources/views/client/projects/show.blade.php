@extends('layouts.dashboard')
@section('title', $project->title . ' - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('client.projects.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">{{ $project->title }}</h1>
        <p class="text-sm text-white/50 mt-1">{{ $project->service?->title }}</p>
    </div>
    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
</div>

<div class="grid lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-2 space-y-8">
        {{-- Progress --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Progress</h2>
            <div class="flex items-center gap-4 mb-2"><div class="flex-1 bg-white/10 rounded-full h-3"><div class="bg-primary-500 h-3 rounded-full transition-all" style="width:{{ $project->progress }}%"></div></div><span class="font-bold text-primary-400">{{ $project->progress }}%</span></div>
        </div>

        {{-- Description --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Description</h2>
            <div class="prose max-w-none text-white/70">{!! nl2br(e($project->description)) !!}</div>
        </div>

        {{-- Updates --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Project Updates</h2>
            <div class="space-y-4">
                @forelse($project->updates()->latest()->get() as $update)
                <div class="border-l-4 border-primary-500 pl-4">
                    <div class="flex items-center gap-2 mb-1"><span class="font-semibold text-white/90">{{ $update->user->name }}</span><span class="text-sm text-white/50">{{ $update->created_at->diffForHumans() }}</span></div>
                    <p class="text-white/70">{{ $update->content }}</p>
                </div>
                @empty
                <p class="text-white/30 text-center py-4">No updates yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Comments --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Comments</h2>
            <div class="space-y-4 mb-6">
                @foreach($project->comments()->with('user')->latest()->get() as $comment)
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold text-sm shrink-0">{{ substr($comment->user->name, 0, 1) }}</div>
                    <div><div class="flex items-center gap-2 mb-1"><span class="font-semibold text-sm text-white/90">{{ $comment->user->name }}</span><span class="text-xs text-white/50">{{ $comment->created_at->diffForHumans() }}</span></div><p class="text-white/70 text-sm">{{ $comment->body }}</p></div>
                </div>
                @endforeach
            </div>
            <form action="{{ route('client.projects.comments.store', $project) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="body" class="input-field" placeholder="Add a comment..." required>
                <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Project Details</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-white/50">Budget</dt><dd class="font-semibold text-white/90">{{ $cs }}{{ number_format($project->budget, 2) }}</dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Priority</dt><dd><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($project->priority === 'high' ? 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst($project->priority) }}</span></dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Start Date</dt><dd class="text-white/90">{{ $project->start_date?->format('M d, Y') ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Deadline</dt><dd class="text-white/90">{{ $project->deadline?->format('M d, Y') ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Manager</dt><dd class="text-white/90">{{ $project->manager?->name ?? '-' }}</dd></div>
            </dl>
        </div>

        {{-- Files --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Files</h3>
            <div class="space-y-2 mb-4">
                @foreach($project->files as $file)
                <a href="{{ Storage::url($file->path) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/4 text-sm" target="_blank">
                    <i class="fas fa-file text-white/30"></i><span class="truncate flex-1 text-white/90">{{ $file->original_name }}</span>
                </a>
                @endforeach
            </div>
            <form action="{{ route('client.projects.files.store', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="input-field text-sm mb-2" required>
                <button type="submit" class="btn-secondary w-full text-sm"><i class="fas fa-upload mr-1"></i> Upload</button>
            </form>
        </div>

        {{-- Technologies --}}
        @if($project->technologies)
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Technologies</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($project->technologies ?? [] as $tech)
                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50 ring-1 ring-white/8">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
