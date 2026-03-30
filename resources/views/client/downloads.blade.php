@extends('layouts.dashboard')
@section('title', 'Downloads')
@section('page-title', 'Download Center')

@section('sidebar')
    @include('client.partials.sidebar', ['active' => 'downloads'])
@endsection

@section('content')
<div class="mb-6">
    <p class="text-white/50">Download completed deliverables from your projects.</p>
</div>

@if($deliverables->count())
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead class="bg-white/4">
                <tr>
                    <th class="table-header">File</th>
                    <th class="table-header">Project</th>
                    <th class="table-header">Type</th>
                    <th class="table-header">Size</th>
                    <th class="table-header">Uploaded</th>
                    <th class="table-header">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/6">
                @foreach($deliverables as $file)
                <tr>
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-500/15 ring-1 ring-primary-500/20 text-primary-400 rounded-lg flex items-center justify-center">
                                <i class="fas fa-{{ match(true) {
                                    str_contains($file->file_type, 'image') => 'image',
                                    str_contains($file->file_type, 'pdf') => 'file-pdf',
                                    str_contains($file->file_type, 'zip') || str_contains($file->file_type, 'rar') => 'file-archive',
                                    str_contains($file->file_type, 'video') => 'file-video',
                                    str_contains($file->file_type, 'word') || str_contains($file->file_type, 'document') => 'file-word',
                                    default => 'file'
                                } }}"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white text-sm">{{ $file->name }}</p>
                                @if($file->description)
                                    <p class="text-xs text-white/50">{{ Str::limit($file->description, 40) }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="table-cell">
                        <a href="{{ route('client.projects.show', $file->project) }}" class="text-primary-400 hover:text-primary-300 text-sm">{{ $file->project->title }}</a>
                    </td>
                    <td class="table-cell">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/6 text-white/50 ring-1 ring-white/8">{{ Str::afterLast($file->file_type, '/') }}</span>
                    </td>
                    <td class="table-cell text-white/50">{{ number_format($file->file_size / 1024, 1) }} KB</td>
                    <td class="table-cell text-white/50">{{ $file->created_at->format('M d, Y') }}</td>
                    <td class="table-cell">
                        <a href="{{ asset('storage/' . $file->file_path) }}" download="{{ $file->name }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $deliverables->links() }}</div>
@else
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
    <i class="fas fa-cloud-download-alt text-5xl text-white/30 mb-4"></i>
    <h3 class="text-xl font-bold text-white mb-2">No Deliverables Yet</h3>
    <p class="text-white/50 mb-4">Completed project files will appear here for download.</p>
    <a href="{{ route('client.projects.index') }}" class="btn-primary">View Your Projects</a>
</div>
@endif
@endsection
