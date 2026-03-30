<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($siteSettings['site_name'] ?? 'ICodeDev') . ' - ' . ($siteSettings['site_tagline'] ?? 'Build Your Dream App'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'ICodeDev - Professional Web, Mobile & Desktop Software Development. Build your dream application with our expert team.')">
    <meta name="keywords" content="{{ $siteSettings['meta_keywords'] ?? 'web development, mobile app, desktop software, Laravel, Flutter, React, ICodeDev' }}">
    <meta property="og:title" content="@yield('title', $siteSettings['site_name'] ?? 'ICodeDev')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Professional Software Development Services')">
    <meta property="og:type" content="website">
    @if(!empty($siteSettings['og_image']))
    <meta property="og:image" content="{{ $siteSettings['og_image'] }}">
    @endif
    <link rel="icon" href="{{ !empty($siteSettings['favicon_url']) ? asset($siteSettings['favicon_url']) : asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    {!! $siteSettings['head_scripts'] ?? '' !!}
</head>
<body class="bg-surface-950 min-h-screen flex flex-col text-white">
    {{-- Announcement Banner --}}
    @if(($siteSettings['enable_announcement'] ?? '0') === '1' && !empty($siteSettings['announcement_text']))
    <div data-dismiss class="bg-linear-to-r from-primary-600 to-secondary-600 text-white text-center py-2.5 px-4 text-sm font-medium relative z-60">
        {{ $siteSettings['announcement_text'] }}
        <button data-close class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white transition-colors"><i class="fas fa-times text-xs"></i></button>
    </div>
    @endif

    {{-- Scroll Progress Bar --}}
    @if(($siteSettings['enable_scroll_progress'] ?? '1') === '1')
    <div id="scroll-progress"></div>
    @endif

    {{-- Particle Canvas (on dark hero pages) --}}
    @hasSection('has-particles')
    <canvas id="particle-canvas"></canvas>
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
        <div data-dismiss class="fixed top-6 right-6 z-100 glass border-emerald-500/20 text-emerald-400 pl-5 pr-4 py-4 rounded-2xl shadow-xl flex items-center gap-3 max-w-sm animate-slide-in">
            <div class="w-9 h-9 bg-linear-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/30"><i class="fas fa-check text-white text-sm"></i></div>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button data-close class="ml-auto text-emerald-400 hover:text-emerald-600 p-1 hover:rotate-90 transition-all duration-300"><i class="fas fa-times text-xs"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div data-dismiss class="fixed top-6 right-6 z-100 glass border-red-500/20 text-red-400 pl-5 pr-4 py-4 rounded-2xl shadow-xl flex items-center gap-3 max-w-sm animate-slide-in">
            <div class="w-9 h-9 bg-linear-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-red-500/30"><i class="fas fa-exclamation text-white text-sm"></i></div>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button data-close class="ml-auto text-red-400 hover:text-red-600 p-1 hover:rotate-90 transition-all duration-300"><i class="fas fa-times text-xs"></i></button>
        </div>
    @endif

    {{-- Navigation --}}
    <nav id="main-nav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group magnetic">
                    @if(!empty($siteSettings['logo_url']))
                    <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10 group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-10 h-10 bg-linear-to-br from-primary-600 via-primary-500 to-secondary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:shadow-primary-500/50 group-hover:scale-110 transition-all duration-500">
                        <span class="text-white font-bold text-lg">&lt;/&gt;</span>
                    </div>
                    <span class="text-2xl font-black tracking-tight"><span class="nav-logo-text">{{ Str::beforeLast($siteSettings['site_name'] ?? 'iCode', substr($siteSettings['site_name'] ?? 'iCodeDev', -3)) }}</span><span class="gradient-text">{{ substr($siteSettings['site_name'] ?? 'iCodeDev', -3) }}</span></span>
                    @endif
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-1">
                    @php $navLinks = [
                        ['route' => 'home', 'label' => 'Home', 'match' => 'home'],
                        ['route' => 'about', 'label' => 'About', 'match' => 'about'],
                        ['route' => 'services', 'label' => 'Services', 'match' => 'services*'],
                        ['route' => 'portfolio', 'label' => 'Portfolio', 'match' => 'portfolio*'],
                        ['route' => 'pricing', 'label' => 'Pricing', 'match' => 'pricing'],
                        ['route' => 'blog', 'label' => 'Blog', 'match' => 'blog*'],
                        ['route' => 'contact', 'label' => 'Contact', 'match' => 'contact'],
                    ]; @endphp
                    @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['match']) ? 'nav-link-active' : 'nav-link' }} px-4 py-2 rounded-lg">
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <a href="{{ match(auth()->user()->role) { 'admin', 'manager' => route('admin.dashboard'), 'developer' => route('developer.dashboard'), default => route('client.dashboard') } }}" class="btn-primary btn-sm magnetic">
                            <i class="fas fa-arrow-right"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link px-4 py-2 rounded-lg">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm magnetic">Get Started <i class="fas fa-arrow-right"></i></a>
                    @endauth
                </div>

                {{-- Mobile Toggle --}}
                <button id="mobile-menu-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white/10 transition-all duration-300">
                    <div class="hamburger-icon">
                        <span></span><span></span><span></span>
                    </div>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden">
            <div class="bg-surface-900/95 backdrop-blur-2xl border-t border-white/6 shadow-2xl">
                <div class="max-w-7xl mx-auto px-4 py-6 space-y-1">
                    @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-white/60 font-medium hover:bg-white/6 hover:text-white transition-all duration-300 {{ request()->routeIs($link['match']) ? 'bg-primary-500/10 text-primary-400 font-semibold' : '' }}">
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                    <div class="pt-4 mt-4 border-t border-white/8 space-y-2">
                        @auth
                            <a href="{{ match(auth()->user()->role) { 'admin', 'manager' => route('admin.dashboard'), 'developer' => route('developer.dashboard'), default => route('client.dashboard') } }}" class="btn-primary w-full justify-center">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-ghost w-full justify-center text-white/60">Login</a>
                            <a href="{{ route('register') }}" class="btn-primary w-full justify-center">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="flex-1 page-transition">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-surface-950 text-white/40 relative overflow-hidden">
        {{-- Aurora blobs --}}
        <div class="aurora">
            <div class="aurora-blob w-150 h-100 bg-primary-600/8 top-[-10%] left-[-5%]"></div>
            <div class="aurora-blob w-125 h-87.5 bg-secondary-500/6 bottom-[-10%] right-[-5%]"></div>
            <div class="aurora-blob w-100 h-75 bg-accent-500/5 top-[30%] left-[40%]"></div>
        </div>

        {{-- Cyber grid overlay --}}
        <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>

        {{-- Top CTA Strip --}}
        <div class="relative border-b border-white/6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold text-white mb-2">Ready to Build Something Amazing?</h2>
                        <p class="text-white/50 max-w-lg">Let's turn your idea into a powerful digital product. Get a free consultation today.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 shrink-0">
                        <a href="{{ route('contact') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold text-center magnetic">
                            <i class="fas fa-rocket mr-2"></i> Start a Project
                        </a>
                        <a href="{{ route('project.estimator') }}" class="btn-outline px-8 py-4 rounded-xl font-semibold text-center magnetic">
                            <i class="fas fa-calculator mr-2"></i> Get Estimate
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Footer Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-12 relative">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">

                {{-- Brand Column --}}
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-3 mb-6">
                        @if(!empty($siteSettings['logo_url']))
                        <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10">
                        @else
                        <div class="w-11 h-11 bg-linear-to-br from-primary-500 via-secondary-500 to-accent-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 animate-gradient">
                            <span class="text-white font-bold">&lt;/&gt;</span>
                        </div>
                        <span class="text-xl font-black text-white tracking-tight">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                        @endif
                    </div>
                    <p class="text-white/50 leading-relaxed mb-8 max-w-sm">{{ $siteSettings['footer_description'] ?? 'Building world-class websites, mobile apps, and enterprise software. Your vision, our code.' }}</p>

                    {{-- Social Links --}}
                    @php
                        $socials = [
                            ['key' => 'social_facebook', 'icon' => 'fab fa-facebook-f', 'color' => 'hover:bg-[#1877F2]'],
                            ['key' => 'social_twitter', 'icon' => 'fab fa-x-twitter', 'color' => 'hover:bg-[#000]'],
                            ['key' => 'social_instagram', 'icon' => 'fab fa-instagram', 'color' => 'hover:bg-[#E4405F]'],
                            ['key' => 'social_linkedin', 'icon' => 'fab fa-linkedin-in', 'color' => 'hover:bg-[#0A66C2]'],
                            ['key' => 'social_github', 'icon' => 'fab fa-github', 'color' => 'hover:bg-[#333]'],
                            ['key' => 'social_youtube', 'icon' => 'fab fa-youtube', 'color' => 'hover:bg-[#FF0000]'],
                            ['key' => 'social_tiktok', 'icon' => 'fab fa-tiktok', 'color' => 'hover:bg-[#000]'],
                            ['key' => 'social_discord', 'icon' => 'fab fa-discord', 'color' => 'hover:bg-[#5865F2]'],
                        ];
                    @endphp
                    <div class="flex flex-wrap gap-2.5">
                        @foreach($socials as $social)
                            @if(!empty($siteSettings[$social['key']]) && $siteSettings[$social['key']] !== '#')
                            <a href="{{ $siteSettings[$social['key']] }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl flex items-center justify-center text-white/50 border border-white/8 bg-white/3 {{ $social['color'] }} hover:text-white hover:border-transparent hover:shadow-lg hover:scale-110 transition-all duration-300">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Services Column --}}
                <div class="lg:col-span-2">
                    <h3 class="text-white font-bold text-sm uppercase tracking-[0.15em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span> Services
                    </h3>
                    <ul class="space-y-3">
                        @php $footerServices = \App\Models\Service::where('is_active', true)->orderBy('title')->limit(8)->get(); @endphp
                        @forelse($footerServices as $service)
                        <li>
                            <a href="{{ route('services.show', $service) }}" class="text-sm hover:text-primary-400 hover:translate-x-1.5 transition-all duration-300 inline-flex items-center gap-2 group">
                                <i class="fas fa-chevron-right text-[8px] text-primary-500/0 group-hover:text-primary-500 transition-all duration-300"></i>
                                {{ $service->title }}
                            </a>
                        </li>
                        @empty
                        @foreach(['Web Development', 'Mobile Apps', 'UI/UX Design', 'Desktop Software', 'API Development', 'Cloud & DevOps'] as $srv)
                        <li>
                            <a href="{{ route('services') }}" class="text-sm hover:text-primary-400 hover:translate-x-1.5 transition-all duration-300 inline-flex items-center gap-2 group">
                                <i class="fas fa-chevron-right text-[8px] text-primary-500/0 group-hover:text-primary-500 transition-all duration-300"></i>
                                {{ $srv }}
                            </a>
                        </li>
                        @endforeach
                        @endforelse
                    </ul>
                </div>

                {{-- Quick Links Column --}}
                <div class="lg:col-span-2">
                    <h3 class="text-white font-bold text-sm uppercase tracking-[0.15em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary-500"></span> Company
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $footerLinks = [
                                ['route' => 'about', 'label' => 'About Us'],
                                ['route' => 'portfolio', 'label' => 'Portfolio'],
                                ['route' => 'pricing', 'label' => 'Pricing'],
                                ['route' => 'blog', 'label' => 'Blog'],
                                ['route' => 'faq', 'label' => 'FAQ'],
                                ['route' => 'project.estimator', 'label' => 'Project Estimator'],
                                ['route' => 'contact', 'label' => 'Contact Us'],
                            ];
                        @endphp
                        @foreach($footerLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="text-sm hover:text-primary-400 hover:translate-x-1.5 transition-all duration-300 inline-flex items-center gap-2 group">
                                <i class="fas fa-chevron-right text-[8px] text-primary-500/0 group-hover:text-primary-500 transition-all duration-300"></i>
                                {{ $link['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Newsletter + Contact Column --}}
                <div class="lg:col-span-4">
                    {{-- Newsletter --}}
                    @if(($siteSettings['enable_newsletter'] ?? '1') === '1')
                    <h3 class="text-white font-bold text-sm uppercase tracking-[0.15em] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent-500"></span> Stay Updated
                    </h3>
                    <p class="text-sm text-white/50 mb-4">Get the latest insights, tutorials, and project updates delivered to your inbox.</p>
                    <form action="{{ route('newsletter.submit') }}" method="POST" class="mb-8">
                        @csrf
                        <div style="position:absolute;left:-9999px;"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                        <div class="flex gap-2">
                            <input type="email" name="email" placeholder="Enter your email" required class="flex-1 px-4 py-3 bg-white/4 border border-white/8 rounded-xl text-white text-sm placeholder-white/30 focus:ring-2 focus:ring-primary-500/30 focus:border-primary-500/50 focus:bg-white/6 outline-none transition-all duration-300">
                            <button type="submit" class="px-5 py-3 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-xl hover:shadow-lg hover:shadow-primary-500/30 hover:scale-105 transition-all duration-300 font-medium text-sm">
                                Subscribe
                            </button>
                        </div>
                        <p class="text-xs text-white/25 mt-2.5"><i class="fas fa-lock mr-1"></i> No spam. Unsubscribe anytime.</p>
                    </form>
                    @endif

                    {{-- Contact Info --}}
                    <h3 class="text-white font-bold text-sm uppercase tracking-[0.15em] mb-5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Get in Touch
                    </h3>
                    <div class="space-y-3.5">
                        @if(!empty($siteSettings['contact_email']))
                        <a href="mailto:{{ $siteSettings['contact_email'] }}" class="text-sm flex items-center gap-3 group hover:text-primary-400 transition-colors duration-300">
                            <span class="w-8 h-8 rounded-lg bg-white/4 border border-white/6 flex items-center justify-center group-hover:bg-primary-500/10 group-hover:border-primary-500/30 transition-all duration-300">
                                <i class="fas fa-envelope text-primary-500 text-xs"></i>
                            </span>
                            {{ $siteSettings['contact_email'] }}
                        </a>
                        @endif
                        @if(!empty($siteSettings['contact_phone']))
                        <a href="tel:{{ $siteSettings['contact_phone'] }}" class="text-sm flex items-center gap-3 group hover:text-primary-400 transition-colors duration-300">
                            <span class="w-8 h-8 rounded-lg bg-white/4 border border-white/6 flex items-center justify-center group-hover:bg-primary-500/10 group-hover:border-primary-500/30 transition-all duration-300">
                                <i class="fas fa-phone text-primary-500 text-xs"></i>
                            </span>
                            {{ $siteSettings['contact_phone'] }}
                        </a>
                        @endif
                        @if(!empty($siteSettings['contact_address']))
                        <p class="text-sm flex items-center gap-3 group">
                            <span class="w-8 h-8 rounded-lg bg-white/4 border border-white/6 flex items-center justify-center shrink-0">
                                <i class="fas fa-map-marker-alt text-primary-500 text-xs"></i>
                            </span>
                            {{ $siteSettings['contact_address'] }}
                        </p>
                        @endif
                        @if(!empty($siteSettings['business_hours']))
                        <p class="text-sm flex items-center gap-3 group">
                            <span class="w-8 h-8 rounded-lg bg-white/4 border border-white/6 flex items-center justify-center shrink-0">
                                <i class="fas fa-clock text-primary-500 text-xs"></i>
                            </span>
                            {{ $siteSettings['business_hours'] }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="border-t border-white/6 mt-16 pt-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                    {{-- Copyright --}}
                    <p class="text-sm text-white/30">&copy; {{ date('Y') }} {{ $siteSettings['copyright_text'] ?? ($siteSettings['site_name'] ?? 'ICodeDev') . '. All rights reserved.' }}</p>

                    {{-- Legal Links --}}
                    <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-white/30">
                        <a href="{{ route('privacy') }}" class="hover:text-white/60 transition-colors duration-300">Privacy Policy</a>
                        <span class="text-white/10 hidden sm:inline">|</span>
                        <a href="{{ route('terms') }}" class="hover:text-white/60 transition-colors duration-300">Terms of Service</a>
                        <span class="text-white/10 hidden sm:inline">|</span>
                        <a href="{{ route('cookies') }}" class="hover:text-white/60 transition-colors duration-300">Cookie Policy</a>
                        <span class="text-white/10 hidden sm:inline">|</span>
                        <a href="{{ route('sitemap') }}" class="hover:text-white/60 transition-colors duration-300">Sitemap</a>
                    </div>

                    {{-- Back to Top --}}
                    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" class="w-10 h-10 rounded-xl border border-white/8 bg-white/3 flex items-center justify-center text-white/40 hover:bg-primary-600 hover:text-white hover:border-primary-600 hover:shadow-lg hover:shadow-primary-500/25 hover:-translate-y-1 transition-all duration-300" title="Back to top">
                        <i class="fas fa-arrow-up text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Float --}}
    @if(($siteSettings['enable_whatsapp'] ?? '1') === '1' && !empty($siteSettings['whatsapp_number']))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-linear-to-br from-green-500 to-green-600 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-green-500/40 hover:scale-110 hover:shadow-2xl hover:shadow-green-500/50 transition-all duration-300 animate-pulse-glow group">
        <i class="fab fa-whatsapp text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
    </a>
    @endif

    {{-- Service Worker Registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>

    {!! $siteSettings['footer_scripts'] ?? '' !!}
    @if(App\Rules\Recaptcha::isEnabled())
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    @stack('scripts')
</body>
</html>
