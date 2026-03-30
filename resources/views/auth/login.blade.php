@extends('layouts.auth')
@section('title', 'Sign In')

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
                Build something<br>
                <span class="text-transparent bg-clip-text bg-linear-to-r from-primary-400 via-secondary-400 to-accent-400 animate-gradient">extraordinary</span>
            </h2>
            <p class="text-white/45 text-lg leading-relaxed mb-12">Manage projects, collaborate with your team, and deliver world-class digital experiences.</p>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-3 mb-12">
                @foreach([['200+', 'Projects', 'fas fa-code'], ['50+', 'Clients', 'fas fa-users'], ['99%', 'Uptime', 'fas fa-chart-line']] as $stat)
                <div class="group">
                    <div class="bg-white/[0.03] border border-white/[0.06] rounded-2xl p-4 text-center hover:bg-white/[0.06] hover:border-primary-500/20 transition-all duration-500">
                        <div class="w-8 h-8 mx-auto mb-3 bg-primary-500/10 rounded-xl flex items-center justify-center">
                            <i class="{{ $stat[2] }} text-primary-400 text-xs"></i>
                        </div>
                        <div class="text-xl font-black text-white">{{ $stat[0] }}</div>
                        <div class="text-[10px] text-white/35 mt-1 uppercase tracking-widest font-medium">{{ $stat[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Testimonial --}}
            <div class="relative">
                <div class="absolute -inset-px bg-linear-to-r from-primary-500/10 to-secondary-500/10 rounded-2xl blur-sm"></div>
                <div class="relative bg-white/[0.03] border border-white/[0.06] rounded-2xl p-6">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 0; $i < 5; $i++)<i class="fas fa-star text-amber-400 text-[10px]"></i>@endfor
                    </div>
                    <p class="text-white/50 text-sm italic leading-relaxed">"{{ $siteSettings['site_name'] ?? 'ICodeDev' }} transformed our digital presence. The platform is intuitive, powerful, and beautifully designed."</p>
                    <div class="flex items-center gap-3 mt-4">
                        <div class="w-9 h-9 rounded-xl bg-linear-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-primary-500/20">A</div>
                        <div>
                            <div class="text-white/80 text-sm font-semibold">Alex Johnson</div>
                            <div class="text-white/30 text-xs">CEO, TechCorp</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Panel - Login Form --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12 sm:px-10">
        <div class="w-full max-w-[420px]">
            {{-- Mobile Logo --}}
            <div class="lg:hidden text-center mb-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    @if(!empty($siteSettings['logo_url']))
                    <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10">
                    @else
                    <div class="w-10 h-10 bg-linear-to-br from-primary-600 to-secondary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <span class="text-white font-bold">&lt;/&gt;</span>
                    </div>
                    <span class="text-2xl font-black">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                    @endif
                </a>
            </div>

            {{-- Form Card --}}
            <div class="relative">
                <div class="absolute -inset-px bg-linear-to-br from-primary-500/15 via-transparent to-secondary-500/15 rounded-3xl blur-sm"></div>
                <div class="relative bg-surface-900/70 backdrop-blur-2xl border border-white/[0.08] rounded-3xl p-8 sm:p-10 shadow-2xl shadow-black/30">
                    {{-- Header --}}
                    <div class="mb-8">
                        <div class="w-12 h-12 bg-linear-to-br from-primary-500/15 to-primary-600/10 border border-primary-500/20 rounded-2xl flex items-center justify-center mb-5">
                            <i class="fas fa-arrow-right-to-bracket text-primary-400 text-lg"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-1.5">Welcome back</h1>
                        <p class="text-white/40 text-sm">Sign in to your account to continue</p>
                    </div>

                    <form action="{{ url('login') }}" method="POST" class="space-y-5">
                        @csrf
                        {{-- Email --}}
                        <div>
                            <label class="label">Email Address</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-envelope text-sm"></i></span>
                                <input type="email" name="email" class="input-field pl-11" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                            </div>
                            @error('email')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-semibold text-white/60">Password</label>
                                <a href="{{ route('password.request') }}" class="text-xs text-primary-400/80 hover:text-primary-300 transition-colors font-medium">Forgot password?</a>
                            </div>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-lock text-sm"></i></span>
                                <input type="password" name="password" id="password" class="input-field pl-11 pr-11" placeholder="••••••••" required>
                                <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/20 hover:text-white/50 transition-colors"><i class="fas fa-eye text-sm"></i></button>
                            </div>
                            @error('password')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>

                        {{-- Remember --}}
                        <div class="flex items-center pt-1">
                            <label class="flex items-center gap-2.5 text-sm text-white/45 cursor-pointer group select-none">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded-md border-white/15 bg-white/5 text-primary-500 focus:ring-primary-500/30 focus:ring-offset-0 transition-colors">
                                <span class="group-hover:text-white/65 transition-colors">Remember me for 30 days</span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full relative group mt-1">
                            <div class="absolute -inset-0.5 bg-linear-to-r from-primary-600 to-primary-500 rounded-xl blur opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative bg-linear-to-r from-primary-600 to-primary-500 text-white py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300">
                                <span>Sign In</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/[0.06]"></div></div>
                        <div class="relative flex justify-center text-[10px]"><span class="bg-surface-900/70 px-4 text-white/25 uppercase tracking-[0.2em] font-medium">New here?</span></div>
                    </div>

                    {{-- Register link --}}
                    <p class="text-center text-white/40 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary-400 font-semibold hover:text-primary-300 transition-colors inline-flex items-center gap-1">
                            Create one free <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </p>
                </div>
            </div>

            {{-- Trust indicators --}}
            <div class="flex items-center justify-center gap-6 mt-8 text-white/20 text-[11px]">
                <span class="flex items-center gap-1.5"><i class="fas fa-shield-halved text-[10px]"></i> SSL Secured</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-lock text-[10px]"></i> Encrypted</span>
                <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-[10px]"></i> GDPR</span>
            </div>
        </div>
    </div>
</div>
@endsection
