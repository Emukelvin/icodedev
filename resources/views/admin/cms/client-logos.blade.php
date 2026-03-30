@extends('layouts.dashboard')
@section('title', 'Client Logos')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Client Logos</h1>
        <p class="text-sm text-white/50 mt-1">Manage client brand logos for your website</p>
    </div>
    <button onclick="document.getElementById('logo-modal').style.display='flex'" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Logo</button>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
    @forelse($logos as $logo)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-4 text-center">
        <img src="{{ asset('storage/' . $logo->logo_path) }}" alt="{{ $logo->name }}" class="h-16 mx-auto mb-3 object-contain">
        <p class="text-sm font-medium text-white/70 truncate">{{ $logo->name }}</p>
        @if($logo->website_url)
        <a href="{{ $logo->website_url }}" target="_blank" class="text-xs text-primary-400 hover:text-primary-300">Visit</a>
        @endif
        <form action="{{ route('admin.cms.client-logos.destroy', $logo) }}" method="POST" class="mt-2" onsubmit="return confirm('Remove this logo?')">
            @csrf @method('DELETE')
            <button class="text-red-500 text-xs hover:underline"><i class="fas fa-trash mr-1"></i>Remove</button>
        </form>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-white/50">No client logos yet</div>
    @endforelse
</div>

{{-- Add Modal --}}
<div id="logo-modal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center" style="display:none">
    <div class="bg-surface-800/95 backdrop-blur-xl rounded-2xl border border-white/6 p-8 max-w-lg w-full mx-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white">Add Client Logo</h2>
            <button onclick="document.getElementById('logo-modal').style.display='none'" class="text-white/30 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.cms.client-logos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div><label class="label">Company Name</label><input type="text" name="name" class="input-field" required></div>
                <div><label class="label">Logo Image</label><input type="file" name="logo" class="input-field" accept="image/*" required></div>
                <div><label class="label">Website URL (optional)</label><input type="url" name="website_url" class="input-field" placeholder="https://"></div>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="document.getElementById('logo-modal').style.display='none'" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
