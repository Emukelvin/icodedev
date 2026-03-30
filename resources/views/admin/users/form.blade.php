@extends('layouts.dashboard')
@section('title', ($user->exists ? 'Edit' : 'Create') . ' User - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.users.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ $user->exists ? 'Edit' : 'Create' }} User</h1><p class="text-sm text-white/50 mt-1">{{ $user->exists ? 'Update user details and permissions' : 'Add a new user to the platform' }}</p></div>
</div>

<form action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 max-w-3xl space-y-6">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Full Name *</label><input type="text" name="name" class="input-field" value="{{ old('name', $user->name) }}" required>@error('name')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
        <div><label class="label">Email *</label><input type="email" name="email" class="input-field" value="{{ old('email', $user->email) }}" required>@error('email')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Phone</label><input type="tel" name="phone" class="input-field" value="{{ old('phone', $user->phone) }}"></div>
        <div><label class="label">Company</label><input type="text" name="company" class="input-field" value="{{ old('company', $user->company) }}"></div>
    </div>
    <div class="grid md:grid-cols-2 gap-5">
        <div><label class="label">Role *</label><select name="role" class="input-field" required>@foreach(['client','developer','manager','admin'] as $r)<option value="{{ $r }}" {{ old('role', $user->role ?? 'client') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>@endforeach</select></div>
        <div><label class="label">Password{{ $user->exists ? ' (leave blank to keep)' : ' *' }}</label><input type="password" name="password" class="input-field" {{ $user->exists ? '' : 'required' }}>@error('password')<p class="text-red-400 text-sm mt-1">{{ $message }}</p>@enderror</div>
    </div>
    <div><label class="label">Bio</label><textarea name="bio" rows="3" class="input-field">{{ old('bio', $user->bio) }}</textarea></div>
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">{{ $user->exists ? 'Update' : 'Create' }} User</button>
    </div>
</form>
@endsection
