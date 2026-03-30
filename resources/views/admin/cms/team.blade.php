@extends('layouts.dashboard')
@section('title', 'Team Members - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Team Members</h1>
        <p class="text-sm text-white/50 mt-1">Manage your team profiles and bios</p>
    </div>
    <button onclick="document.getElementById('team-modal').style.display='flex'" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Member</button>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($members as $member)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden hover:border-white/12 transition-all group">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-4">
                @if($member->avatar || $member->photo)
                <img src="{{ Storage::url($member->avatar ?? $member->photo) }}" class="w-16 h-16 rounded-xl object-cover ring-1 ring-white/10">
                @else
                <div class="w-16 h-16 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center shrink-0">
                    <span class="text-2xl font-black text-primary-400">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-white text-lg">{{ $member->name }}</h3>
                    <p class="text-primary-400 text-sm font-semibold">{{ $member->position }}</p>
                    @if($member->email)
                    <p class="text-xs text-white/40 mt-1 truncate">{{ $member->email }}</p>
                    @endif
                </div>
            </div>

            @if($member->bio)
            <p class="text-white/50 text-sm leading-relaxed line-clamp-3 mb-4">{{ $member->bio }}</p>
            @endif

            {{-- Social Links --}}
            @if($member->social_links)
            @php $socials = is_string($member->social_links) ? json_decode($member->social_links, true) : $member->social_links; @endphp
            @if($socials && count(array_filter($socials)))
            <div class="flex gap-2 mb-4">
                @foreach(['github' => 'fab fa-github', 'linkedin' => 'fab fa-linkedin', 'twitter' => 'fab fa-twitter', 'website' => 'fas fa-globe'] as $platform => $icon)
                @if(!empty($socials[$platform]))
                <a href="{{ $socials[$platform] }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/30 hover:text-primary-400 hover:bg-primary-500/10 transition-all"><i class="{{ $icon }} text-xs"></i></a>
                @endif
                @endforeach
            </div>
            @endif
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-2 pt-4 border-t border-white/5">
                <a href="{{ route('admin.cms.team-members.edit', $member) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 hover:bg-primary-500/25 transition-all"><i class="fas fa-edit mr-1.5"></i>Edit</a>
                <form action="{{ route('admin.cms.team-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove this team member?')">@csrf @method('DELETE')
                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-400 bg-red-500/10 ring-1 ring-red-500/20 hover:bg-red-500/20 transition-all"><i class="fas fa-trash mr-1.5"></i>Remove</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fas fa-users text-white/15 text-4xl mb-4 block"></i>
        <p class="text-white/40 mb-4">No team members yet</p>
        <button onclick="document.getElementById('team-modal').style.display='flex'" class="btn-primary inline-block"><i class="fas fa-plus mr-2"></i>Add First Member</button>
    </div>
    @endforelse
</div>

{{-- Add Team Member Modal --}}
<div id="team-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center" style="display:none">
    <div class="bg-surface-800/95 backdrop-blur-xl rounded-2xl border border-white/8 max-w-lg w-full mx-4 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-user-plus text-primary-400 text-sm"></i></div>
                <h2 class="text-lg font-bold text-white">Add Team Member</h2>
            </div>
            <button onclick="document.getElementById('team-modal').style.display='none'" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-white/30 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form action="{{ route('admin.cms.team-members.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Name *</label><input type="text" name="name" class="input-field" required placeholder="Full name"></div>
                <div><label class="label">Position *</label><input type="text" name="position" class="input-field" required placeholder="Job title"></div>
            </div>
            <div><label class="label">Bio</label><textarea name="bio" rows="3" class="input-field" placeholder="Short bio or description..."></textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Email</label><input type="email" name="email" class="input-field" placeholder="team@company.com"></div>
                <div>
                    <label class="label">Photo</label>
                    <input type="file" name="avatar" class="input-field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25" accept="image/*">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="label">GitHub</label><input type="url" name="github" class="input-field" placeholder="https://..."></div>
                <div><label class="label">LinkedIn</label><input type="url" name="linkedin" class="input-field" placeholder="https://..."></div>
                <div><label class="label">Twitter</label><input type="url" name="twitter" class="input-field" placeholder="https://..."></div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('team-modal').style.display='none'" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Save Member</button>
            </div>
        </form>
    </div>
</div>
@endsection
