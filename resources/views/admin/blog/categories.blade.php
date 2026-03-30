@extends('layouts.dashboard')
@section('title', 'Blog Categories - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Blog Categories</h1>
        <p class="text-sm text-white/50 mt-1">Organize blog posts into categories</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back to Posts</a>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <table class="data-table w-full">
                <thead><tr><th class="table-header text-left">Category</th><th class="table-header text-left">Slug</th><th class="table-header text-center">Posts</th><th class="table-header text-right">Actions</th></tr></thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-white/6 hover:bg-white/4">
                        <td class="table-cell">
                            <h3 class="font-semibold text-white/90">{{ $category->name }}</h3>
                            @if($category->description)<p class="text-sm text-white/50 mt-1">{{ Str::limit($category->description, 60) }}</p>@endif
                        </td>
                        <td class="table-cell text-white/50 text-sm">{{ $category->slug }}</td>
                        <td class="table-cell text-center"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20">{{ $category->posts_count }}</span></td>
                        <td class="table-cell text-right">
                            <form action="{{ route('admin.blog.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="table-cell text-center text-white/30 py-8">No categories yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Add Category</h2>
            <form action="{{ route('admin.blog.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Name *</label>
                    <input type="text" name="name" class="input-field" value="{{ old('name') }}" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label">Description</label>
                    <textarea name="description" rows="3" class="input-field">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full">Add Category</button>
            </form>
        </div>
    </div>
</div>
@endsection
