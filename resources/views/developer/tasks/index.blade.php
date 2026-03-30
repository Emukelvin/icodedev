@extends('layouts.dashboard')
@section('title', 'My Tasks - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">My Tasks</h1>
        <p class="text-sm text-white/50 mt-1">Manage and track your assigned tasks</p>
    </div>
    <a href="{{ route('developer.tasks.kanban') }}" class="btn-secondary"><i class="fas fa-columns mr-2"></i>Kanban View</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('developer.tasks.index') }}" method="GET" class="flex flex-wrap gap-4">
        <select name="status" class="input-field w-40" onchange="this.form.submit()"><option value="">All Status</option>@foreach(['todo','in_progress','review','done'] as $s)<option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
        <select name="priority" class="input-field w-40" onchange="this.form.submit()"><option value="">All Priority</option>@foreach(['low','medium','high','urgent'] as $p)<option value="{{ $p }}" {{ request('priority') === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>@endforeach</select>
    </form>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Task</th><th class="table-header">Project</th><th class="table-header">Priority</th><th class="table-header">Status</th><th class="table-header">Due Date</th><th class="table-header">Hours</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($tasks as $task)
            <tr class="border-t border-white/6 hover:bg-white/4">
                <td class="table-cell font-semibold text-white/90">{{ $task->title }}</td>
                <td class="table-cell text-sm text-white/50">{{ $task->project?->title ?? '-' }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $task->priority === 'urgent' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($task->priority === 'high' ? 'bg-orange-500/15 text-orange-400 ring-1 ring-orange-500/20' : ($task->priority === 'medium' ? 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst($task->priority) }}</span></td>
                <td class="table-cell">
                    <form action="{{ route('developer.tasks.status', $task) }}" method="POST" class="inline">@csrf @method('PATCH')
                        <select name="status" class="text-sm border border-white/6 rounded-lg px-2 py-1 bg-surface-700 text-white/90" onchange="this.form.submit()">@foreach(['todo','in_progress','review','done'] as $s)<option value="{{ $s }}" {{ $task->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select>
                    </form>
                </td>
                <td class="table-cell text-sm {{ $task->due_date && $task->due_date->isPast() && $task->status !== 'done' ? 'text-red-400 font-semibold' : 'text-white/50' }}">{{ $task->due_date?->format('M d, Y') ?? '-' }}</td>
                <td class="table-cell text-sm text-white/50">{{ $task->estimated_hours ?? '-' }}h</td>
                <td class="table-cell"><a href="{{ route('developer.tasks.show', $task) }}" class="text-primary-400 hover:text-primary-300 text-sm">View</a></td>
            </tr>
            @empty
            <tr><td colspan="7" class="table-cell text-center text-white/30 py-12">No tasks found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $tasks->withQueryString()->links() }}</div>
@endsection
