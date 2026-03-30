@extends('layouts.dashboard')
@section('title', 'Contact Submissions - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Contact Submissions</h1>
        <p class="text-sm text-white/50 mt-1">Review and respond to contact form submissions</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20">
            {{ $contacts->total() }} Total
        </span>
    </div>
</div>

{{-- Status Filter --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.cms.contacts') }}" method="GET" class="flex flex-wrap gap-4">
        <select name="status" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['new','read','replied','spam'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <input type="text" name="search" placeholder="Search by name or email..." class="input-field w-64" value="{{ request('search') }}">
        <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="space-y-4">
    @forelse($contacts as $contact)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border {{ $contact->status === 'new' ? 'border-primary-500/30 bg-primary-500/5' : 'border-white/6' }} overflow-hidden hover:border-white/12 transition-all group">
        <div class="p-5">
            <div class="flex items-start gap-4">
                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-xl {{ $contact->status === 'new' ? 'bg-primary-500/15 ring-1 ring-primary-500/20' : 'bg-white/5 ring-1 ring-white/8' }} flex items-center justify-center shrink-0">
                    <span class="text-lg font-bold {{ $contact->status === 'new' ? 'text-primary-400' : 'text-white/30' }}">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-white">{{ $contact->name }}</h3>
                                @if($contact->status === 'new')
                                <span class="w-2 h-2 rounded-full bg-primary-400 animate-pulse"></span>
                                @endif
                            </div>
                            <p class="text-sm text-white/50">{{ $contact->email }}@if($contact->phone) &middot; {{ $contact->phone }}@endif</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $contact->status === 'new' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($contact->status === 'replied' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($contact->status === 'spam' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst($contact->status) }}</span>
                            <span class="text-xs text-white/30">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if($contact->subject)
                    <p class="text-sm font-semibold text-white/70 mb-1"><i class="fas fa-tag text-white/20 mr-1.5 text-xs"></i>{{ $contact->subject }}</p>
                    @endif

                    <p class="text-sm text-white/50 line-clamp-2">{{ $contact->message }}</p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5">
                <div class="flex gap-2">
                    <a href="{{ route('admin.cms.contacts.show', $contact) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 hover:bg-primary-500/25 transition-all"><i class="fas fa-eye mr-1.5"></i>View</a>
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject ?? 'Your inquiry') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white/5 text-white/50 ring-1 ring-white/8 hover:bg-white/10 hover:text-white transition-all"><i class="fas fa-reply mr-1.5"></i>Reply</a>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('admin.cms.contacts.status', $contact) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <select name="status" class="text-xs bg-white/5 border border-white/8 text-white/50 rounded-lg px-2 py-1.5 focus:ring-primary-500/30" onchange="this.form.submit()">
                            @foreach(['new','read','replied','spam'] as $s)
                            <option value="{{ $s }}" {{ $contact->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </form>
                    <form action="{{ route('admin.cms.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this submission?')">@csrf @method('DELETE')
                        <button class="px-2 py-1.5 rounded-lg text-xs text-red-400 hover:bg-red-500/15 transition-all"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fas fa-inbox text-white/15 text-4xl mb-4 block"></i>
        <p class="text-white/40">No contact submissions yet</p>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $contacts->withQueryString()->links() }}</div>
@endsection
