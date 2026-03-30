@extends('layouts.dashboard')
@section('title', ($task->exists ? 'Edit' : 'Create') . ' Task - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.tasks.index') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
    <div>
        <h1 class="text-2xl font-black text-white">{{ $task->exists ? 'Edit' : 'Create' }} Task</h1>
        <p class="text-sm text-white/50 mt-1">{{ $task->exists ? 'Update task details and assignments' : 'Create a new task and assign it to a team member' }}</p>
    </div>
</div>

<form action="{{ $task->exists ? route('admin.tasks.update', $task) : route('admin.tasks.store') }}" method="POST" class="max-w-3xl space-y-6">
    @csrf
    @if($task->exists) @method('PUT') @endif

    {{-- Basic Info --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-info-circle text-primary-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Basic Information</h2>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="label">Title *</label>
                <input type="text" name="title" class="input-field" value="{{ old('title', $task->title) }}" required placeholder="Enter task title...">
                @error('title')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="label">Description</label>
                <textarea name="description" rows="4" class="input-field" placeholder="Describe what needs to be done...">{{ old('description', $task->description) }}</textarea>
            </div>
        </div>
    </div>

    {{-- Assignment --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-500/15 flex items-center justify-center"><i class="fas fa-user-check text-blue-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Assignment</h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Project</label>
                    <select name="project_id" class="input-field">
                        <option value="">No Project</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Assign To</label>
                    <select name="assigned_to" class="input-field">
                        <option value="">Unassigned</option>
                        @foreach($developers as $dev)
                        <option value="{{ $dev->id }}" {{ old('assigned_to', $task->assigned_to) == $dev->id ? 'selected' : '' }}>{{ $dev->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Status & Priority --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-sliders-h text-amber-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Status & Scheduling</h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-3 gap-5 mb-5">
                <div>
                    <label class="label">Status</label>
                    <select name="status" class="input-field">
                        @foreach(['todo','in_progress','review','done'] as $s)
                        <option value="{{ $s }}" {{ old('status', $task->status ?? 'todo') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Priority</label>
                    <select name="priority" class="input-field">
                        @foreach(['low','medium','high','urgent'] as $p)
                        <option value="{{ $p }}" {{ old('priority', $task->priority ?? 'medium') === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Due Date</label>
                    <input type="date" name="due_date" class="input-field" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                </div>
            </div>
            <div>
                <label class="label">Estimated Hours</label>
                <input type="number" name="estimated_hours" step="0.5" class="input-field w-40" value="{{ old('estimated_hours', $task->estimated_hours) }}" placeholder="0">
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.tasks.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>{{ $task->exists ? 'Update' : 'Create' }} Task</button>
    </div>
</form>
@endsection
