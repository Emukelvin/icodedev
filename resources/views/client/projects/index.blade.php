@extends('layouts.dashboard')
@section('title', 'My Projects - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">My Projects</h1>
        <p class="text-sm text-white/50 mt-1">Track and manage all your projects</p>
    </div>
    <a href="{{ route('client.projects.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Project</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Project</th><th class="table-header">Service</th><th class="table-header">Status</th><th class="table-header">Progress</th><th class="table-header">Budget</th><th class="table-header">Deadline</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($projects as $project)
            <tr class="border-t border-white/6 hover:bg-white/4">
                <td class="table-cell font-semibold">{{ $project->title }}</td>
                <td class="table-cell text-white/50">{{ $project->service?->title ?? '-' }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($project->status === 'on_hold' ? 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span></td>
                <td class="table-cell"><div class="w-full bg-white/10 rounded-full h-2"><div class="bg-primary-500 h-2 rounded-full" style="width:{{ $project->progress }}%"></div></div><span class="text-xs text-white/50">{{ $project->progress }}%</span></td>
                <td class="table-cell">{{ $cs }}{{ number_format($project->budget, 2) }}</td>
                <td class="table-cell text-sm">{{ $project->deadline?->format('M d, Y') ?? '-' }}</td>
                <td class="table-cell"><a href="{{ route('client.projects.show', $project) }}" class="text-primary-400 hover:text-primary-300 text-sm">View</a></td>
            </tr>
            @empty
            <tr><td colspan="7" class="table-cell text-center text-white/30 py-12">No projects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $projects->links() }}</div>
@endsection
