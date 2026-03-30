@extends('layouts.dashboard')
@section('title', 'Payments - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Payments</h1>
    <p class="text-sm text-white/50 mt-1">Track and manage all payment transactions</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-dollar-sign text-emerald-400"></i></div>
            <div>
                <p class="text-xl font-black text-white">{{ $cs }}{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-xs text-white/40">Total Revenue</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center"><i class="fas fa-chart-line text-blue-400"></i></div>
            <div>
                <p class="text-xl font-black text-white">{{ $cs }}{{ number_format($monthlyRevenue, 0) }}</p>
                <p class="text-xs text-white/40">This Month</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-500/15 flex items-center justify-center"><i class="fas fa-receipt text-primary-400"></i></div>
            <div>
                <p class="text-xl font-black text-white">{{ $payments->total() }}</p>
                <p class="text-xs text-white/40">Transactions</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="flex flex-wrap gap-4">
        <select name="status" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['pending','successful','failed','refunded'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Reference</th><th class="table-header">Client</th><th class="table-header">Project</th><th class="table-header">Amount</th><th class="table-header">Gateway</th><th class="table-header">Status</th><th class="table-header">Date</th><th class="table-header text-right">Actions</th></tr></thead>
        <tbody>
            @forelse($payments as $payment)
            <tr class="border-t border-white/4 hover:bg-white/4">
                <td class="table-cell font-mono text-sm text-white/70">{{ $payment->reference }}</td>
                <td class="table-cell text-white/90">{{ $payment->user->name }}</td>
                <td class="table-cell">{{ $payment->project?->title ?? '-' }}</td>
                <td class="table-cell font-semibold text-white">{{ $cs }}{{ number_format($payment->amount, 2) }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50">{{ ucfirst($payment->gateway) }}</span></td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $payment->status === 'successful' ? 'bg-green-500/15 text-green-400 ring-1 ring-green-500/20' : ($payment->status === 'failed' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($payment->status === 'refunded' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20')) }}">{{ ucfirst($payment->status) }}</span></td>
                <td class="table-cell text-sm text-white/40">{{ $payment->created_at->format('M d, Y H:i') }}</td>
                <td class="table-cell text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-primary-400 hover:text-primary-300 p-1 text-sm transition-colors" title="View"><i class="fas fa-eye"></i></a>
                        @if(auth()->user()->isAdmin() && $payment->status === 'pending')
                        <form action="{{ route('admin.payments.approve', $payment) }}" method="POST">@csrf @method('PATCH')<button class="text-green-400 hover:text-green-300 p-1 text-sm transition-colors" title="Approve"><i class="fas fa-check"></i></button></form>
                        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">@csrf @method('PATCH')<button class="text-red-400 hover:text-red-300 p-1 text-sm transition-colors" title="Reject"><i class="fas fa-times"></i></button></form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="table-cell text-center text-white/40 py-12">No payments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $payments->withQueryString()->links() }}</div>
@endsection
