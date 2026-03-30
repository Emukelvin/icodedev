@extends('layouts.dashboard')
@section('title', 'Profile - ICodeDev')

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">My Profile</h1>
    <p class="text-sm text-white/50 mt-1">Manage your account settings</p>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8">
        @csrf @method('PUT')
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Personal Information</h2>
        <div class="flex items-center gap-6 mb-6">
            <img src="{{ auth()->user()->avatar_url }}" class="w-20 h-20 rounded-full object-cover" id="avatar-preview">
            <div><label class="btn-secondary cursor-pointer text-sm"><i class="fas fa-camera mr-1"></i> Change Photo<input type="file" name="avatar" class="hidden" accept="image/*" onchange="document.getElementById('avatar-preview').src=URL.createObjectURL(this.files[0])"></label></div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 mb-4">
            <div><label class="label">Full Name</label><input type="text" name="name" class="input-field" value="{{ old('name', auth()->user()->name) }}" required>@error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="label">Email</label><input type="email" name="email" class="input-field" value="{{ old('email', auth()->user()->email) }}" required>@error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        </div>
        <div class="grid md:grid-cols-2 gap-5 mb-4">
            <div><label class="label">Phone</label><input type="tel" name="phone" class="input-field" value="{{ old('phone', auth()->user()->phone) }}"></div>
            <div><label class="label">Company</label><input type="text" name="company" class="input-field" value="{{ old('company', auth()->user()->company) }}"></div>
        </div>
        <div class="mb-6"><label class="label">Bio</label><textarea name="bio" rows="3" class="input-field">{{ old('bio', auth()->user()->bio) }}</textarea></div>
        <button type="submit" class="btn-primary">Save Changes</button>
    </form>

    <form action="{{ route('client.profile.password') }}" method="POST" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 h-fit">
        @csrf @method('PUT')
        <h2 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5">Change Password</h2>
        <div class="mb-4"><label class="label">Current Password</label><input type="password" name="current_password" class="input-field" required>@error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        <div class="mb-4"><label class="label">New Password</label><input type="password" name="password" class="input-field" required>@error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror</div>
        <div class="mb-6"><label class="label">Confirm New Password</label><input type="password" name="password_confirmation" class="input-field" required></div>
        <button type="submit" class="btn-primary">Update Password</button>
    </form>
</div>
@endsection
