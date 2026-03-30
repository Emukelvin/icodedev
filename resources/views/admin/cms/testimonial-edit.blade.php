@extends('layouts.dashboard')
@section('title', 'Edit Testimonial - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.cms.testimonials') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
    <div>
        <h1 class="text-2xl font-black text-white">Edit Testimonial</h1>
        <p class="text-sm text-white/50 mt-1">Update testimonial from {{ $testimonial->client_name }}</p>
    </div>
</div>

<form action="{{ route('admin.cms.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf @method('PUT')

    {{-- Client Info --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-user text-primary-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Client Information</h2>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Client Name *</label><input type="text" name="client_name" class="input-field" required value="{{ old('client_name', $testimonial->client_name) }}"></div>
                <div><label class="label">Company</label><input type="text" name="client_company" class="input-field" value="{{ old('client_company', $testimonial->client_company) }}"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Position</label><input type="text" name="client_position" class="input-field" value="{{ old('client_position', $testimonial->client_position) }}"></div>
                <div>
                    <label class="label">Rating *</label>
                    <select name="rating" class="input-field" required>
                        @for($i=5;$i>=1;$i--)
                        <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div>
                <label class="label">Avatar</label>
                <div class="flex items-center gap-4">
                    @if($testimonial->client_avatar)
                    <img src="{{ asset('storage/' . $testimonial->client_avatar) }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-white/10">
                    @else
                    <div class="w-16 h-16 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <span class="text-xl font-black text-primary-400">{{ strtoupper(substr($testimonial->client_name, 0, 1)) }}</span>
                    </div>
                    @endif
                    <input type="file" name="client_avatar" class="input-field flex-1 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25" accept="image/*">
                </div>
            </div>
        </div>
    </div>

    {{-- Testimonial Content --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-quote-left text-amber-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Testimonial Content</h2>
        </div>
        <div class="p-6">
            <textarea name="content" rows="5" class="input-field" required placeholder="What did the client say...">{{ old('content', $testimonial->content) }}</textarea>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.cms.testimonials') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Update Testimonial</button>
    </div>
</form>
@endsection
