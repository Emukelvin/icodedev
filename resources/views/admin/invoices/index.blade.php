@extends('layouts.dashboard')
@section('title', 'Invoices - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Invoices</h1>
        <p class="text-sm text-white/50 mt-1">Create and manage client invoices</p>
    </div>
    <a href="{{ route('admin.invoices.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>Create Invoice</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Invoice #</th><th class="table-header">Client</th><th class="table-header">Project</th><th class="table-header">Amount</th><th class="table-header">Status</th><th class="table-header">Due Date</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($invoices as $invoice)
            <tr>
                <td class="table-cell font-semibold text-white/90">{{ $invoice->invoice_number }}</td>
                <td class="table-cell text-white/70">{{ $invoice->user->name }}</td>
                <td class="table-cell">{{ $invoice->project?->title ?? '-' }}</td>
                <td class="table-cell font-semibold text-white">{{ $cs }}{{ number_format($invoice->total, 2) }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $invoice->status === 'paid' ? 'bg-green-500/15 text-green-400 ring-1 ring-green-500/20' : ($invoice->status === 'overdue' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($invoice->status === 'sent' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($invoice->status === 'pending' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : ($invoice->status === 'cancelled' ? 'bg-white/6 text-white/40 ring-1 ring-white/8' : 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20')))) }}">{{ ucfirst($invoice->status) }}</span></td>
                <td class="table-cell text-sm text-white/40">{{ $invoice->due_date?->format('M d, Y') }}</td>
                <td class="table-cell">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-primary-400 hover:text-primary-300 transition-colors" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fas fa-edit"></i></a>
                        @if($invoice->status === 'draft')<form action="{{ route('admin.invoices.send', $invoice) }}" method="POST">@csrf @method('PATCH')<button class="text-blue-400 hover:text-blue-300 transition-colors" title="Send"><i class="fas fa-paper-plane"></i></button></form>@endif
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('admin.invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-300 transition-colors"><i class="fas fa-trash"></i></button></form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="table-cell text-center text-white/40 py-12">No invoices found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $invoices->links() }}</div>
@endsection
