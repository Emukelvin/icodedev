@extends('layouts.dashboard')
@section('title', ($project->exists ? 'Edit' : 'Create') . ' Project - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.projects.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ $project->exists ? 'Edit' : 'Create' }} Project</h1><p class="text-sm text-white/50 mt-1">{{ $project->exists ? 'Update project details' : 'Set up a new client project' }}</p></div>
</div>

<form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-4xl space-y-6">
    @csrf
    @if($project->exists) @method('PUT') @endif

    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Project Title *</label><input type="text" name="title" class="input-field" value="{{ old('title', $project->title) }}" required>@error('title')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="label">Client *</label><select name="client_id" class="input-field" required><option value="">Select Client</option>@foreach($clients as $client)<option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>@endforeach</select>@error('client_id')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Service</label><select name="service_id" class="input-field"><option value="">Select Service</option>@foreach($services as $service)<option value="{{ $service->id }}" {{ old('service_id', $project->service_id) == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>@endforeach</select></div>
        <div><label class="label">Manager</label><select name="manager_id" class="input-field"><option value="">Assign Manager</option>@foreach($managers as $manager)<option value="{{ $manager->id }}" {{ old('manager_id', $project->manager_id) == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>@endforeach</select></div>
    </div>
    <div><label class="label">Description *</label><textarea name="description" rows="4" class="input-field" required>{{ old('description', $project->description) }}</textarea>@error('description')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    <div class="grid md:grid-cols-4 gap-5">
        <div><label class="label">Budget ($)</label><input type="number" name="budget" step="0.01" class="input-field" value="{{ old('budget', $project->budget) }}"></div>
        <div><label class="label">Status</label><select name="status" class="input-field">@foreach(['pending','in_progress','on_hold','completed','cancelled'] as $s)<option value="{{ $s }}" {{ old('status', $project->status ?? 'pending') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
        <div><label class="label">Priority</label><select name="priority" class="input-field">@foreach(['low','medium','high','urgent'] as $p)<option value="{{ $p }}" {{ old('priority', $project->priority ?? 'medium') === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>@endforeach</select></div>
        <div><label class="label">Progress (%)</label><input type="number" name="progress" min="0" max="100" class="input-field" value="{{ old('progress', $project->progress ?? 0) }}"></div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Start Date</label><input type="date" name="start_date" class="input-field" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"></div>
        <div><label class="label">Deadline</label><input type="date" name="deadline" class="input-field" value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}"></div>
    </div>
    <div>
        <label class="label">Developers</label>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            @foreach($developers as $dev)
            <label class="flex items-center gap-2 p-2 rounded-lg hover:bg-white/4 cursor-pointer transition-colors"><input type="checkbox" name="developers[]" value="{{ $dev->id }}" {{ in_array($dev->id, old('developers', $project->developers?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="rounded border-white/20 bg-white/6 text-primary-500"><span class="text-sm text-white/70">{{ $dev->name }}</span></label>
            @endforeach
        </div>
    </div>
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.projects.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">{{ $project->exists ? 'Update' : 'Create' }} Project</button>
    </div>
</form>
@endsection
