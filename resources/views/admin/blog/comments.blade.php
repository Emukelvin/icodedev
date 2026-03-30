@extends('layouts.dashboard')
@section('title', 'Comment Moderation - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Blog Comments</h1>
        <p class="text-sm text-white/50 mt-1">Moderate and manage reader comments</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.blog.comments') }}" class="btn-secondary text-sm {{ !request('status') ? 'bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20' : '' }}">All</a>
        <a href="{{ route('admin.blog.comments', ['status' => 'pending']) }}" class="btn-secondary text-sm {{ request('status') === 'pending' ? 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' : '' }}">Pending</a>
        <a href="{{ route('admin.blog.comments', ['status' => 'approved']) }}" class="btn-secondary text-sm {{ request('status') === 'approved' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : '' }}">Approved</a>
    </div>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead><tr class="border-b border-white/6">
                <th class="text-left py-3 px-4 text-sm font-semibold text-white/50">Author</th>
                <th class="text-left py-3 px-4 text-sm font-semibold text-white/50">Comment</th>
                <th class="text-left py-3 px-4 text-sm font-semibold text-white/50">Post</th>
                <th class="text-left py-3 px-4 text-sm font-semibold text-white/50">Status</th>
                <th class="text-left py-3 px-4 text-sm font-semibold text-white/50">Date</th>
                <th class="text-right py-3 px-4 text-sm font-semibold text-white/50">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($comments as $comment)
                <tr class="border-b border-white/4 hover:bg-white/4">
                    <td class="py-3 px-4">
                        <p class="font-medium text-white/90">{{ $comment->user?->name ?? $comment->guest_name }}</p>
                        <p class="text-xs text-white/50">{{ $comment->user?->email ?? $comment->guest_email }}</p>
                    </td>
                    <td class="py-3 px-4 max-w-xs"><p class="text-sm text-white/50 truncate">{{ Str::limit($comment->body, 80) }}</p></td>
                    <td class="py-3 px-4"><a href="{{ route('blog.show', $comment->post) }}" class="text-primary-400 text-sm hover:text-primary-300">{{ Str::limit($comment->post->title, 30) }}</a></td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $comment->is_approved ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' }}">{{ $comment->is_approved ? 'Approved' : 'Pending' }}</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-white/50">{{ $comment->created_at->diffForHumans() }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            @if(!$comment->is_approved)
                            <form action="{{ route('admin.blog.comments.approve', $comment) }}" method="POST">@csrf @method('PATCH')
                                <button class="text-emerald-400 hover:text-emerald-300 p-1" title="Approve"><i class="fas fa-check"></i></button>
                            </form>
                            @else
                            <form action="{{ route('admin.blog.comments.reject', $comment) }}" method="POST">@csrf @method('PATCH')
                                <button class="text-amber-400 hover:text-amber-300 p-1" title="Unapprove"><i class="fas fa-ban"></i></button>
                            </form>
                            @endif
                            <form action="{{ route('admin.blog.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?')">@csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 p-1" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-12 text-center text-white/30"><i class="fas fa-comments text-3xl mb-3"></i><p>No comments found.</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $comments->withQueryString()->links() }}</div>
</div>
@endsection
