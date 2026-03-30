@extends('layouts.dashboard')
@section('title', (isset($portfolio) ? 'Edit' : 'Create') . ' Portfolio - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.cms.portfolios') }}" class="text-white/30 hover:text-white"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ isset($portfolio) ? 'Edit' : 'Create' }} Portfolio Item</h1><p class="text-sm text-white/50 mt-1">{{ isset($portfolio) ? 'Update portfolio details' : 'Add a new portfolio piece' }}</p></div>
</div>

<form action="{{ isset($portfolio) ? route('admin.cms.portfolios.update', $portfolio) : route('admin.cms.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @if(isset($portfolio)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h2 class="font-bold mb-4">Basic Info</h2>
                <div class="space-y-4">
                    <div><label class="label">Title *</label><input type="text" name="title" class="input-field" value="{{ old('title', $portfolio->title ?? '') }}" required>@error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="label">Short Description</label><textarea name="short_description" rows="2" class="input-field">{{ old('short_description', $portfolio->short_description ?? '') }}</textarea>@error('short_description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                    <div><label class="label">Description *</label><textarea name="description" rows="6" class="input-field">{{ old('description', $portfolio->description ?? '') }}</textarea>@error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                </div>
            </div>

            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h2 class="font-bold mb-4">Project Details</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="label">Client Name</label><input type="text" name="client_name" class="input-field" value="{{ old('client_name', $portfolio->client_name ?? '') }}"></div>
                    <div><label class="label">Category *</label><input type="text" name="category" class="input-field" value="{{ old('category', $portfolio->category ?? '') }}" required placeholder="Web Development, Mobile App, etc."></div>
                    <div><label class="label">Technologies</label><input type="text" name="technologies" class="input-field" value="{{ old('technologies', isset($portfolio) && $portfolio->technologies ? implode(', ', $portfolio->technologies) : '') }}" placeholder="Laravel, React, MySQL..."></div>
                    <div><label class="label">Live URL</label><input type="url" name="live_url" class="input-field" value="{{ old('live_url', $portfolio->live_url ?? '') }}" placeholder="https://..."></div>
                    <div><label class="label">Completion Date</label><input type="date" name="completion_date" class="input-field" value="{{ old('completion_date', isset($portfolio) && $portfolio->completion_date ? $portfolio->completion_date->format('Y-m-d') : '') }}"></div>
                </div>
            </div>

            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h2 class="font-bold mb-4">Client Feedback</h2>
                <div class="space-y-4">
                    <div><label class="label">Feedback</label><textarea name="client_feedback" rows="3" class="input-field">{{ old('client_feedback', $portfolio->client_feedback ?? '') }}</textarea></div>
                    <div><label class="label">Rating</label><select name="client_rating" class="input-field"><option value="">No Rating</option>@for($i=5;$i>=1;$i--)<option value="{{ $i }}" {{ old('client_rating', $portfolio->client_rating ?? '') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>@endfor</select></div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h2 class="font-bold mb-4">Thumbnail</h2>
                @if(isset($portfolio) && $portfolio->thumbnail)
                    <img src="{{ Storage::url($portfolio->thumbnail) }}" class="w-full h-40 object-cover rounded-lg mb-4" alt="">
                @endif
                <input type="file" name="thumbnail" class="input-field" accept="image/*">
            </div>

            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h2 class="font-bold mb-4">Visibility</h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3"><input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded border-white/20" {{ old('is_featured', $portfolio->is_featured ?? false) ? 'checked' : '' }}><span>Featured</span></label>
                    <label class="flex items-center gap-3"><input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded border-white/20" {{ old('is_active', $portfolio->is_active ?? true) ? 'checked' : '' }}><span>Active</span></label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full"><i class="fas fa-save mr-2"></i>{{ isset($portfolio) ? 'Update' : 'Create' }} Portfolio</button>
        </div>
    </div>
</form>
@endsection
