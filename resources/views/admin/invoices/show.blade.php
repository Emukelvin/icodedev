@extends('layouts.dashboard')
@section('title', 'Invoice ' . $invoice->invoice_number . ' - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
{{-- Header --}}
<div class="flex flex-col md:flex-row md:items-center gap-4 mb-8">
    <a href="{{ route('admin.invoices.index') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all self-start"><i class="fas fa-arrow-left text-sm"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">Invoice {{ $invoice->invoice_number }}</h1>
        <p class="text-sm text-white/50 mt-1">Issued {{ $invoice->created_at->format('F d, Y') }}</p>
    </div>
    <div class="flex items-center gap-3">
        @php
            $statusStyles = [
                'paid' => 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20',
                'overdue' => 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20',
                'sent' => 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20',
                'pending' => 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20',
                'cancelled' => 'bg-white/6 text-white/40 ring-1 ring-white/8',
                'draft' => 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20',
            ];
        @endphp
        <span class="px-4 py-2 rounded-xl text-sm font-bold {{ $statusStyles[$invoice->status] ?? $statusStyles['draft'] }}">
            <i class="fas {{ $invoice->status === 'paid' ? 'fa-check-circle' : ($invoice->status === 'overdue' ? 'fa-exclamation-circle' : ($invoice->status === 'sent' ? 'fa-paper-plane' : ($invoice->status === 'pending' ? 'fa-clock' : ($invoice->status === 'cancelled' ? 'fa-ban' : 'fa-file-alt')))) }} mr-1.5"></i>
            {{ ucfirst($invoice->status) }}
        </span>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn-secondary text-sm"><i class="fas fa-edit mr-2"></i>Edit</a>
        @if($invoice->status === 'draft')
        <form action="{{ route('admin.invoices.send', $invoice) }}" method="POST">@csrf @method('PATCH')
            <button class="btn-primary text-sm"><i class="fas fa-paper-plane mr-2"></i>Send</button>
        </form>
        @endif
    </div>
</div>

{{-- Invoice Document --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">

    {{-- Invoice Header Section --}}
    <div class="p-8 md:p-10 border-b border-white/5">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-8">
            {{-- Company Info --}}
            <div>
                @if(!empty($siteSettings['logo_url']))
                <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? config('app.name') }}" class="h-10 mb-4">
                @else
                <h2 class="text-2xl font-black gradient-text mb-4">{{ $siteSettings['site_name'] ?? config('app.name') }}</h2>
                @endif
                <div class="text-sm text-white/40 space-y-1">
                    @if(\App\Models\Setting::get('contact_email'))<p>{{ \App\Models\Setting::get('contact_email') }}</p>@endif
                    @if(\App\Models\Setting::get('contact_phone'))<p>{{ \App\Models\Setting::get('contact_phone') }}</p>@endif
                    @if(\App\Models\Setting::get('contact_address'))<p>{{ \App\Models\Setting::get('contact_address') }}</p>@endif
                </div>
            </div>

            {{-- Invoice Meta --}}
            <div class="text-right">
                <h3 class="text-3xl font-black text-white/10 uppercase tracking-widest mb-4">Invoice</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-end gap-4">
                        <span class="text-white/40">Invoice No.</span>
                        <span class="font-bold text-white font-mono">{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="flex items-center justify-end gap-4">
                        <span class="text-white/40">Issue Date</span>
                        <span class="text-white/70">{{ $invoice->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($invoice->due_date)
                    <div class="flex items-center justify-end gap-4">
                        <span class="text-white/40">Due Date</span>
                        <span class="font-semibold {{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-400' : 'text-white/70' }}">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                    @if($invoice->paid_date)
                    <div class="flex items-center justify-end gap-4">
                        <span class="text-white/40">Paid Date</span>
                        <span class="text-emerald-400 font-semibold">{{ $invoice->paid_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Bill To Section --}}
    <div class="px-8 md:px-10 py-6 border-b border-white/5 bg-white/[0.02]">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Bill To --}}
            <div class="flex-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">Bill To</p>
                @if($invoice->user)
                <div class="flex items-center gap-3 mb-2">
                    @if($invoice->user->avatar)
                    <img src="{{ Storage::url($invoice->user->avatar) }}" class="w-10 h-10 rounded-lg object-cover ring-1 ring-white/10">
                    @else
                    <div class="w-10 h-10 rounded-lg bg-primary-500/15 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <span class="text-sm font-bold text-primary-400">{{ strtoupper(substr($invoice->user->name, 0, 1)) }}</span>
                    </div>
                    @endif
                    <div>
                        <a href="{{ route('admin.users.show', $invoice->user) }}" class="font-bold text-white hover:text-primary-400 transition-colors">{{ $invoice->user->name }}</a>
                        <p class="text-xs text-white/40">{{ $invoice->user->email }}</p>
                    </div>
                </div>
                @if($invoice->user->company)<p class="text-sm text-white/50 ml-[52px]">{{ $invoice->user->company }}</p>@endif
                @if($invoice->user->phone)<p class="text-sm text-white/40 ml-[52px]">{{ $invoice->user->phone }}</p>@endif
                @endif
            </div>
            {{-- Project --}}
            @if($invoice->project)
            <div class="flex-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">Project</p>
                <a href="{{ route('admin.projects.show', $invoice->project) }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/15 ring-1 ring-amber-500/20 flex items-center justify-center">
                        <i class="fas fa-folder text-amber-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-white group-hover:text-amber-400 transition-colors">{{ $invoice->project->title }}</p>
                        <p class="text-xs text-white/40">{{ ucfirst(str_replace('_', ' ', $invoice->project->status)) }}</p>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Items Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/6">
                    <th class="text-left text-[10px] font-bold uppercase tracking-[0.15em] text-white/30 px-8 md:px-10 py-4">#</th>
                    <th class="text-left text-[10px] font-bold uppercase tracking-[0.15em] text-white/30 py-4">Description</th>
                    <th class="text-center text-[10px] font-bold uppercase tracking-[0.15em] text-white/30 py-4 px-4">Qty</th>
                    <th class="text-right text-[10px] font-bold uppercase tracking-[0.15em] text-white/30 py-4 px-4">Unit Price</th>
                    <th class="text-right text-[10px] font-bold uppercase tracking-[0.15em] text-white/30 px-8 md:px-10 py-4">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                <tr class="border-b border-white/4 hover:bg-white/[0.02] transition-colors">
                    <td class="px-8 md:px-10 py-5 text-sm text-white/20 font-mono">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-5">
                        <p class="text-sm text-white/80 font-medium">{{ $item->description }}</p>
                    </td>
                    <td class="py-5 px-4 text-sm text-white/50 text-center font-mono">{{ $item->quantity }}</td>
                    <td class="py-5 px-4 text-sm text-white/50 text-right font-mono">{{ $cs }}{{ number_format($item->unit_price, 2) }}</td>
                    <td class="px-8 md:px-10 py-5 text-sm text-white font-semibold text-right font-mono">{{ $cs }}{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Totals Section --}}
    <div class="border-t border-white/6">
        <div class="flex justify-end">
            <div class="w-full md:w-96 px-8 md:px-10 py-6">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Subtotal</span>
                        <span class="text-white/70 font-mono">{{ $cs }}{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->tax > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Tax</span>
                        <span class="text-white/70 font-mono">{{ $cs }}{{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    @endif
                    @if($invoice->discount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Discount</span>
                        <span class="text-emerald-400 font-mono">-{{ $cs }}{{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="border-t border-white/6 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-white">Total Due</span>
                            <span class="text-2xl font-black text-white">{{ $cs }}{{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notes & Footer --}}
    @if($invoice->notes)
    <div class="border-t border-white/5 px-8 md:px-10 py-6 bg-white/[0.02]">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-2">Notes</p>
        <p class="text-sm text-white/50 leading-relaxed">{{ $invoice->notes }}</p>
    </div>
    @endif

    {{-- Status Bar / Payment Indicator --}}
    @if($invoice->status === 'paid')
    <div class="px-8 md:px-10 py-4 bg-emerald-500/5 border-t border-emerald-500/10 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-check text-emerald-400 text-sm"></i></div>
        <div>
            <p class="text-sm font-semibold text-emerald-400">Payment Received</p>
            <p class="text-xs text-white/40">Paid on {{ $invoice->paid_date?->format('F d, Y') }}</p>
        </div>
    </div>
    @elseif($invoice->status === 'overdue')
    <div class="px-8 md:px-10 py-4 bg-red-500/5 border-t border-red-500/10 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-red-500/15 flex items-center justify-center"><i class="fas fa-exclamation-triangle text-red-400 text-sm"></i></div>
        <div>
            <p class="text-sm font-semibold text-red-400">Payment Overdue</p>
            <p class="text-xs text-white/40">Was due on {{ $invoice->due_date?->format('F d, Y') }} &middot; {{ $invoice->due_date?->diffForHumans() }}</p>
        </div>
    </div>
    @elseif($invoice->status === 'sent')
    <div class="px-8 md:px-10 py-4 bg-blue-500/5 border-t border-blue-500/10 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center"><i class="fas fa-clock text-blue-400 text-sm"></i></div>
        <div>
            <p class="text-sm font-semibold text-blue-400">Awaiting Payment</p>
            <p class="text-xs text-white/40">Sent to client &middot; Due {{ $invoice->due_date?->format('M d, Y') ?? 'No due date' }}</p>
        </div>
    </div>
    @endif
</div>
@endsection
