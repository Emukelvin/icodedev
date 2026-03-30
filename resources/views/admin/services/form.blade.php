@extends('layouts.dashboard')
@section('title', ($service->exists ? 'Edit' : 'Create') . ' Service - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.services.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ $service->exists ? 'Edit' : 'Create' }} Service</h1><p class="text-sm text-white/50 mt-1">{{ $service->exists ? 'Update service details' : 'Add a new service offering' }}</p></div>
</div>

<form action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-3xl space-y-6">
    @csrf
    @if($service->exists) @method('PUT') @endif
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Service Title *</label><input type="text" name="title" class="input-field" value="{{ old('title', $service->title) }}" required>@error('title')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="label">Icon Class</label><input type="text" name="icon" class="input-field" value="{{ old('icon', $service->icon) }}" placeholder="fas fa-code">@error('icon')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </div>
    <div><label class="label">Short Description</label><input type="text" name="short_description" class="input-field" value="{{ old('short_description', $service->short_description) }}"></div>
    <div><label class="label">Full Description *</label><textarea name="description" rows="5" class="input-field" required>{{ old('description', $service->description) }}</textarea>@error('description')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Starting Price ($)</label><input type="number" name="starting_price" step="0.01" class="input-field" value="{{ old('starting_price', $service->starting_price) }}"></div>
        <div><label class="label">Featured Image</label><input type="file" name="image" class="input-field" accept="image/*"></div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Features (one per line)</label><textarea name="features" rows="4" class="input-field">{{ old('features', is_array($service->features) ? implode("\n", $service->features) : $service->features) }}</textarea></div>
        <div><label class="label">Technologies (one per line)</label><textarea name="technologies" rows="4" class="input-field">{{ old('technologies', is_array($service->technologies) ? implode("\n", $service->technologies) : $service->technologies) }}</textarea></div>
    </div>
    <div class="flex items-center gap-4"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }} class="rounded border-white/20 bg-white/5 text-primary-500"><span class="label">Active</span></label></div>
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.services.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">{{ $service->exists ? 'Update' : 'Create' }} Service</button>
    </div>
</form>
@endsection
