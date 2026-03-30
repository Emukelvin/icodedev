@extends('layouts.dashboard')
@section('title', 'Manage Projects - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Projects</h1>
        <p class="text-sm text-white/50 mt-1">Manage all client projects and track progress</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>New Project</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.projects.index') }}" method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Search projects..." class="input-field w-64" value="{{ request('search') }}">
        <select name="status" class="input-field w-40" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach(['pending','in_progress','on_hold','completed','cancelled'] as $s)<option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach
        </select>
        <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">Project</th><th class="table-header">Client</th><th class="table-header">Status</th><th class="table-header">Progress</th><th class="table-header">Budget</th><th class="table-header">Deadline</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($projects as $project)
            <tr>
                <td class="table-cell"><div><span class="font-semibold text-white/90">{{ $project->title }}</span><br><span class="text-sm text-white/40">{{ $project->service?->title }}</span></div></td>
                <td class="table-cell text-white/70">{{ $project->client->name }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($project->status === 'on_hold' ? 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst(str_replace('_',' ',$project->status)) }}</span></td>
                <td class="table-cell"><div class="w-20 bg-white/8 rounded-full h-2"><div class="bg-linear-to-r from-primary-500 to-primary-400 h-2 rounded-full" style="width:{{ $project->progress }}%"></div></div><span class="text-xs text-white/40">{{ $project->progress }}%</span></td>
                <td class="table-cell text-white/70">{{ $cs }}{{ number_format($project->budget, 2) }}</td>
                <td class="table-cell text-sm text-white/50">{{ $project->deadline?->format('M d, Y') ?? '-' }}</td>
                <td class="table-cell">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.projects.show', $project) }}" class="text-primary-400 hover:text-primary-300 transition-colors"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-amber-400 hover:text-amber-300 transition-colors"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-300 transition-colors"><i class="fas fa-trash"></i></button></form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="table-cell text-center text-white/30 py-12">No projects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $projects->withQueryString()->links() }}</div>
@endsection
