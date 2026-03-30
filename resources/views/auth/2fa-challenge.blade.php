@extends('layouts.auth')
@section('title', 'Verify Your Identity')

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
                            <i class="fas fa-shield-halved text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-white mb-2">Verify Your Identity</h1>
                    <p class="text-white/40 text-sm leading-relaxed max-w-xs mx-auto">Enter the 6-digit code from your authenticator app or use a recovery code.</p>
                </div>

                {{-- Errors --}}
                @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/20 text-red-300 p-4 rounded-xl mb-6 text-sm flex items-start gap-3">
                    <div class="w-8 h-8 bg-red-500/15 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-exclamation text-red-400 text-xs"></i></div>
                    <span class="pt-1">{{ session('error') }}</span>
                </div>
                @endif
                @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-300 p-4 rounded-xl mb-6 text-sm flex items-start gap-3">
                    <div class="w-8 h-8 bg-red-500/15 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-exclamation text-red-400 text-xs"></i></div>
                    <span class="pt-1">{{ $errors->first() }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="label">Authentication Code</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-fingerprint text-sm"></i></span>
                            <input type="text" name="code" id="code" maxlength="10" autocomplete="one-time-code" autofocus class="input-field pl-11 text-center text-xl tracking-[0.4em] font-mono" placeholder="000000">
                        </div>
                    </div>

                    <button type="submit" class="w-full relative group">
                        <div class="absolute -inset-0.5 bg-linear-to-r from-primary-600 to-secondary-600 rounded-xl blur opacity-50 group-hover:opacity-80 transition-opacity duration-500"></div>
                        <div class="relative bg-linear-to-r from-primary-600 to-primary-500 text-white py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300">
                            <i class="fas fa-check-circle text-xs"></i>
                            <span>Verify & Continue</span>
                        </div>
                    </button>
                </form>

                {{-- Recovery help --}}
                <div class="mt-8 pt-6 border-t border-white/[0.06]">
                    <div class="bg-white/[0.02] border border-white/[0.04] rounded-xl p-4 mb-5">
                        <p class="text-white/35 text-sm font-medium mb-1">Lost access to your authenticator?</p>
                        <p class="text-white/20 text-xs leading-relaxed">Enter one of your recovery codes in the field above instead of the 6-digit code.</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-white/30 hover:text-white/55 transition-colors inline-flex items-center gap-2 group">
                            <i class="fas fa-arrow-right-from-bracket text-xs group-hover:translate-x-0.5 transition-transform duration-300"></i> Sign out & use different account
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Security note --}}
        <div class="text-center mt-8 text-white/20 text-[11px] flex items-center justify-center gap-2">
            <i class="fas fa-lock text-[10px]"></i>
            <span>Two-factor authentication keeps your account secure</span>
        </div>
    </div>
</div>
@endsection
