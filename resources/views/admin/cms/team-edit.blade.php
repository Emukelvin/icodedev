@extends('layouts.dashboard')
@section('title', 'Edit Team Member - Admin')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.cms.team-members') }}" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
    <div>
        <h1 class="text-2xl font-black text-white">Edit Team Member</h1>
        <p class="text-sm text-white/50 mt-1">Update {{ $teamMember->name }}'s profile</p>
    </div>
</div>

<form action="{{ route('admin.cms.team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf @method('PUT')

    {{-- Profile Info --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-user text-primary-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Profile Information</h2>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Name *</label><input type="text" name="name" class="input-field" required value="{{ old('name', $teamMember->name) }}"></div>
                <div><label class="label">Position *</label><input type="text" name="position" class="input-field" required value="{{ old('position', $teamMember->position) }}"></div>
            </div>
            <div><label class="label">Email</label><input type="email" name="email" class="input-field" value="{{ old('email', $teamMember->email) }}" placeholder="team@company.com"></div>
            <div><label class="label">Bio</label><textarea name="bio" rows="3" class="input-field" placeholder="Short bio or description...">{{ old('bio', $teamMember->bio) }}</textarea></div>
            <div>
                <label class="label">Photo</label>
                <div class="flex items-center gap-4">
                    @if($teamMember->avatar)
                    <img src="{{ asset('storage/' . $teamMember->avatar) }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-white/10">
                    @elseif($teamMember->photo)
                    <img src="{{ Storage::url($teamMember->photo) }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-white/10">
                    @else
                    <div class="w-16 h-16 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <span class="text-xl font-black text-primary-400">{{ strtoupper(substr($teamMember->name, 0, 1)) }}</span>
                    </div>
                    @endif
                    <input type="file" name="avatar" class="input-field flex-1 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25" accept="image/*">
                </div>
            </div>
        </div>
    </div>

    {{-- Social Links --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-blue-500/15 flex items-center justify-center"><i class="fas fa-share-alt text-blue-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Social Links</h2>
        </div>
        <div class="p-6">
            @php $socials = is_string($teamMember->social_links) ? json_decode($teamMember->social_links, true) : ($teamMember->social_links ?? []); @endphp
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label"><i class="fab fa-github text-white/30 mr-1.5"></i>GitHub</label>
                    <input type="url" name="github" class="input-field" value="{{ old('github', $socials['github'] ?? '') }}" placeholder="https://github.com/...">
                </div>
                <div>
                    <label class="label"><i class="fab fa-linkedin text-white/30 mr-1.5"></i>LinkedIn</label>
                    <input type="url" name="linkedin" class="input-field" value="{{ old('linkedin', $socials['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/...">
                </div>
                <div>
                    <label class="label"><i class="fab fa-twitter text-white/30 mr-1.5"></i>Twitter</label>
                    <input type="url" name="twitter" class="input-field" value="{{ old('twitter', $socials['twitter'] ?? '') }}" placeholder="https://twitter.com/...">
                </div>
                <div>
                    <label class="label"><i class="fas fa-globe text-white/30 mr-1.5"></i>Website</label>
                    <input type="url" name="website" class="input-field" value="{{ old('website', $socials['website'] ?? '') }}" placeholder="https://...">
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.cms.team-members') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Update Member</button>
    </div>
</form>
@endsection
