@extends('layouts.dashboard')
@section('title', 'Messages - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Messages</h1>
        <p class="text-sm text-white/50 mt-1">Communicate with your project team</p>
    </div>
    <a href="{{ route('client.messages.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Conversation</a>
</div>

<div class="space-y-4">
    @forelse($conversations as $conversation)
    <a href="{{ route('client.messages.show', $conversation) }}" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 flex items-center gap-4 hover:bg-surface-800/80 transition-all duration-300 block">
        <div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold shrink-0"><i class="fas fa-comments"></i></div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-1">
                <h3 class="font-semibold text-white/90 truncate">{{ $conversation->subject }}</h3>
                <span class="text-sm text-white/50 shrink-0">{{ $conversation->lastMessage?->created_at?->diffForHumans() }}</span>
            </div>
            <p class="text-white/50 text-sm truncate">{{ $conversation->lastMessage?->body ?? 'No messages yet' }}</p>
        </div>
        @php $unread = $conversation->unreadCountFor(auth()->user()); @endphp
        @if($unread > 0)<span class="badge bg-primary-600 text-white">{{ $unread }}</span>@endif
    </a>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center"><i class="fas fa-comments text-4xl text-white/30 mb-4"></i><p class="text-white/50">No conversations yet.</p><a href="{{ route('client.messages.create') }}" class="btn-primary mt-4 inline-block">Start a Conversation</a></div>
    @endforelse
</div>
@endsection
