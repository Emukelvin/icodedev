@extends('layouts.auth')
@section('title', 'Forgot Password')

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
            <div class="absolute -inset-px bg-linear-to-br from-amber-500/15 via-transparent to-primary-500/15 rounded-3xl blur-sm"></div>
            <div class="relative bg-surface-900/70 backdrop-blur-2xl border border-white/[0.08] rounded-3xl p-8 sm:p-10 shadow-2xl shadow-black/30">
                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="absolute inset-0 bg-amber-500/15 rounded-2xl blur-xl scale-150"></div>
                        <div class="relative w-16 h-16 bg-linear-to-br from-amber-500/15 to-amber-600/10 border border-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-lock text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-white mb-2">Forgot your password?</h1>
                    <p class="text-white/40 text-sm leading-relaxed max-w-xs mx-auto">No worries. Enter your email and we'll send you a secure link to reset it.</p>
                </div>

                {{-- Success message --}}
                @if(session('status'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 p-4 rounded-xl mb-6 text-sm flex items-start gap-3">
                    <div class="w-8 h-8 bg-emerald-500/15 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-check text-emerald-400 text-xs"></i></div>
                    <span class="pt-1">{{ session('status') }}</span>
                </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="label">Email Address</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-amber-400 transition-colors duration-300"><i class="fas fa-envelope text-sm"></i></span>
                            <input type="email" name="email" class="input-field pl-11" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                        </div>
                        @error('email')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full relative group">
                        <div class="absolute -inset-0.5 bg-linear-to-r from-amber-500 to-primary-500 rounded-xl blur opacity-50 group-hover:opacity-80 transition-opacity duration-500"></div>
                        <div class="relative bg-linear-to-r from-amber-600 to-amber-500 text-white py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300">
                            <i class="fas fa-paper-plane text-xs"></i>
                            <span>Send Reset Link</span>
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

        {{-- Trust indicators --}}
        <div class="flex items-center justify-center gap-6 mt-8 text-white/20 text-[11px]">
            <span class="flex items-center gap-1.5"><i class="fas fa-shield-halved text-[10px]"></i> Secure</span>
            <span class="flex items-center gap-1.5"><i class="fas fa-clock text-[10px]"></i> Link expires in 60 min</span>
        </div>
    </div>
</div>
@endsection
