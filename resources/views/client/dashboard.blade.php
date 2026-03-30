@extends('layouts.dashboard')
@section('title', 'Client Dashboard - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Welcome back, {{ auth()->user()->name }}!</h1>
    <p class="text-sm text-white/50 mt-1">Here's an overview of your account</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Active Projects</p><p class="text-2xl font-black text-primary-400">{{ $activeProjects }}</p></div><div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-rocket text-primary-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Completed</p><p class="text-2xl font-black text-emerald-400">{{ $completedProjects }}</p></div><div class="w-12 h-12 bg-emerald-500/15 ring-1 ring-emerald-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-check-circle text-emerald-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Total Spent</p><p class="text-2xl font-black text-white">{{ $cs }}{{ number_format($totalSpent) }}</p></div><div class="w-12 h-12 bg-amber-500/15 ring-1 ring-amber-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-wallet text-amber-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Pending Invoices</p><p class="text-2xl font-black text-red-400">{{ $pendingInvoices }}</p></div><div class="w-12 h-12 bg-red-500/15 ring-1 ring-red-500/20 rounded-2xl flex items-center justify-center"><i class="fas fa-file-invoice-dollar text-red-400"></i></div></div></div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <div class="flex items-center justify-between mb-5"><h2 class="text-sm font-bold text-white/40 uppercase tracking-wider">Recent Projects</h2><a href="{{ route('client.projects.index') }}" class="text-primary-400 text-sm hover:text-primary-300">View All</a></div>
        <div class="space-y-4">
            @forelse($projects as $project)
            <a href="{{ route('client.projects.show', $project) }}" class="flex items-center justify-between p-4 rounded-2xl hover:bg-white/4 transition-all duration-300">
                <div>
                    <h3 class="font-semibold text-white/90">{{ $project->title }}</h3>
                    <p class="text-sm text-white/50">{{ $project->service?->title }}</p>
                </div>
                <div class="text-right">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                    @if($project->progress)<div class="w-24 bg-white/10 rounded-full h-1.5 mt-2"><div class="bg-primary-500 h-1.5 rounded-full" style="width:{{ $project->progress }}%"></div></div>@endif
                </div>
            </a>
            @empty
            <p class="text-white/30 text-center py-8">No projects yet. <a href="{{ route('client.projects.create') }}" class="text-primary-400 hover:text-primary-300">Create one</a></p>
            @endforelse
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <div class="flex items-center justify-between mb-5"><h2 class="text-sm font-bold text-white/40 uppercase tracking-wider">Recent Invoices</h2><a href="{{ route('client.invoices') }}" class="text-primary-400 text-sm hover:text-primary-300">View All</a></div>
        <div class="space-y-4">
            @forelse($invoices as $invoice)
            <a href="{{ route('client.invoices.show', $invoice) }}" class="flex items-center justify-between p-4 rounded-2xl hover:bg-white/4 transition-all duration-300">
                <div>
                    <h3 class="font-semibold text-white/90">{{ $invoice->invoice_number }}</h3>
                    <p class="text-sm text-white/50">{{ $invoice->project?->name }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-white">{{ $cs }}{{ number_format($invoice->total, 2) }}</p>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $invoice->status === 'paid' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($invoice->status === 'overdue' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20') }}">{{ ucfirst($invoice->status) }}</span>
                </div>
            </a>
            @empty
            <p class="text-white/30 text-center py-8">No invoices yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
