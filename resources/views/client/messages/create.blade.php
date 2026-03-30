@extends('layouts.dashboard')
@section('title', 'New Conversation - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('client.messages.index') }}" class="text-white/30 hover:text-white/60"><i class="fas fa-arrow-left"></i></a>
    <div>
        <h1 class="text-2xl font-black text-white">New Conversation</h1>
        <p class="text-sm text-white/50 mt-1">Start a new discussion with us</p>
    </div>
</div>

<form action="{{ route('client.messages.start') }}" method="POST" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-2xl space-y-6">
    @csrf
    <div>
        <label class="label">Subject *</label>
        <input type="text" name="subject" class="input-field" value="{{ old('subject') }}" required>
        @error('subject')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="label">Related Project</label>
        <select name="project_id" class="input-field">
            <option value="">General Inquiry</option>
            @foreach(auth()->user()->clientProjects as $project)<option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>@endforeach
        </select>
    </div>
    <div>
        <label class="label">Message *</label>
        <textarea name="body" rows="5" class="input-field" required>{{ old('body') }}</textarea>
        @error('body')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="flex justify-end gap-4">
        <a href="{{ route('client.messages.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Send Message</button>
    </div>
</form>
@endsection
