@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-[420px]">
        {{-- Logo --}}
        <div class="text-center mb-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                @if(!empty($siteSettings['logo_url']))
                <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10 group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-10 h-10 bg-linear-to-br from-primary-600 to-secondary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:scale-105 transition-transform duration-500">
                    <span class="text-white font-bold">&lt;/&gt;</span>
                </div>
                <span class="text-2xl font-black">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                @endif
            </a>
        </div>

        {{-- Card --}}
        <div class="relative">
            <div class="absolute -inset-px bg-linear-to-br from-primary-500/15 via-transparent to-secondary-500/15 rounded-3xl blur-sm"></div>
            <div class="relative bg-surface-900/70 backdrop-blur-2xl border border-white/[0.08] rounded-3xl p-8 sm:p-10 shadow-2xl shadow-black/30">
                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-primary-500/15 rounded-2xl blur-xl scale-150"></div>
                        <div class="relative w-16 h-16 bg-linear-to-br from-primary-500/15 to-primary-600/10 border border-primary-500/20 text-primary-400 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-key text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-white mb-2">Set new password</h1>
                    <p class="text-white/40 text-sm leading-relaxed max-w-xs mx-auto">Choose a strong, unique password to protect your account.</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    {{-- Email display --}}
                    <div class="bg-white/[0.03] border border-white/[0.06] rounded-xl px-4 py-3 flex items-center gap-3">
                        <div class="w-7 h-7 bg-primary-500/10 rounded-lg flex items-center justify-center"><i class="fas fa-envelope text-primary-400 text-[10px]"></i></div>
                        <span class="text-white/45 text-sm">{{ $email ?? old('email') }}</span>
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label class="label">New Password</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-lock text-sm"></i></span>
                            <input type="password" name="password" id="password" class="input-field pl-11 pr-11" placeholder="Min. 8 characters" required autofocus>
                            <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/20 hover:text-white/50 transition-colors"><i class="fas fa-eye text-sm"></i></button>
                        </div>
                        @error('password')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        {{-- Strength bar --}}
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex gap-1 flex-1" id="strength-bar">
                                <div class="h-1 flex-1 rounded-full bg-white/8 transition-all duration-500"></div>
                                <div class="h-1 flex-1 rounded-full bg-white/8 transition-all duration-500"></div>
                                <div class="h-1 flex-1 rounded-full bg-white/8 transition-all duration-500"></div>
                                <div class="h-1 flex-1 rounded-full bg-white/8 transition-all duration-500"></div>
                            </div>
                            <span id="strength-bar-label" class="text-xs font-medium text-white/20"></span>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="label">Confirm New Password</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-lock text-sm"></i></span>
                            <input type="password" name="password_confirmation" class="input-field pl-11" placeholder="Repeat new password" required>
                        </div>
                    </div>

                    {{-- Requirements hint --}}
                    <div class="bg-white/[0.02] border border-white/[0.04] rounded-xl p-3.5">
                        <p class="text-[10px] text-white/25 uppercase tracking-wider font-medium mb-2">Password Requirements</p>
                        <div class="grid grid-cols-2 gap-1.5 text-xs text-white/30">
                            <span class="flex items-center gap-1.5"><i class="fas fa-check text-[8px]"></i> 8+ characters</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-check text-[8px]"></i> Uppercase letter</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-check text-[8px]"></i> Number</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-check text-[8px]"></i> Special character</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full relative group">
                        <div class="absolute -inset-0.5 bg-linear-to-r from-primary-600 to-secondary-600 rounded-xl blur opacity-50 group-hover:opacity-80 transition-opacity duration-500"></div>
                        <div class="relative bg-linear-to-r from-primary-600 to-primary-500 text-white py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300">
                            <i class="fas fa-check-circle text-xs"></i>
                            <span>Reset Password</span>
                        </div>
                    </button>
                </form>

                <div class="text-center mt-8 pt-6 border-t border-white/[0.06]">
                    <a href="{{ route('login') }}" class="text-sm text-white/35 hover:text-primary-400 transition-colors inline-flex items-center gap-2 group">
                        <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform duration-300"></i> Back to sign in
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>initStrengthBar('password', 'strength-bar');</script>
@endpush
