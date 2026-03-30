@extends('layouts.dashboard')
@section('title', 'Quote Requests - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Quote Requests</h1>
        <p class="text-sm text-white/50 mt-1">View and respond to client quote requests</p>
    </div>
    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20">{{ $quotes->total() }} Total</span>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $newCount = $quotes->where('status', 'new')->count();
        $quotedCount = $quotes->where('status', 'quoted')->count();
        $acceptedCount = $quotes->where('status', 'accepted')->count();
        $totalValue = $quotes->whereNotNull('quoted_price')->sum('quoted_price');
    @endphp
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center"><i class="fas fa-inbox text-blue-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $newCount }}</p><p class="text-xs text-white/40">New Requests</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center"><i class="fas fa-file-invoice-dollar text-purple-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $quotedCount }}</p><p class="text-xs text-white/40">Quoted</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-check-circle text-emerald-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $acceptedCount }}</p><p class="text-xs text-white/40">Accepted</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fas fa-dollar-sign text-amber-400"></i></div>
            <div><p class="text-2xl font-black text-white">{{ $cs }}{{ number_format($totalValue) }}</p><p class="text-xs text-white/40">Total Quoted</p></div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.cms.quotes') }}" method="GET" class="flex flex-wrap gap-4">
        <select name="status" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['new','reviewed','quoted','accepted','rejected'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <input type="text" name="search" placeholder="Search by name or email..." class="input-field w-64" value="{{ request('search') }}">
        <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="space-y-4">
    @forelse($quotes as $quote)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border {{ $quote->status === 'new' ? 'border-primary-500/30 bg-primary-500/5' : 'border-white/6' }} overflow-hidden hover:border-white/12 transition-all">
        <div class="p-5">
            <div class="flex items-start gap-4">
                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-xl {{ $quote->status === 'new' ? 'bg-primary-500/15 ring-1 ring-primary-500/20' : 'bg-white/5 ring-1 ring-white/8' }} flex items-center justify-center shrink-0">
                    <i class="fas fa-file-invoice {{ $quote->status === 'new' ? 'text-primary-400' : 'text-white/30' }}"></i>
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <div>
                            <h3 class="font-bold text-white">{{ $quote->name }}</h3>
                            <p class="text-sm text-white/50">{{ $quote->email }}@if($quote->company) &middot; {{ $quote->company }}@endif</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $quote->status === 'new' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($quote->status === 'quoted' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : ($quote->status === 'accepted' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($quote->status === 'rejected' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8'))) }}">{{ ucfirst($quote->status) }}</span>
                            <span class="text-xs text-white/30">{{ $quote->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 text-sm mb-2">
                        @if($quote->service_type)<span class="text-white/50"><i class="fas fa-cog text-white/20 mr-1"></i>{{ $quote->service_type }}</span>@endif
                        @if($quote->budget_range)<span class="text-white/50"><i class="fas fa-wallet text-white/20 mr-1"></i>{{ $quote->budget_range }}</span>@endif
                        @if($quote->timeline)<span class="text-white/50"><i class="fas fa-clock text-white/20 mr-1"></i>{{ $quote->timeline }}</span>@endif
                        @if($quote->quoted_price)<span class="text-emerald-400 font-semibold"><i class="fas fa-tag text-emerald-500/50 mr-1"></i>{{ $cs }}{{ number_format($quote->quoted_price, 2) }}</span>@endif
                    </div>

                    @if($quote->project_description)
                    <p class="text-sm text-white/40 line-clamp-2">{{ $quote->project_description }}</p>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5">
                <div class="flex gap-2">
                    <a href="{{ route('admin.cms.quotes.show', $quote) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 hover:bg-primary-500/25 transition-all"><i class="fas fa-eye mr-1.5"></i>View</a>
                    <a href="mailto:{{ $quote->email }}?subject=Re: Quote Request" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white/5 text-white/50 ring-1 ring-white/8 hover:bg-white/10 hover:text-white transition-all"><i class="fas fa-reply mr-1.5"></i>Reply</a>
                </div>
                <form action="{{ route('admin.cms.quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Delete this quote request?')">@csrf @method('DELETE')
                    <button class="px-2 py-1.5 rounded-lg text-xs text-red-400 hover:bg-red-500/15 transition-all"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fas fa-file-invoice text-white/15 text-4xl mb-4 block"></i>
        <p class="text-white/40">No quote requests yet</p>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $quotes->withQueryString()->links() }}</div>
@endsection
