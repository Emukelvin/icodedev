@extends('layouts.dashboard')
@section('title', $task->title . ' - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('developer.tasks.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1"><h1 class="text-2xl font-black text-white">{{ $task->title }}</h1><p class="text-sm text-white/50 mt-1">{{ $task->project?->title ?? 'No Project' }}</p></div>
    <form action="{{ route('developer.tasks.status', $task) }}" method="POST">@csrf @method('PATCH')
        <select name="status" class="input-field" onchange="this.form.submit()">@foreach(['todo','in_progress','review','done'] as $s)<option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
    </form>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Description</h2>
            <div class="prose max-w-none text-white/70">{!! nl2br(e($task->description)) !!}</div>
        </div>

        {{-- Comments --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Comments</h2>
            <div class="space-y-4 mb-6">
                @foreach($task->comments()->with('user')->latest()->get() as $comment)
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold text-sm shrink-0">{{ substr($comment->user->name, 0, 1) }}</div>
                    <div><div class="flex items-center gap-2 mb-1"><span class="font-semibold text-sm text-white/90">{{ $comment->user->name }}</span><span class="text-xs text-white/50">{{ $comment->created_at->diffForHumans() }}</span></div><p class="text-white/70 text-sm">{{ $comment->body }}</p></div>
                </div>
                @endforeach
            </div>
            <form action="{{ route('developer.tasks.comments.store', $task) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="body" class="input-field" placeholder="Add a comment..." required>
                <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Details</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between"><dt class="text-white/50">Priority</dt><dd><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($task->priority === 'high' ? 'bg-orange-500/15 text-orange-400 ring-1 ring-orange-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst($task->priority) }}</span></dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Status</dt><dd><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->status === 'done' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span></dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Due Date</dt><dd class="text-white/90">{{ $task->due_date?->format('M d, Y') ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Estimated</dt><dd class="text-white/90">{{ $task->estimated_hours ?? '-' }} hours</dd></div>
                <div class="flex justify-between"><dt class="text-white/50">Created</dt><dd class="text-white/90">{{ $task->created_at->format('M d, Y') }}</dd></div>
            </dl>
        </div>

        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Attachments</h3>
            <div class="space-y-2 mb-4">
                @foreach($task->attachments as $attachment)
                <a href="{{ Storage::url($attachment->path) }}" class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/4 text-sm text-white/90" target="_blank"><i class="fas fa-file text-white/30"></i><span class="truncate">{{ $attachment->original_name }}</span></a>
                @endforeach
            </div>
            <form action="{{ route('developer.tasks.attachments.store', $task) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="input-field text-sm mb-2" required>
                <button type="submit" class="btn-secondary w-full text-sm"><i class="fas fa-upload mr-1"></i> Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
