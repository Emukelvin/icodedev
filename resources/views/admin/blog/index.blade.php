@extends('layouts.dashboard')
@section('title', 'Blog Management - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Blog Posts</h1>
        <p class="text-sm text-white/50 mt-1">Create and manage blog content</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Post</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Title</th><th class="table-header">Category</th><th class="table-header">Author</th><th class="table-header">Status</th><th class="table-header">Views</th><th class="table-header">Published</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($posts as $post)
            <tr class="border-t border-white/6 hover:bg-white/4">
                <td class="table-cell"><div class="flex items-center gap-3">@if($post->featured_image)<img src="{{ $post->image_url }}" class="w-10 h-10 rounded-lg object-cover">@endif<span class="font-semibold text-white/90">{{ Str::limit($post->title, 40) }}</span></div></td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20">{{ $post->category?->name ?? '-' }}</span></td>
                <td class="table-cell text-sm text-white/50">{{ $post->author->name }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' }}">{{ ucfirst($post->status) }}</span></td>
                <td class="table-cell text-sm text-white/50">{{ number_format($post->views_count) }}</td>
                <td class="table-cell text-sm text-white/50">{{ $post->published_at?->format('M d, Y') ?? '-' }}</td>
                <td class="table-cell">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.blog.edit', $post) }}" class="text-amber-400 hover:text-amber-300"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="table-cell text-center text-white/30 py-12">No posts found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $posts->links() }}</div>
@endsection
