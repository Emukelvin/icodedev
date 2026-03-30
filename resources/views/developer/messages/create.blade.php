@extends('layouts.dashboard')
@section('title', 'New Message')
@section('sidebar')
@include('developer.partials.sidebar')
@endsection
@section('content')
<div class="mb-6">
    <a href="{{ route('developer.messages.index') }}" class="text-primary-400 hover:text-primary-300"><i class="fas fa-arrow-left mr-1"></i>Back to Messages</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-xl font-black text-white">Start a New Conversation</h1>
        <p class="text-sm text-white/50 mt-1">Send a message to a team member or client</p>
    </div>

    <form action="{{ route('developer.messages.start') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="label">Recipient</label>
                <select name="recipient_id" class="input-field" required>
                    <option value="">Select a user...</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                    @endforeach
                </select>
                @error('recipient_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="label">Subject</label>
                <input type="text" name="subject" class="input-field" value="{{ old('subject') }}" required>
                @error('subject') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="label">Message</label>
                <textarea name="body" rows="5" class="input-field" required>{{ old('body') }}</textarea>
                @error('body') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary w-full"><i class="fas fa-paper-plane mr-2"></i>Send Message</button>
        </div>
    </form>
</div>
@endsection
