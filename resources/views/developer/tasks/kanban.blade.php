@extends('layouts.dashboard')
@section('title', 'Kanban Board - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Kanban Board</h1>
        <p class="text-sm text-white/50 mt-1">Drag and organize your tasks visually</p>
    </div>
    <a href="{{ route('developer.tasks.index') }}" class="btn-secondary"><i class="fas fa-list mr-2"></i>List View</a>
</div>

<div class="grid md:grid-cols-4 gap-6">
    @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'review' => 'In Review', 'done' => 'Done'] as $status => $label)
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-white/70">{{ $label }}</h3>
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50 ring-1 ring-white/8">{{ $tasks->where('status', $status)->count() }}</span>
        </div>
        <div class="space-y-3">
            @foreach($tasks->where('status', $status) as $task)
            <div class="bg-surface-800/80 rounded-2xl border border-white/6 p-4 hover:border-white/12 transition-all duration-300 cursor-pointer" onclick="window.location='{{ route('developer.tasks.show', $task) }}'">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full {{ $task->priority === 'urgent' ? 'bg-red-500' : ($task->priority === 'high' ? 'bg-orange-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-white/30')) }}"></span>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($task->priority === 'high' ? 'bg-orange-500/15 text-orange-400 ring-1 ring-orange-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst($task->priority) }}</span>
                </div>
                <h4 class="font-semibold text-sm text-white/90 mb-2">{{ $task->title }}</h4>
                <p class="text-white/50 text-xs mb-3">{{ $task->project?->title }}</p>
                <div class="flex items-center justify-between text-xs text-white/30">
                    @if($task->due_date)<span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-400' : '' }}"><i class="fas fa-clock mr-1"></i>{{ $task->due_date->format('M d') }}</span>@endif
                    @if($task->comments_count)<span><i class="fas fa-comment mr-1"></i>{{ $task->comments_count }}</span>@endif
                </div>
                <form action="{{ route('developer.tasks.status', $task) }}" method="POST" class="mt-3" onclick="event.stopPropagation()">@csrf @method('PATCH')
                    <select name="status" class="text-xs border border-white/6 rounded-lg px-2 py-1 w-full bg-surface-700 text-white/90" onchange="this.form.submit()">@foreach(['todo','in_progress','review','done'] as $s)<option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection
