@extends('layouts.dashboard')
@section('title', 'Contact Submission - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.cms.contacts') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">Contact Submission</h1>
        <p class="text-sm text-white/50 mt-1">Received {{ $contact->created_at->diffForHumans() }}</p>
    </div>
    <div class="flex items-center gap-3">
        <form action="{{ route('admin.cms.contacts.status', $contact) }}" method="POST" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <select name="status" class="text-sm bg-white/5 border border-white/8 text-white/70 rounded-xl px-3 py-2 focus:ring-primary-500/30" onchange="this.form.submit()">
                @foreach(['new','read','replied','spam'] as $s)
                <option value="{{ $s }}" {{ $contact->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
        <form action="{{ route('admin.cms.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Delete this submission?')">
            @csrf @method('DELETE')
            <button class="w-10 h-10 rounded-xl bg-red-500/10 ring-1 ring-red-500/20 text-red-400 hover:bg-red-500/20 transition-all"><i class="fas fa-trash text-sm"></i></button>
        </form>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Message Card --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center">
                    <i class="fas fa-envelope text-primary-400 text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white">{{ $contact->subject ?? 'No Subject' }}</h2>
                    <p class="text-xs text-white/40">{{ $contact->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="ml-auto">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $contact->status === 'new' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($contact->status === 'replied' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($contact->status === 'spam' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst($contact->status) }}</span>
                </div>
            </div>
            <div class="p-6">
                <div class="text-white/70 leading-relaxed whitespace-pre-line text-[15px]">{{ $contact->message }}</div>
            </div>
        </div>

        {{-- Quick Reply --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
            <h3 class="text-sm font-bold text-white mb-4"><i class="fas fa-reply text-white/20 mr-2"></i>Quick Reply</h3>
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject ?? 'Your inquiry') }}" class="btn-primary text-center block"><i class="fas fa-paper-plane mr-2"></i>Reply via Email Client</a>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Sender Info --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Sender Information</h3>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-14 h-14 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <span class="text-xl font-black text-primary-400">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-bold text-white text-lg">{{ $contact->name }}</p>
                        <p class="text-sm text-white/40">Contact Submission</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center shrink-0">
                            <i class="fas fa-envelope text-blue-400 text-xs"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-wider text-white/30">Email</p>
                            <a href="mailto:{{ $contact->email }}" class="text-sm font-semibold text-primary-400 hover:text-primary-300 truncate block">{{ $contact->email }}</a>
                        </div>
                    </div>

                    @if($contact->phone)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <i class="fas fa-phone text-emerald-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-white/30">Phone</p>
                            <a href="tel:{{ $contact->phone }}" class="text-sm font-semibold text-white hover:text-primary-400">{{ $contact->phone }}</a>
                        </div>
                    </div>
                    @endif

                    @if($contact->company)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center shrink-0">
                            <i class="fas fa-building text-purple-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-white/30">Company</p>
                            <p class="text-sm font-semibold text-white">{{ $contact->company }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Meta --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Details</h3>
            </div>
            <div class="p-5 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-white/40">Submitted</span><span class="text-white/70">{{ $contact->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-white/40">Time</span><span class="text-white/70">{{ $contact->created_at->format('h:i A') }}</span></div>
                @if($contact->ip_address)<div class="flex justify-between"><span class="text-white/40">IP Address</span><span class="text-white/70 font-mono text-xs">{{ $contact->ip_address }}</span></div>@endif
                @if($contact->subject)<div class="flex justify-between"><span class="text-white/40">Subject</span><span class="text-white/70">{{ Str::limit($contact->subject, 25) }}</span></div>@endif
            </div>
        </div>
    </div>
</div>
@endsection
