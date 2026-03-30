@extends('layouts.dashboard')
@section('title', $conversation->subject ?? 'Conversation')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.messages.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left mr-1"></i>Back to Messages</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6">
    <div class="p-4 border-b border-white/6">
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider">{{ $conversation->subject ?? 'Conversation' }}</h2>
        <div class="flex gap-2 mt-2">
            @foreach($conversation->participants as $p)
            <span class="text-xs bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 px-2 py-1 rounded-full">{{ $p->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="p-4 space-y-4 max-h-125 overflow-y-auto" id="messages-container">
        @foreach($messages as $message)
        <div class="flex gap-3 {{ $message->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
            <div class="w-8 h-8 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold text-sm shrink-0">{{ substr($message->user->name, 0, 1) }}</div>
            <div class="max-w-[70%] {{ $message->user_id === auth()->id() ? 'bg-primary-500/10 ring-1 ring-primary-500/15' : 'bg-white/4' }} rounded-2xl p-3">
                <p class="text-xs font-semibold text-white/40 mb-1">{{ $message->user->name }}</p>
                <p class="text-sm text-white/80">{{ $message->body }}</p>
                @if($message->attachment)
                <a href="{{ asset('storage/' . $message->attachment) }}" class="text-xs text-primary-400 hover:underline mt-1 block" target="_blank"><i class="fas fa-paperclip mr-1"></i>{{ $message->attachment_name }}</a>
                @endif
                <p class="text-xs text-white/30 mt-1">{{ $message->created_at->format('M d, g:i A') }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('admin.messages.store', $conversation) }}" method="POST" enctype="multipart/form-data" class="p-4 border-t border-white/6">
        @csrf
        <div class="flex gap-2">
            <input type="text" name="body" placeholder="Type a message..." class="input-field flex-1" required>
            <label class="btn-secondary cursor-pointer"><i class="fas fa-paperclip"></i><input type="file" name="attachment" class="hidden"></label>
            <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
</div>

<script>document.getElementById('messages-container').scrollTop = document.getElementById('messages-container').scrollHeight;</script>
@endsection
