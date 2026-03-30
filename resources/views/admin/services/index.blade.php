@extends('layouts.dashboard')
@section('title', 'Services - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Services</h1>
        <p class="text-sm text-white/50 mt-1">Manage the services you offer to clients</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Service</a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($services as $service)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 hover:border-primary-500/20 transition-all duration-300">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-primary-500/15 ring-1 ring-primary-500/20 rounded-2xl flex items-center justify-center"><i class="{{ $service->icon ?? 'fas fa-cog' }} text-primary-400 text-xl"></i></div>
            <div class="flex gap-2">
                <a href="{{ route('admin.services.edit', $service) }}" class="text-amber-400 hover:text-amber-300 transition-colors"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-400 hover:text-red-300 transition-colors"><i class="fas fa-trash"></i></button></form>
            </div>
        </div>
        <h3 class="font-bold text-white mb-2">{{ $service->title }}</h3>
        <p class="text-white/50 text-sm mb-4">{{ Str::limit($service->short_description, 80) }}</p>
        <div class="flex items-center justify-between text-sm">
            <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $service->is_active ? 'bg-green-500/15 text-green-400 ring-1 ring-green-500/20' : 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
            @if($service->starting_price)<span class="font-semibold text-white">{{ $cs }}{{ number_format($service->starting_price) }}+</span>@endif
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12"><p class="text-white/40">No services yet.</p></div>
    @endforelse
</div>
@endsection
