@extends('layouts.dashboard')
@section('title', 'Admin Dashboard - ICodeDev')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Admin Dashboard</h1>
    <p class="text-sm text-white/50 mt-1">Overview of your business metrics and recent activity</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Total Revenue</p><p class="text-2xl font-black gradient-text">{{ $cs }}{{ number_format($stats['total_revenue']) }}</p></div><div class="w-12 h-12 bg-primary-500/15 rounded-2xl flex items-center justify-center ring-1 ring-primary-500/20"><i class="fas fa-dollar-sign text-primary-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Active Projects</p><p class="text-2xl font-black text-blue-400">{{ $stats['active_projects'] }}</p></div><div class="w-12 h-12 bg-blue-500/15 rounded-2xl flex items-center justify-center ring-1 ring-blue-500/20"><i class="fas fa-rocket text-blue-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Total Clients</p><p class="text-2xl font-black text-emerald-400">{{ $stats['total_clients'] }}</p></div><div class="w-12 h-12 bg-emerald-500/15 rounded-2xl flex items-center justify-center ring-1 ring-emerald-500/20"><i class="fas fa-users text-emerald-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Pending Invoices</p><p class="text-2xl font-black text-amber-400">{{ $stats['pending_invoices'] }}</p></div><div class="w-12 h-12 bg-amber-500/15 rounded-2xl flex items-center justify-center ring-1 ring-amber-500/20"><i class="fas fa-file-invoice-dollar text-amber-400"></i></div></div></div>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Total Developers</p><p class="text-2xl font-black text-purple-400">{{ $stats['total_developers'] }}</p></div><div class="w-12 h-12 bg-purple-500/15 rounded-2xl flex items-center justify-center ring-1 ring-purple-500/20"><i class="fas fa-code text-purple-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">New Contacts</p><p class="text-2xl font-black text-orange-400">{{ $stats['new_contacts'] }}</p></div><div class="w-12 h-12 bg-orange-500/15 rounded-2xl flex items-center justify-center ring-1 ring-orange-500/20"><i class="fas fa-envelope text-orange-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Completed</p><p class="text-2xl font-black text-teal-400">{{ $stats['completed_projects'] }}</p></div><div class="w-12 h-12 bg-teal-500/15 rounded-2xl flex items-center justify-center ring-1 ring-teal-500/20"><i class="fas fa-check-circle text-teal-400"></i></div></div></div>
    <div class="stat-card"><div class="flex items-center justify-between"><div><p class="text-sm text-white/50">Monthly Revenue</p><p class="text-2xl font-black text-emerald-400">{{ $cs }}{{ number_format($stats['monthly_revenue']) }}</p></div><div class="w-12 h-12 bg-emerald-500/15 rounded-2xl flex items-center justify-center ring-1 ring-emerald-500/20"><i class="fas fa-chart-line text-emerald-400"></i></div></div></div>
</div>

<div class="grid lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Recent Projects</h2>
        <div class="space-y-3">
            @foreach($recentProjects as $project)
            <a href="{{ route('admin.projects.show', $project) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-white/4 transition-all duration-300">
                <div><h3 class="font-semibold text-white/90">{{ $project->title }}</h3><p class="text-sm text-white/40">{{ $project->client->name }}</p></div>
                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
            </a>
            @endforeach
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Recent Payments</h2>
        <div class="space-y-3">
            @foreach($recentPayments as $payment)
            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-white/4 transition-all duration-300">
                <div><h3 class="font-semibold text-white/90">{{ $payment->user->name }}</h3><p class="text-sm text-white/40">{{ $payment->project?->title }}</p></div>
                <div class="text-right"><p class="font-bold text-emerald-400">{{ $cs }}{{ number_format($payment->amount, 2) }}</p><p class="text-xs text-white/30">{{ $payment->created_at->diffForHumans() }}</p></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
    <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Revenue Overview ({{ date('Y') }})</h2>
    @php
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $maxRevenue = $monthlyRevenue->max() ?: 1;
    @endphp
    <div class="h-64 flex items-end gap-2">
        @for($i = 1; $i <= 12; $i++)
        @php $total = $monthlyRevenue->get($i, 0); @endphp
        <div class="flex-1 flex flex-col items-center gap-1">
            <div class="w-full bg-linear-to-t from-primary-600 to-primary-400 rounded-t-lg transition-all duration-500 hover:from-primary-500 hover:to-primary-300 hover:shadow-lg hover:shadow-primary-500/20" style="height: {{ $total > 0 ? max(($total / $maxRevenue) * 200, 4) : 4 }}px" title="{{ $cs }}{{ number_format($total) }}"></div>
            <span class="text-xs text-white/40">{{ $months[$i - 1] }}</span>
        </div>
        @endfor
    </div>
</div>
@endsection
