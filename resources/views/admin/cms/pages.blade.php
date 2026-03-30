@extends('layouts.dashboard')
@section('title', 'Pages - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">CMS Pages</h1>
        <p class="text-sm text-white/50 mt-1">Create and manage static pages</p>
    </div>
    <a href="{{ route('admin.cms.pages.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>Create Page</a>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead><tr class="border-b border-white/6">
                <th class="table-header">Title</th>
                <th class="table-header">Slug</th>
                <th class="table-header">Status</th>
                <th class="table-header">Updated</th>
                <th class="table-header text-right">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($pages as $page)
                <tr class="border-b border-white/4 hover:bg-white/4">
                    <td class="table-cell font-semibold text-white/90">{{ $page->title }}</td>
                    <td class="table-cell text-sm text-white/50">/{{ $page->slug }}</td>
                    <td class="table-cell"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $page->is_active ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8' }}">{{ $page->is_active ? 'Active' : 'Draft' }}</span></td>
                    <td class="table-cell text-sm text-white/50">{{ $page->updated_at->diffForHumans() }}</td>
                    <td class="table-cell text-right">
                        <a href="{{ route('admin.cms.pages.edit', $page) }}" class="text-primary-400 hover:text-primary-300 text-sm mr-3">Edit</a>
                        <form action="{{ route('admin.cms.pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Delete this page?')">@csrf @method('DELETE')
                            <button class="text-red-400 hover:underline text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-12 text-center text-white/30"><i class="fas fa-file-alt text-3xl mb-3"></i><p>No pages yet.</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $pages->links() }}</div>
</div>
@endsection
