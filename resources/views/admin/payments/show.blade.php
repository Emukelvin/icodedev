@extends('layouts.dashboard')
@section('title', 'Payment Detail - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.payments.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">Payment Detail</h1>
        <p class="text-white/50 text-sm">Reference: {{ $payment->reference }}</p>
    </div>
    <span class="px-4 py-2 rounded-xl text-sm font-bold {{ $payment->status === 'successful' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($payment->status === 'failed' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($payment->status === 'refunded' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20')) }}">{{ ucfirst($payment->status) }}</span>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Main Info --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-6 flex items-center gap-2"><i class="fas fa-receipt text-primary-400"></i> Transaction Details</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                    <p class="text-xs text-white/40 mb-1">Amount</p>
                    <p class="text-3xl font-black text-white">{{ $cs }}{{ number_format($payment->amount, 2) }}</p>
                </div>
                <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                    <p class="text-xs text-white/40 mb-1">Payment Date</p>
                    <p class="text-lg font-semibold text-white">{{ $payment->created_at->format('F d, Y') }}</p>
                    <p class="text-sm text-white/50">{{ $payment->created_at->format('h:i A') }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center"><i class="fas fa-hashtag text-white/30 text-sm"></i></div>
                        <div><p class="text-xs text-white/40">Reference</p><p class="text-sm font-mono font-medium text-white/80">{{ $payment->reference }}</p></div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center"><i class="fas fa-credit-card text-white/30 text-sm"></i></div>
                        <div><p class="text-xs text-white/40">Gateway</p><p class="text-sm font-medium text-white/80">{{ ucfirst($payment->gateway ?? 'N/A') }}</p></div>
                    </div>
                </div>
                @if($payment->gateway_response)
                <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                    <p class="text-xs text-white/40 mb-2">Gateway Response</p>
                    <pre class="text-xs text-white/60 font-mono overflow-x-auto">{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT) }}</pre>
                </div>
                @endif
            </div>
        </div>

        {{-- Proof of Payment --}}
        @if($payment->proof_of_payment)
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2"><i class="fas fa-file-invoice text-amber-400"></i> Proof of Payment</h2>
            @php $proofUrl = Storage::url($payment->proof_of_payment); $ext = pathinfo($payment->proof_of_payment, PATHINFO_EXTENSION); @endphp
            @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','webp']))
            <div class="rounded-xl overflow-hidden border border-white/6 mb-3">
                <img src="{{ $proofUrl }}" alt="Proof of Payment" class="w-full max-h-96 object-contain bg-black/20">
            </div>
            @else
            <div class="p-6 rounded-xl bg-white/3 border border-white/5 text-center mb-3">
                <i class="fas fa-file-pdf text-red-400 text-4xl mb-3 block"></i>
                <p class="text-white/60 text-sm mb-1">PDF Document</p>
            </div>
            @endif
            <a href="{{ $proofUrl }}" target="_blank" download class="btn-secondary inline-flex items-center text-sm"><i class="fas fa-download mr-2"></i>Download Proof</a>
        </div>
        @endif

        {{-- Admin Notes --}}
        @if($payment->admin_notes)
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-3 flex items-center gap-2"><i class="fas fa-sticky-note text-primary-400"></i> Admin Notes</h2>
            <p class="text-white/60 text-sm">{{ $payment->admin_notes }}</p>
        </div>
        @endif

        {{-- Admin Actions --}}
        @if(auth()->user()->isAdmin() && $payment->status === 'pending')
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Actions</h2>
            <div class="mb-4">
                <label class="label">Admin Notes (optional)</label>
                <textarea id="admin-notes" class="input-field" rows="2" placeholder="Add a note about this payment..."></textarea>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" onsubmit="this.querySelector('[name=admin_notes]').value=document.getElementById('admin-notes').value">@csrf @method('PATCH')
                    <input type="hidden" name="admin_notes" value="">
                    <button class="bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20 hover:bg-emerald-500/25 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"><i class="fas fa-check mr-2"></i>Approve</button>
                </form>
                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="this.querySelector('[name=admin_notes]').value=document.getElementById('admin-notes').value">@csrf @method('PATCH')
                    <input type="hidden" name="admin_notes" value="">
                    <button class="bg-red-500/15 text-red-400 ring-1 ring-red-500/20 hover:bg-red-500/25 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"><i class="fas fa-times mr-2"></i>Reject</button>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- Client Info --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-5 flex items-center gap-2"><i class="fas fa-user text-primary-400"></i> Client</h2>
            @if($payment->user)
            <a href="{{ route('admin.users.show', $payment->user) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/4 transition-all group">
                <img src="{{ $payment->user->avatar_url }}" class="w-10 h-10 rounded-lg ring-1 ring-white/10" alt="{{ $payment->user->name }}">
                <div>
                    <p class="font-semibold text-white/90 group-hover:text-primary-400 transition-colors">{{ $payment->user->name }}</p>
                    <p class="text-xs text-white/40">{{ $payment->user->email }}</p>
                </div>
            </a>
            @else
            <p class="text-white/30 text-sm">No client linked</p>
            @endif
        </div>

        {{-- Project Info --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-5 flex items-center gap-2"><i class="fas fa-project-diagram text-amber-400"></i> Project</h2>
            @if($payment->project)
            <a href="{{ route('admin.projects.show', $payment->project) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/4 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-folder text-amber-400"></i></div>
                <div>
                    <p class="font-semibold text-white/90 group-hover:text-amber-400 transition-colors">{{ $payment->project->title }}</p>
                    <p class="text-xs text-white/40">{{ ucfirst(str_replace('_', ' ', $payment->project->status)) }}</p>
                </div>
            </a>
            @else
            <p class="text-white/30 text-sm">No project linked</p>
            @endif
        </div>
    </div>
</div>
@endsection
