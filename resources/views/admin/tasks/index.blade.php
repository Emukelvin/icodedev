@extends('layouts.dashboard')
@section('title', 'Tasks - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Tasks</h1>
        <p class="text-sm text-white/50 mt-1">Manage and assign tasks across projects</p>
    </div>
    <a href="{{ route('admin.tasks.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Task</a>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $todoCount = $tasks->where('status', 'todo')->count();
        $inProgressCount = $tasks->where('status', 'in_progress')->count();
        $reviewCount = $tasks->where('status', 'review')->count();
        $doneCount = $tasks->where('status', 'done')->count();
    @endphp
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center"><i class="fas fa-clipboard-list text-white/40"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $todoCount }}</p><p class="text-xs text-white/40">To Do</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center"><i class="fas fa-spinner text-blue-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $inProgressCount }}</p><p class="text-xs text-white/40">In Progress</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center"><i class="fas fa-search text-purple-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $reviewCount }}</p><p class="text-xs text-white/40">In Review</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-check-circle text-emerald-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $doneCount }}</p><p class="text-xs text-white/40">Completed</p></div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.tasks.index') }}" method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Search tasks..." class="input-field w-64" value="{{ request('search') }}">
        <select name="status" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['todo','in_progress','review','done'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <select name="priority" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Priority</option>
            @foreach(['low','medium','high','urgent'] as $p)
            <option value="{{ $p }}" {{ request('priority') === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

{{-- Tasks List --}}
<div class="space-y-3">
    @forelse($tasks as $task)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 hover:border-white/12 transition-all overflow-hidden">
        <div class="p-5">
            <div class="flex items-start gap-4">
                {{-- Priority Indicator --}}
                <div class="w-10 h-10 rounded-xl shrink-0 flex items-center justify-center {{ $task->priority === 'urgent' ? 'bg-red-500/15 ring-1 ring-red-500/20' : ($task->priority === 'high' ? 'bg-orange-500/15 ring-1 ring-orange-500/20' : ($task->priority === 'medium' ? 'bg-yellow-500/15 ring-1 ring-yellow-500/20' : 'bg-white/5 ring-1 ring-white/8')) }}">
                    <i class="fas {{ $task->status === 'done' ? 'fa-check' : 'fa-tasks' }} text-sm {{ $task->priority === 'urgent' ? 'text-red-400' : ($task->priority === 'high' ? 'text-orange-400' : ($task->priority === 'medium' ? 'text-yellow-400' : 'text-white/30')) }}"></i>
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <h3 class="font-bold text-white {{ $task->status === 'done' ? 'line-through opacity-60' : '' }}">{{ $task->title }}</h3>
                            <div class="flex items-center gap-3 mt-1">
                                @if($task->project)
                                <span class="text-xs text-white/40"><i class="fas fa-folder text-white/20 mr-1"></i>{{ $task->project->title }}</span>
                                @endif
                                @if($task->assignee)
                                <span class="text-xs text-white/40"><i class="fas fa-user text-white/20 mr-1"></i>{{ $task->assignee->name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($task->priority === 'high' ? 'bg-orange-500/15 text-orange-400 ring-1 ring-orange-500/20' : ($task->priority === 'medium' ? 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst($task->priority) }}</span>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->status === 'done' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($task->status === 'review' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst(str_replace('_',' ',$task->status)) }}</span>
                        </div>
                    </div>

                    @if($task->description)
                    <p class="text-sm text-white/40 line-clamp-1 mb-2">{{ $task->description }}</p>
                    @endif

                    <div class="flex items-center gap-4 text-xs text-white/30">
                        @if($task->due_date)
                        <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-400' : '' }}"><i class="fas fa-calendar mr-1"></i>{{ $task->due_date->format('M d, Y') }}</span>
                        @endif
                        @if($task->estimated_hours)
                        <span><i class="fas fa-hourglass-half mr-1"></i>{{ $task->estimated_hours }}h</span>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('admin.tasks.edit', $task) }}" class="w-8 h-8 rounded-lg bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-amber-400 hover:bg-amber-500/15 transition-all"><i class="fas fa-edit text-xs"></i></a>
                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">@csrf @method('DELETE')
                        <button class="w-8 h-8 rounded-lg bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-red-400 hover:bg-red-500/15 transition-all"><i class="fas fa-trash text-xs"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fas fa-tasks text-white/15 text-4xl mb-4 block"></i>
        <p class="text-white/40 mb-4">No tasks found</p>
        <a href="{{ route('admin.tasks.create') }}" class="btn-primary inline-block"><i class="fas fa-plus mr-2"></i>Create First Task</a>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $tasks->withQueryString()->links() }}</div>
@endsection
