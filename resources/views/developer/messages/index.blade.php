@extends('layouts.dashboard')
@section('title', 'Messages - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Messages</h1>
    <p class="text-sm text-white/50 mt-1">Communicate with your team and clients</p>
</div>

<div class="space-y-4">
    @forelse($conversations as $conversation)
    <a href="{{ route('developer.messages.show', $conversation) }}" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 flex items-center gap-4 hover:border-white/12 transition-all duration-300">
        <div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold shrink-0"><i class="fas fa-comments"></i></div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-1"><h3 class="font-semibold text-white/90 truncate">{{ $conversation->subject }}</h3><span class="text-sm text-white/50 shrink-0">{{ $conversation->lastMessage?->created_at?->diffForHumans() }}</span></div>
            <p class="text-white/50 text-sm truncate">{{ $conversation->lastMessage?->body ?? 'No messages yet' }}</p>
        </div>
        @php $unread = $conversation->unreadCountFor(auth()->user()); @endphp
        @if($unread > 0)<span class="badge bg-primary-600 text-white">{{ $unread }}</span>@endif
    </a>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center"><i class="fas fa-comments text-4xl text-white/20 mb-4"></i><p class="text-white/30">No conversations yet.</p></div>
    @endforelse
</div>
@endsection
