@extends('layouts.dashboard')
@section('title', 'Messages')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Messages</h1>
        <p class="text-sm text-white/50 mt-1">View and manage conversations</p>
    </div>
    <a href="{{ route('admin.messages.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Message</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 divide-y divide-white/6">
    @forelse($conversations as $conversation)
    <a href="{{ route('admin.messages.show', $conversation) }}" class="flex items-center gap-4 p-4 hover:bg-white/4 transition group">
        <div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold shrink-0"><i class="fas fa-comments"></i></div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-1">
                <h3 class="font-semibold text-white truncate group-hover:text-primary-400 transition-colors">{{ $conversation->subject ?? 'No Subject' }}</h3>
                <span class="text-sm text-white/40 shrink-0">{{ $conversation->latestMessage?->created_at?->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-white/50 truncate">{{ $conversation->latestMessage?->body ?? 'No messages yet' }}</p>
            <div class="flex gap-1 mt-1">
                @foreach($conversation->participants as $p)
                <span class="text-xs bg-white/6 text-white/50 px-2 py-0.5 rounded-full">{{ $p->name }}</span>
                @endforeach
            </div>
        </div>
    </a>
    @empty
    <div class="p-12 text-center text-white/40"><i class="fas fa-inbox text-4xl mb-4 block"></i>No conversations yet</div>
    @endforelse
</div>

<div class="mt-6">{{ $conversations->links() }}</div>
@endsection
