@extends('layouts.dashboard')
@section('title', 'Activity Log - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Activity Log</h1>
    <p class="text-sm text-white/50 mt-1">Track all user actions and system events</p>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">User</th><th class="table-header">Action</th><th class="table-header">Subject</th><th class="table-header">IP</th><th class="table-header">Date</th></tr></thead>
        <tbody>
            @forelse($logs as $log)
            <tr class="border-t border-white/4 hover:bg-white/4">
                <td class="table-cell"><div class="flex items-center gap-2"><div class="w-8 h-8 bg-primary-500/100/15 ring-1 ring-primary-500/20 rounded-full flex items-center justify-center text-primary-400 font-bold text-xs">{{ substr($log->user?->name ?? '?', 0, 1) }}</div><span class="text-sm">{{ $log->user?->name ?? 'System' }}</span></div></td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50 ring-1 ring-white/8">{{ $log->action }}</span></td>
                <td class="table-cell text-sm">{{ $log->subject_type ? class_basename($log->subject_type) . ' #' . $log->subject_id : '-' }}</td>
                <td class="table-cell font-mono text-sm text-white/50">{{ $log->ip_address }}</td>
                <td class="table-cell text-sm text-white/50">{{ $log->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="table-cell text-center text-white/50 py-12">No activity yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $logs->links() }}</div>
@endsection
