@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
<div class="min-h-screen flex">
    {{-- Left Panel - Branding (Desktop) --}}
    <div class="hidden lg:flex lg:w-[44%] relative items-center justify-center p-12 xl:p-16">
        <div class="absolute inset-0 bg-linear-to-br from-secondary-950/50 via-surface-950 to-surface-950"></div>
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
                Start your<br>
                <span class="text-transparent bg-clip-text bg-linear-to-r from-accent-400 via-secondary-400 to-primary-400 animate-gradient">journey today</span>
            </h2>
            <p class="text-white/45 text-lg leading-relaxed mb-12">Create your free account and unlock powerful tools for project management and collaboration.</p>

            {{-- Features --}}
            <div class="space-y-5">
                @foreach([
                    ['fas fa-bolt', 'from-amber-500/15 to-orange-500/10', 'border-amber-500/15', 'text-amber-400', 'Lightning Fast Setup', 'Get started in under 2 minutes with guided onboarding.'],
                    ['fas fa-shield-halved', 'from-emerald-500/15 to-teal-500/10', 'border-emerald-500/15', 'text-emerald-400', 'Enterprise Security', 'Bank-grade encryption and two-factor authentication.'],
                    ['fas fa-headset', 'from-blue-500/15 to-indigo-500/10', 'border-blue-500/15', 'text-blue-400', '24/7 Expert Support', 'Our team is always here to help you succeed.'],
                    ['fas fa-infinity', 'from-purple-500/15 to-violet-500/10', 'border-purple-500/15', 'text-purple-400', 'Unlimited Potential', 'Scale your projects with no limits whatsoever.']
                ] as $feature)
                <div class="flex items-start gap-4 group">
                    <div class="w-10 h-10 shrink-0 bg-linear-to-br {{ $feature[1] }} border {{ $feature[2] }} rounded-xl flex items-center justify-center {{ $feature[3] }} group-hover:scale-110 transition-all duration-500">
                        <i class="{{ $feature[0] }} text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-white/85 font-semibold text-sm">{{ $feature[4] }}</h4>
                        <p class="text-white/35 text-xs mt-0.5 leading-relaxed">{{ $feature[5] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Trusted by --}}
            <div class="mt-12 pt-8 border-t border-white/[0.06]">
                <p class="text-[10px] text-white/25 uppercase tracking-[0.2em] font-medium mb-4">Trusted by teams at</p>
                <div class="flex items-center gap-6 text-white/15">
                    <span class="text-sm font-bold tracking-wider">TechCorp</span>
                    <span class="text-sm font-bold tracking-wider">StartupNG</span>
                    <span class="text-sm font-bold tracking-wider">DevLabs</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Panel - Register Form --}}
    <div class="flex-1 flex items-center justify-center px-6 py-10 sm:px-10">
        <div class="w-full max-w-[480px]">
            {{-- Mobile Logo --}}
            <div class="lg:hidden text-center mb-8">
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
                <div class="absolute -inset-px bg-linear-to-br from-accent-500/15 via-transparent to-primary-500/15 rounded-3xl blur-sm"></div>
                <div class="relative bg-surface-900/70 backdrop-blur-2xl border border-white/[0.08] rounded-3xl p-8 sm:p-10 shadow-2xl shadow-black/30">
                    {{-- Header --}}
                    <div class="mb-7">
                        <div class="w-12 h-12 bg-linear-to-br from-accent-500/15 to-primary-600/10 border border-accent-500/20 rounded-2xl flex items-center justify-center mb-5">
                            <i class="fas fa-user-plus text-accent-400 text-lg"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-1.5">Create your account</h1>
                        <p class="text-white/40 text-sm">Get started with your free account today</p>
                    </div>

                    <form action="{{ url('register') }}" method="POST" class="space-y-4">
                        @csrf
                        {{-- Name --}}
                        <div>
                            <label class="label">Full Name</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-user text-sm"></i></span>
                                <input type="text" name="name" class="input-field pl-11" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                            </div>
                            @error('name')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="label">Email Address</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-envelope text-sm"></i></span>
                                <input type="email" name="email" class="input-field pl-11" value="{{ old('email') }}" placeholder="you@example.com" required>
                            </div>
                            @error('email')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>

                        {{-- Phone & Company --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="label">Phone Number</label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-phone text-sm"></i></span>
                                    <input type="tel" name="phone" class="input-field pl-11" value="{{ old('phone') }}" placeholder="+234...">
                                </div>
                                @error('phone')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="label">Company <span class="text-white/20 text-xs font-normal">(optional)</span></label>
                                <div class="relative group">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-building text-sm"></i></span>
                                    <input type="text" name="company" class="input-field pl-11" value="{{ old('company') }}" placeholder="Your company">
                                </div>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="label">Password</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-lock text-sm"></i></span>
                                <input type="password" name="password" id="reg-password" class="input-field pl-11 pr-11" placeholder="Min. 8 characters" required>
                                <button type="button" onclick="togglePassword('reg-password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/20 hover:text-white/50 transition-colors"><i class="fas fa-eye text-sm"></i></button>
                            </div>
                            @error('password')<p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                            {{-- Password strength --}}
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
                            <label class="label">Confirm Password</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-primary-400 transition-colors duration-300"><i class="fas fa-lock text-sm"></i></span>
                                <input type="password" name="password_confirmation" class="input-field pl-11" placeholder="Repeat password" required>
                            </div>
                        </div>

                        {{-- reCAPTCHA --}}
                        @include('partials.recaptcha')

                        {{-- Terms --}}
                        <div class="pt-1">
                            <label class="flex items-start gap-2.5 text-xs text-white/35 cursor-pointer group select-none">
                                <input type="checkbox" name="terms" required class="w-4 h-4 mt-0.5 rounded-md border-white/15 bg-white/5 text-primary-500 focus:ring-primary-500/30 focus:ring-offset-0 shrink-0">
                                <span class="group-hover:text-white/55 transition-colors leading-relaxed">I agree to the <a href="{{ route('terms') }}" class="text-primary-400 hover:text-primary-300 underline underline-offset-2">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-primary-400 hover:text-primary-300 underline underline-offset-2">Privacy Policy</a></span>
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full relative group mt-1">
                            <div class="absolute -inset-0.5 bg-linear-to-r from-accent-600 via-primary-600 to-secondary-600 rounded-xl blur opacity-60 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative bg-linear-to-r from-primary-600 to-primary-500 text-white py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300">
                                <span>Create Account</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </button>
                    </form>

                    {{-- Divider --}}
                    <div class="relative my-7">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/[0.06]"></div></div>
                        <div class="relative flex justify-center text-[10px]"><span class="bg-surface-900/70 px-4 text-white/25 uppercase tracking-[0.2em] font-medium">Already a member?</span></div>
                    </div>

                    {{-- Login link --}}
                    <p class="text-center text-white/40 text-sm">
                        Have an account?
                        <a href="{{ route('login') }}" class="text-primary-400 font-semibold hover:text-primary-300 transition-colors inline-flex items-center gap-1">
                            Sign in <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>initStrengthBar('reg-password', 'strength-bar');</script>
@endpush
