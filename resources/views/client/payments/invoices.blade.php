@extends('layouts.dashboard')
@section('title', 'Invoices - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">My Invoices</h1>
    <p class="text-sm text-white/50 mt-1">View and manage your invoices</p>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Invoice #</th><th class="table-header">Project</th><th class="table-header">Amount</th><th class="table-header">Status</th><th class="table-header">Due Date</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr class="border-t border-white/6 hover:bg-white/4">
                <td class="table-cell font-semibold">{{ $invoice->invoice_number }}</td>
                <td class="table-cell">{{ $invoice->project?->title ?? '-' }}</td>
                <td class="table-cell font-semibold">{{ $cs }}{{ number_format($invoice->total, 2) }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $invoice->status === 'paid' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($invoice->status === 'overdue' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($invoice->status === 'pending' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20')) }}">{{ ucfirst($invoice->status) }}</span></td>
                <td class="table-cell text-sm">{{ $invoice->due_date?->format('M d, Y') ?? '-' }}</td>
                <td class="table-cell"><a href="{{ route('client.invoices.show', $invoice) }}" class="text-primary-400 hover:text-primary-300 text-sm">View</a></td>
            </tr>
            @empty
            <tr><td colspan="6" class="table-cell text-center text-white/30 py-12">No invoices found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $invoices->links() }}</div>
@endsection
