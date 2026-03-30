@extends('layouts.auth')
@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex">
    {{-- Left Panel - Branding (Desktop) --}}
    <div class="hidden lg:flex lg:w-[48%] relative items-center justify-center p-12 xl:p-16">
        <div class="absolute inset-0 bg-linear-to-br from-primary-950/50 via-surface-950 to-surface-950"></div>
        <div class="absolute inset-y-0 right-0 w-px bg-linear-to-b from-transparent via-white/8 to-transparent"></div>

        <div class="relative z-10 max-w-md">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-12 group">
                @if(!empty($siteSettings['logo_url']))
                <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-12 group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-12 h-12 bg-linear-to-br from-primary-600 via-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 group-hover:scale-105 transition-all duration-500">
                    <span class="text-white font-bold text-lg">&lt;/&gt;</span>
                </div>
                <span class="text-2xl font-black tracking-tight">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                @endif
            </a>

            {{-- Heading --}}
            <h2 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-4">
                Almost there!
            </h2>
            <p class="text-white/45 text-lg leading-relaxed mb-12">Just one more step to unlock your full dashboard experience.</p>

            {{-- Info cards --}}
            <div class="space-y-4">
                @foreach([
                    ['fas fa-shield-alt', 'Account Security', 'Email verification keeps your account safe and secure.'],
                    ['fas fa-bell', 'Notifications', 'Get important project updates and payment alerts by email.'],
                    ['fas fa-envelope-open-text', 'Communication', 'Stay connected with your development team.'],
                ] as $item)
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                    <div class="w-10 h-10 bg-primary-500/10 rounded-xl flex items-center justify-center shrink-0">
                        <i class="{{ $item[0] }} text-primary-400 text-sm"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-white">{{ $item[1] }}</div>
                        <div class="text-xs text-white/40 mt-0.5">{{ $item[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Panel --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 xl:p-16">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="lg:hidden mb-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    @if(!empty($siteSettings['logo_url']))
                    <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10 group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-10 h-10 bg-linear-to-br from-primary-600 via-primary-500 to-secondary-500 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-sm">&lt;/&gt;</span>
                    </div>
                    <span class="text-xl font-black tracking-tight">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                    @endif
                </a>
            </div>

            {{-- Main Card --}}
            <div class="bg-surface-800/40 backdrop-blur-xl rounded-3xl border border-white/[0.06] p-8 sm:p-10">
                {{-- Icon --}}
                <div class="w-16 h-16 mx-auto mb-6 bg-linear-to-br from-primary-600/20 via-primary-500/15 to-secondary-500/10 rounded-2xl flex items-center justify-center border border-primary-500/20">
                    <i class="fas fa-envelope text-primary-400 text-2xl"></i>
                </div>

                <h1 class="text-2xl font-bold text-white text-center mb-2">Verify Your Email</h1>
                <p class="text-white/45 text-center text-sm leading-relaxed mb-8">
                    We've sent a verification link to <span class="text-white font-medium">{{ auth()->user()->email }}</span>. Please check your inbox and click the link to verify your account.
                </p>

                @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <p class="text-sm text-emerald-300">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                {{-- Steps --}}
                <div class="space-y-3 mb-8">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                        <div class="w-8 h-8 bg-primary-500/20 rounded-lg flex items-center justify-center shrink-0">
                            <span class="text-primary-400 text-xs font-bold">1</span>
                        </div>
                        <span class="text-sm text-white/60">Open your email inbox</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                        <div class="w-8 h-8 bg-primary-500/20 rounded-lg flex items-center justify-center shrink-0">
                            <span class="text-primary-400 text-xs font-bold">2</span>
                        </div>
                        <span class="text-sm text-white/60">Find the email from {{ $siteSettings['site_name'] ?? 'ICodeDev' }}</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.03] border border-white/[0.06]">
                        <div class="w-8 h-8 bg-primary-500/20 rounded-lg flex items-center justify-center shrink-0">
                            <span class="text-primary-400 text-xs font-bold">3</span>
                        </div>
                        <span class="text-sm text-white/60">Click the verification button in the email</span>
                    </div>
                </div>

                {{-- Resend form --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full relative group cursor-pointer">
                        <div class="absolute -inset-1 bg-linear-to-r from-primary-600 via-secondary-500 to-primary-600 rounded-2xl opacity-60 blur-lg group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative bg-linear-to-r from-primary-600 to-secondary-600 hover:from-primary-500 hover:to-secondary-500 text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 text-sm shadow-xl">
                            <i class="fas fa-paper-plane"></i>
                            Resend Verification Email
                        </div>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-4 my-6">
                    <div class="flex-1 h-px bg-white/[0.06]"></div>
                    <span class="text-xs text-white/25 font-medium">OR</span>
                    <div class="flex-1 h-px bg-white/[0.06]"></div>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm text-white/40 hover:text-white/70 transition-colors py-2">
                        <i class="fas fa-sign-out-alt mr-1"></i> Sign out and use a different account
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <p class="text-center text-xs text-white/25 mt-6">
                Didn't receive the email? Check your spam folder or contact
                <a href="mailto:{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}" class="text-primary-400 hover:text-primary-300">support</a>.
            </p>
        </div>
    </div>
</div>
@endsection
