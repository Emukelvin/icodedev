@extends('layouts.dashboard')
@section('title', 'Manage Users - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Users</h1>
        <p class="text-sm text-white/50 mt-1">Manage all platform users and their roles</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add User</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Search users..." class="input-field w-64" value="{{ request('search') }}">
        <select name="role" class="input-field w-40" onchange="this.form.submit()"><option value="">All Roles</option>@foreach(['admin','manager','developer','client'] as $r)<option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>@endforeach</select>
        <button type="submit" class="btn-secondary"><i class="fas fa-search"></i></button>
    </form>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr><th class="table-header">User</th><th class="table-header">Email</th><th class="table-header">Role</th><th class="table-header">Status</th><th class="table-header">Joined</th><th class="table-header"></th></tr></thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td class="table-cell"><div class="flex items-center gap-3"><img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full ring-1 ring-white/10"><span class="font-semibold text-white/90">{{ $user->name }}</span></div></td>
                <td class="table-cell text-white/50">{{ $user->email }}</td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($user->role === 'developer' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($user->role === 'manager' ? 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8')) }}">{{ ucfirst($user->role) }}</span></td>
                <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $user->is_active ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td class="table-cell text-sm text-white/40">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="table-cell">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-primary-400 hover:text-primary-300 transition-colors" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-amber-400 hover:text-amber-300 transition-colors" title="Edit"><i class="fas fa-edit"></i></a>
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">@csrf @method('PATCH')<button class="text-white/40 hover:text-white transition-colors" title="Toggle status"><i class="fas fa-power-off"></i></button></form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-300 transition-colors"><i class="fas fa-trash"></i></button></form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="table-cell text-center text-white/30 py-12">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->withQueryString()->links() }}</div>
@endsection
