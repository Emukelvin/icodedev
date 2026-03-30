@extends('layouts.dashboard')
@section('title', 'Payments - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Payment History</h1>
    <p class="text-sm text-white/50 mt-1">View all your payment transactions</p>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Reference</th><th class="table-header">Project</th><th class="table-header">Amount</th><th class="table-header">Gateway</th><th class="table-header">Status</th><th class="table-header">Date</th></tr></thead>
        <tbody>
            @forelse($payments as $payment)
            <tr class="border-t border-white/6 hover:bg-white/4">
                <td class="table-cell font-mono text-sm">{{ $payment->reference }}</td>
                <td class="table-cell">{{ $payment->project?->name ?? '-' }}</td>
                <td class="table-cell font-semibold">{{ $cs }}{{ number_format($payment->amount, 2) }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50 ring-1 ring-white/8">{{ ucfirst($payment->gateway) }}</span></td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $payment->status === 'successful' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($payment->status === 'failed' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20') }}">{{ ucfirst($payment->status) }}</span></td>
                <td class="table-cell text-sm text-white/50">{{ $payment->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="table-cell text-center text-white/30 py-12">No payments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $payments->links() }}</div>
@endsection
