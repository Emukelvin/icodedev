<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteSettings['maintenance_title'] ?? "We'll Be Back Soon" }} - {{ $siteSettings['site_name'] ?? 'ICodeDev' }}</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{ !empty($siteSettings['favicon_url']) ? asset($siteSettings['favicon_url']) : asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-950 min-h-screen text-white antialiased">
    {{-- Background Effects --}}
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-surface-950"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(99,102,241,0.12)_0%,transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(6,182,212,0.08)_0%,transparent_50%)]"></div>
        <div class="aurora">
            <div class="aurora-blob w-[500px] h-[400px] bg-primary-600/10 top-[-15%] right-[-10%]" style="animation-duration:18s"></div>
            <div class="aurora-blob w-[400px] h-[350px] bg-secondary-500/8 bottom-[-15%] left-[-8%]" style="animation-duration:22s"></div>
        </div>
        <div class="absolute inset-0 cyber-grid opacity-[0.08] pointer-events-none"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-4">
        <div class="max-w-lg w-full text-center">
            {{-- Logo --}}
            <div class="mb-10">
                @if(!empty($siteSettings['logo_url']))
                <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-14 mx-auto">
                @else
                <div class="flex items-center justify-center gap-3">
                    <div class="w-12 h-12 bg-linear-to-br from-primary-600 via-primary-500 to-secondary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <span class="text-white font-bold text-xl">&lt;/&gt;</span>
                    </div>
                    <span class="text-3xl font-black tracking-tight text-white">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                </div>
                @endif
            </div>

            {{-- Icon --}}
            <div class="w-24 h-24 mx-auto mb-8 bg-linear-to-br from-amber-500/15 to-orange-500/15 rounded-3xl flex items-center justify-center ring-1 ring-amber-500/20 shadow-lg shadow-amber-500/10">
                <i class="fas fa-tools text-4xl text-amber-400 animate-pulse"></i>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl md:text-4xl font-black mb-4">
                <span class="gradient-text">{{ $siteSettings['maintenance_title'] ?? "We'll Be Back Soon" }}</span>
            </h1>

            {{-- Message --}}
            <p class="text-white/50 text-lg leading-relaxed mb-10 max-w-md mx-auto">
                {{ $siteSettings['maintenance_message'] ?? "We're performing scheduled maintenance. Please check back shortly." }}
            </p>

            {{-- Animated dots --}}
            <div class="flex items-center justify-center gap-2 mb-10">
                <div class="w-2.5 h-2.5 bg-primary-500 rounded-full animate-bounce" style="animation-delay:0s"></div>
                <div class="w-2.5 h-2.5 bg-secondary-500 rounded-full animate-bounce" style="animation-delay:0.15s"></div>
                <div class="w-2.5 h-2.5 bg-accent-500 rounded-full animate-bounce" style="animation-delay:0.3s"></div>
            </div>

            {{-- Contact / Login --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if(!empty($siteSettings['contact_email']))
                <a href="mailto:{{ $siteSettings['contact_email'] }}" class="px-6 py-3 rounded-xl bg-white/5 ring-1 ring-white/10 text-white/60 text-sm font-semibold hover:bg-white/10 hover:text-white transition-all duration-300">
                    <i class="fas fa-envelope mr-2"></i>{{ $siteSettings['contact_email'] }}
                </a>
                @endif
                <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-primary-500/10 ring-1 ring-primary-500/20 text-primary-400 text-sm font-semibold hover:bg-primary-500/20 transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>Staff Login
                </a>
            </div>

            {{-- Social Links --}}
            @php
                $maintenanceSocials = collect([
                    ['key' => 'social_twitter', 'icon' => 'fab fa-x-twitter'],
                    ['key' => 'social_facebook', 'icon' => 'fab fa-facebook-f'],
                    ['key' => 'social_instagram', 'icon' => 'fab fa-instagram'],
                    ['key' => 'social_linkedin', 'icon' => 'fab fa-linkedin-in'],
                ])->filter(fn($s) => !empty($siteSettings[$s['key']]));
            @endphp
            @if($maintenanceSocials->isNotEmpty())
            <div class="flex items-center justify-center gap-3 mt-8">
                @foreach($maintenanceSocials as $social)
                <a href="{{ $siteSettings[$social['key']] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all duration-300">
                    <i class="{{ $social['icon'] }}"></i>
                </a>
                @endforeach
            </div>
            @endif

            {{-- Copyright --}}
            <p class="text-white/20 text-xs mt-12">&copy; {{ date('Y') }} {{ $siteSettings['copyright_text'] ?? ($siteSettings['site_name'] ?? 'ICodeDev') . '. All rights reserved.' }}</p>
        </div>
    </div>
</body>
</html>
