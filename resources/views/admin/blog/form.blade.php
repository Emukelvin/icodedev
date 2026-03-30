@extends('layouts.dashboard')
@section('title', ($post->exists ? 'Edit' : 'Create') . ' Post - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.blog.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ $post->exists ? 'Edit' : 'Create' }} Blog Post</h1><p class="text-sm text-white/50 mt-1">{{ $post->exists ? 'Update post content and settings' : 'Write and publish a new blog post' }}</p></div>
</div>

<form action="{{ $post->exists ? route('admin.blog.update', $post) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @if($post->exists) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <div class="mb-6"><label class="label">Title *</label><input type="text" name="title" class="input-field" value="{{ old('title', $post->title) }}" required>@error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
                <div class="mb-6"><label class="label">Excerpt</label><textarea name="excerpt" rows="3" class="input-field">{{ old('excerpt', $post->excerpt) }}</textarea></div>
                <div><label class="label">Content *</label><textarea name="body" rows="20" class="input-field font-mono text-sm" required>{{ old('body', $post->body) }}</textarea>@error('body')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            </div>
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h3 class="font-bold text-white/90 mb-4">SEO</h3>
                <div class="mb-4"><label class="label">Meta Title</label><input type="text" name="meta_title" class="input-field" value="{{ old('meta_title', $post->meta_title) }}"></div>
                <div><label class="label">Meta Description</label><textarea name="meta_description" rows="2" class="input-field">{{ old('meta_description', $post->meta_description) }}</textarea></div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h3 class="font-bold text-white/90 mb-4">Publish</h3>
                <div class="mb-4"><label class="label">Status</label><select name="status" class="input-field">@foreach(['draft','published'] as $s)<option value="{{ $s }}" {{ old('status', $post->status ?? 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
                <div class="mb-4"><label class="label">Published At</label><input type="datetime-local" name="published_at" class="input-field" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"></div>
                <div class="mb-4"><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} class="rounded border-white/20 text-primary-500 bg-surface-700"><span class="text-white/90">Featured Post</span></label></div>
                <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="allow_comments" value="1" {{ old('allow_comments', $post->allow_comments ?? true) ? 'checked' : '' }} class="rounded border-white/20 text-primary-500 bg-surface-700"><span class="text-white/90">Allow Comments</span></label></div>
            </div>
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h3 class="font-bold text-white/90 mb-4">Category</h3>
                <select name="category_id" class="input-field"><option value="">No Category</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select>
            </div>
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h3 class="font-bold text-white/90 mb-4">Tags</h3>
                <div class="space-y-2">@foreach($tags as $tag)<label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }} class="rounded border-white/20 text-primary-500 bg-surface-700"><span class="text-sm text-white/90">{{ $tag->name }}</span></label>@endforeach</div>
            </div>
            <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
                <h3 class="font-bold text-white/90 mb-4">Featured Image</h3>
                @if($post->featured_image)<img src="{{ $post->image_url }}" class="w-full rounded-lg mb-4">@endif
                <input type="file" name="featured_image" class="input-field text-sm" accept="image/*">
            </div>
            <button type="submit" class="btn-primary w-full">{{ $post->exists ? 'Update' : 'Publish' }} Post</button>
        </div>
    </div>
</form>
@endsection
