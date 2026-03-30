@extends('layouts.dashboard')
@section('title', ($page->exists ? 'Edit' : 'Create') . ' Page - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="mb-8">
    <a href="{{ route('admin.cms.pages') }}" class="text-primary-400 hover:text-primary-300"><i class="fas fa-arrow-left mr-1"></i>Back to Pages</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-3xl">
    <h2 class="text-xl font-black text-white mb-6">{{ $page->exists ? 'Edit Page' : 'Create Page' }}</h2>

    <form action="{{ $page->exists ? route('admin.cms.pages.update', $page) : route('admin.cms.pages.store') }}" method="POST">
        @csrf
        @if($page->exists) @method('PUT') @endif

        <div class="space-y-6">
            <div>
                <label class="label">Title *</label>
                <input type="text" name="title" class="input-field" required value="{{ old('title', $page->title) }}">
            </div>

            <div>
                <label class="label">Content * <span class="text-white/30 font-normal">(HTML supported)</span></label>
                <textarea name="content" rows="20" class="input-field font-mono text-sm" required>{{ old('content', $page->content) }}</textarea>
                <p class="text-xs text-white/30 mt-1">You can use HTML tags for formatting: &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;strong&gt;, &lt;a&gt;, etc.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="label">Meta Title</label>
                    <input type="text" name="meta_title" class="input-field" value="{{ old('meta_title', $page->meta_title) }}">
                </div>
                <div>
                    <label class="label">Meta Description</label>
                    <input type="text" name="meta_description" class="input-field" value="{{ old('meta_description', $page->meta_description) }}">
                </div>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-white/20 bg-white/5 text-primary-500" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-sm text-white/70">Active (visible on site)</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>{{ $page->exists ? 'Update Page' : 'Create Page' }}</button>
                <a href="{{ route('admin.cms.pages') }}" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
