@extends('layouts.dashboard')
@section('title', $conversation->subject . ' - Messages - ICodeDev')
@section('sidebar')@include('developer.partials.sidebar')@endsection

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('developer.messages.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <h1 class="text-xl font-black text-white">{{ $conversation->subject }}</h1>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 flex flex-col" style="height: calc(100vh - 240px);">
    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
        @foreach($messages as $message)
        <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-md {{ $message->user_id === auth()->id() ? 'bg-primary-600 text-white' : 'bg-white/6 text-white' }} rounded-2xl p-4">
                @if($message->user_id !== auth()->id())<p class="text-xs font-semibold mb-1 {{ $message->user_id === auth()->id() ? 'text-primary-200' : 'text-primary-400' }}">{{ $message->user->name }}</p>@endif
                <p class="text-sm">{{ $message->body }}</p>
                @if($message->attachment)<a href="{{ Storage::url($message->attachment) }}" class="text-xs underline mt-2 inline-block" target="_blank"><i class="fas fa-paperclip mr-1"></i>Attachment</a>@endif
                <p class="text-xs mt-2 {{ $message->user_id === auth()->id() ? 'text-primary-200' : 'text-white/30' }}">{{ $message->created_at->format('g:i A') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="border-t border-white/6 p-4">
        <form action="{{ route('developer.messages.store', $conversation) }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
            @csrf
            <input type="text" name="body" class="input-field" placeholder="Type a message..." required>
            <label class="btn-secondary cursor-pointer"><i class="fas fa-paperclip"></i><input type="file" name="attachment" class="hidden"></label>
            <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>
<script>document.getElementById('messages-container').scrollTop=document.getElementById('messages-container').scrollHeight;</script>
@endsection
