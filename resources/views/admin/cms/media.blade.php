@extends('layouts.dashboard')
@section('title', 'Media Manager - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Media Manager</h1>
        <p class="text-sm text-white/50 mt-1">Upload and manage files and images</p>
    </div>
    <button onclick="document.getElementById('upload-form').classList.toggle('hidden')" class="btn-primary"><i class="fas fa-upload mr-2"></i>Upload Files</button>
</div>

<div id="upload-form" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-8 hidden">
    <form action="{{ route('admin.cms.media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center">
            <i class="fas fa-cloud-upload-alt text-4xl text-white/30 mb-4"></i>
            <p class="text-white/60 mb-4">Select files to upload (max 10MB each)</p>
            <input type="file" name="files[]" multiple class="input-field" accept="image/*,application/pdf,.doc,.docx,.zip">
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="btn-primary"><i class="fas fa-upload mr-2"></i>Upload</button>
        </div>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse($media as $item)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-3 group relative">
        @if(str_starts_with($item->file_type, 'image/'))
        <div class="aspect-square rounded-lg overflow-hidden bg-white/6 mb-2">
            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->file_name }}" class="w-full h-full object-cover">
        </div>
        @else
        <div class="aspect-square rounded-lg bg-white/6 flex items-center justify-center mb-2">
            <i class="fas fa-file text-3xl text-white/30"></i>
        </div>
        @endif
        <p class="text-xs text-white/60 truncate" title="{{ $item->file_name }}">{{ $item->file_name }}</p>
        <p class="text-xs text-white/30">{{ number_format($item->file_size / 1024, 1) }} KB</p>

        <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition">
            <div class="flex gap-1">
                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="w-7 h-7 bg-white/90 rounded-full flex items-center justify-center text-primary-400 hover:bg-primary-500/100/10 shadow text-xs"><i class="fas fa-external-link-alt"></i></a>
                <form action="{{ route('admin.cms.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this file?')">@csrf @method('DELETE')
                    <button class="w-7 h-7 bg-white/90 rounded-full flex items-center justify-center text-red-400 hover:bg-red-500/10 shadow text-xs"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center text-white/30">
        <i class="fas fa-photo-video text-4xl mb-3"></i>
        <p>No media files yet. Upload some!</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $media->links() }}</div>
@endsection
