@extends('layouts.dashboard')
@section('title', 'Quote Request - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.cms.quotes') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">Quote Request</h1>
        <p class="text-sm text-white/50 mt-1">From {{ $quote->name }} &middot; {{ $quote->created_at->diffForHumans() }}</p>
    </div>
    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $quote->status === 'new' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($quote->status === 'quoted' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : ($quote->status === 'accepted' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($quote->status === 'rejected' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8'))) }}">{{ ucfirst($quote->status) }}</span>
</div>

{{-- Quick Info Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center"><i class="fas fa-cog text-blue-400 text-sm"></i></div>
            <div><p class="text-xs text-white/40">Service</p><p class="font-semibold text-white text-sm">{{ $quote->service_type ?? 'N/A' }}</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-wallet text-emerald-400 text-sm"></i></div>
            <div><p class="text-xs text-white/40">Budget</p><p class="font-semibold text-white text-sm">{{ $quote->budget_range ?? ($quote->estimated_budget ? $cs.number_format($quote->estimated_budget) : 'N/A') }}</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fas fa-clock text-amber-400 text-sm"></i></div>
            <div><p class="text-xs text-white/40">Timeline</p><p class="font-semibold text-white text-sm">{{ $quote->timeline ?? 'N/A' }}</p></div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/15 flex items-center justify-center"><i class="fas fa-tag text-purple-400 text-sm"></i></div>
            <div><p class="text-xs text-white/40">Quoted Price</p><p class="font-semibold text-white text-sm">{{ $quote->quoted_price ? $cs.number_format($quote->quoted_price, 2) : 'Not quoted' }}</p></div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Project Description --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-file-alt text-primary-400 text-sm"></i></div>
                <h2 class="text-sm font-bold text-white">Project Description</h2>
            </div>
            <div class="p-6">
                <div class="text-white/70 leading-relaxed whitespace-pre-line">{{ $quote->project_description }}</div>
            </div>
        </div>

        {{-- Admin Response --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-pen text-amber-400 text-sm"></i></div>
                <h2 class="text-sm font-bold text-white">Admin Response</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.cms.quotes.update', $quote) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Status</label>
                            <select name="status" class="input-field">
                                @foreach(['new','reviewed','quoted','accepted','rejected'] as $s)
                                <option value="{{ $s }}" {{ $quote->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">Quoted Price ($)</label>
                            <input type="number" name="quoted_price" class="input-field" value="{{ old('quoted_price', $quote->quoted_price) }}" step="0.01" min="0" placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="label">Admin Notes</label>
                        <textarea name="admin_notes" rows="4" class="input-field" placeholder="Add your internal notes or response...">{{ old('admin_notes', $quote->admin_notes) }}</textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Update Quote</button>
                        <a href="mailto:{{ $quote->email }}?subject=Re: Quote Request - {{ urlencode($quote->service_type ?? 'Your Project') }}" class="btn-secondary"><i class="fas fa-reply mr-2"></i>Reply via Email</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Sender Info --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
            <div class="p-5 border-b border-white/5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Client Information</h3>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-14 h-14 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <span class="text-xl font-black text-primary-400">{{ strtoupper(substr($quote->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-bold text-white text-lg">{{ $quote->name }}</p>
                        @if($quote->company)<p class="text-sm text-white/40">{{ $quote->company }}</p>@endif
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center shrink-0"><i class="fas fa-envelope text-blue-400 text-xs"></i></div>
                        <div class="min-w-0">
                            <p class="text-[10px] uppercase tracking-wider text-white/30">Email</p>
                            <a href="mailto:{{ $quote->email }}" class="text-sm font-semibold text-primary-400 hover:text-primary-300 truncate block">{{ $quote->email }}</a>
                        </div>
                    </div>
                    @if($quote->phone)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0"><i class="fas fa-phone text-emerald-400 text-xs"></i></div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-white/30">Phone</p>
                            <a href="tel:{{ $quote->phone }}" class="text-sm font-semibold text-white hover:text-primary-400">{{ $quote->phone }}</a>
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
                <div class="flex justify-between"><span class="text-white/40">Submitted</span><span class="text-white/70">{{ $quote->created_at->format('M d, Y') }}</span></div>
                <div class="flex justify-between"><span class="text-white/40">Time</span><span class="text-white/70">{{ $quote->created_at->format('h:i A') }}</span></div>
                @if($quote->service_type)<div class="flex justify-between"><span class="text-white/40">Service</span><span class="text-white/70">{{ $quote->service_type }}</span></div>@endif
                @if($quote->budget_range)<div class="flex justify-between"><span class="text-white/40">Budget Range</span><span class="text-white/70">{{ $quote->budget_range }}</span></div>@endif
            </div>
        </div>

        {{-- Delete --}}
        <form action="{{ route('admin.cms.quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Delete this quote request?')">
            @csrf @method('DELETE')
            <button class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-red-400 bg-red-500/10 ring-1 ring-red-500/20 hover:bg-red-500/20 transition-all"><i class="fas fa-trash mr-2"></i>Delete Quote Request</button>
        </form>
    </div>
</div>
@endsection
