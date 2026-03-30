@extends('layouts.dashboard')
@section('title', 'Request Project - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('client.projects.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div>
        <h1 class="text-2xl font-black text-white">Request New Project</h1>
        <p class="text-sm text-white/50 mt-1">Fill in the details to get started</p>
    </div>
</div>

<form action="{{ route('client.projects.store') }}" method="POST" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-3xl space-y-6">
    @csrf
    <div class="grid md:grid-cols-2 gap-5">
        <div>
            <label class="label">Project Title *</label>
            <input type="text" name="title" class="input-field" value="{{ old('title') }}" required>
            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="label">Service Type</label>
            <select name="service_id" class="input-field">
                <option value="">Select a service</option>
                @foreach($services as $service)<option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>@endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="label">Description *</label>
        <textarea name="description" rows="5" class="input-field" required>{{ old('description') }}</textarea>
        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div>
            <label class="label">Budget ($)</label>
            <input type="number" name="budget" class="input-field" step="0.01" value="{{ old('budget') }}">
        </div>
        <div>
            <label class="label">Desired Deadline</label>
            <input type="date" name="deadline" class="input-field" value="{{ old('deadline') }}" min="{{ date('Y-m-d') }}">
        </div>
    </div>
    <div>
        <label class="label">Priority</label>
        <select name="priority" class="input-field">
            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
        </select>
    </div>
    <div class="flex justify-end gap-4">
        <a href="{{ route('client.projects.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Submit Project Request</button>
    </div>
</form>
@endsection
