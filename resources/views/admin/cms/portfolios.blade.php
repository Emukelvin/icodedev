@extends('layouts.dashboard')
@section('title', 'Portfolios - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Portfolios</h1>
        <p class="text-sm text-white/50 mt-1">Showcase your best work and projects</p>
    </div>
    <button onclick="document.getElementById('portfolio-modal').style.display='flex'" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Portfolio</button>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($portfolios as $portfolio)
    <div class="card-hover group">
        <div class="h-48 overflow-hidden"><img src="{{ $portfolio->image_url }}" class="w-full h-full object-cover"></div>
        <div class="p-6">
            <h3 class="font-bold mb-1">{{ $portfolio->title }}</h3>
            <p class="text-sm text-white/50 mb-3">{{ $portfolio->category }}</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.cms.portfolios.edit', $portfolio) }}" class="text-amber-400 text-sm"><i class="fas fa-edit"></i> Edit</a>
                <form action="{{ route('admin.cms.portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-400 text-sm"><i class="fas fa-trash"></i> Delete</button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12"><p class="text-white/50">No portfolio items yet.</p></div>
    @endforelse
</div>

{{-- Add Modal --}}
<div id="portfolio-modal" class="fixed inset-0 bg-black/50 z-50 items-center justify-center" style="display:none">
    <div class="bg-surface-800/95 backdrop-blur-xl rounded-2xl border border-white/6 p-8 max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6"><h2 class="text-xl font-bold text-white">Add Portfolio</h2><button onclick="document.getElementById('portfolio-modal').style.display='none'" class="text-white/30 hover:text-white"><i class="fas fa-times"></i></button></div>
        <form action="{{ route('admin.cms.portfolios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4"><label class="label">Title *</label><input type="text" name="title" class="input-field" required></div>
            <div class="mb-4"><label class="label">Category</label><input type="text" name="category" class="input-field" placeholder="e.g. Web Development"></div>
            <div class="mb-4"><label class="label">Description</label><textarea name="description" rows="3" class="input-field"></textarea></div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="label">Client Name</label><input type="text" name="client_name" class="input-field"></div>
                <div><label class="label">Project URL</label><input type="url" name="project_url" class="input-field"></div>
            </div>
            <div class="mb-4"><label class="label">Technologies (comma-separated)</label><input type="text" name="technologies" class="input-field" placeholder="Laravel, React, MySQL"></div>
            <div class="mb-4"><label class="label">Featured Image</label><input type="file" name="featured_image" class="input-field" accept="image/*"></div>
            <div class="flex justify-end gap-4"><button type="button" onclick="document.getElementById('portfolio-modal').style.display='none'" class="btn-secondary">Cancel</button><button type="submit" class="btn-primary">Save</button></div>
        </form>
    </div>
</div>
@endsection
