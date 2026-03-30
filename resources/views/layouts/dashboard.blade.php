<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ $siteSettings['site_name'] ?? 'ICodeDev' }} Dashboard</title>
    <link rel="icon" href="{{ !empty($siteSettings['favicon_url']) ? asset($siteSettings['favicon_url']) : asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-surface-950 text-white">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div data-dismiss class="fixed top-6 right-6 z-100 bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 pl-5 pr-4 py-4 rounded-2xl shadow-xl shadow-emerald-500/10 backdrop-blur-xl flex items-center gap-3 max-w-sm animate-slide-in">
            <div class="w-8 h-8 bg-linear-to-br from-emerald-500/20 to-emerald-600/20 rounded-full flex items-center justify-center shrink-0 ring-1 ring-emerald-500/30"><i class="fas fa-check text-emerald-400 text-sm"></i></div>
            <span class="text-sm font-medium">{{ session('success') }}</span>
            <button data-close class="ml-auto text-emerald-500/60 hover:text-emerald-400 p-1 transition-colors"><i class="fas fa-times text-xs"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div data-dismiss class="fixed top-6 right-6 z-100 bg-red-500/10 border border-red-500/30 text-red-300 pl-5 pr-4 py-4 rounded-2xl shadow-xl shadow-red-500/10 backdrop-blur-xl flex items-center gap-3 max-w-sm animate-slide-in">
            <div class="w-8 h-8 bg-linear-to-br from-red-500/20 to-red-600/20 rounded-full flex items-center justify-center shrink-0 ring-1 ring-red-500/30"><i class="fas fa-exclamation text-red-400 text-sm"></i></div>
            <span class="text-sm font-medium">{{ session('error') }}</span>
            <button data-close class="ml-auto text-red-500/60 hover:text-red-400 p-1 transition-colors"><i class="fas fa-times text-xs"></i></button>
        </div>
    @endif

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-67.5 bg-surface-900/95 backdrop-blur-xl border-r border-white/6 transform -translate-x-full lg:translate-x-0 transition-transform duration-500 flex flex-col overflow-hidden">
            {{-- Sidebar Background Effects --}}
            <div class="absolute inset-0 opacity-30 pointer-events-none">
                <div class="absolute top-0 left-0 w-full h-40 bg-linear-to-b from-primary-500/10 to-transparent"></div>
                <div class="absolute bottom-0 left-0 w-full h-40 bg-linear-to-t from-primary-500/5 to-transparent"></div>
            </div>

            {{-- Logo --}}
            <div class="relative h-18 flex items-center px-6 border-b border-white/6">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if(!empty($siteSettings['logo_url']))
                    <img src="{{ asset($siteSettings['logo_url']) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-9 group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-9 h-9 bg-linear-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 transition-all duration-500 group-hover:scale-110">
                        <span class="text-white font-bold text-sm">&lt;/&gt;</span>
                    </div>
                    <span class="text-lg font-black tracking-tight">{{ $siteSettings['site_name'] ?? 'iCodeDev' }}</span>
                    @endif
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="relative flex-1 py-5 px-3 space-y-0.5 overflow-y-auto scrollbar-thin">
                @yield('sidebar')
            </nav>

            {{-- User Info --}}
            <div class="relative p-4 border-t border-white/6">
                <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-white/5 transition-all duration-300 group">
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar_url }}" class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/10 group-hover:ring-primary-500/30 transition-all duration-300" alt="">
                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 rounded-full ring-2 ring-surface-900"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white/90 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/40 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-white/30 hover:text-red-400 hover:bg-red-500/10 transition-all duration-300" title="Logout">
                            <i class="fas fa-sign-out-alt text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-67.5 flex flex-col min-h-screen">
            {{-- Top Bar --}}
            <header class="h-18 bg-surface-900/80 backdrop-blur-xl border-b border-white/6 flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl text-white/60 hover:text-white hover:bg-white/6 transition-all duration-300">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-black text-white">@yield('page-title', 'Dashboard')</h1>
                        @hasSection('page-subtitle')
                        <p class="text-xs text-white/40 mt-0.5">@yield('page-subtitle')</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl text-white/40 hover:text-primary-400 hover:bg-primary-500/10 transition-all duration-300 hidden sm:flex" title="View Site">
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                    <div class="relative">
                        <button data-dropdown="notifications-dropdown" class="w-9 h-9 flex items-center justify-center rounded-xl text-white/40 hover:text-white hover:bg-white/6 transition-all duration-300 relative">
                            <i class="fas fa-bell text-sm"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="absolute top-0.5 right-0.5 w-4 h-4 bg-linear-to-r from-red-500 to-pink-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold ring-2 ring-surface-900 animate-pulse">{{ min(auth()->user()->unreadNotifications->count(), 9) }}</span>
                            @endif
                        </button>
                        <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface-800/95 backdrop-blur-xl rounded-2xl shadow-2xl shadow-black/30 border border-white/8 overflow-hidden">
                            <div class="px-5 py-3 border-b border-white/6 flex items-center justify-between">
                                <span class="font-semibold text-sm text-white">Notifications</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-primary-500/20 text-primary-400 ring-1 ring-primary-500/30">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                    <div class="px-5 py-3 border-b border-white/4 hover:bg-white/4 transition-colors duration-300 cursor-pointer">
                                        <p class="text-sm text-white/70 leading-relaxed">{{ $notification->data['message'] ?? 'New notification' }}</p>
                                        <p class="text-xs text-white/30 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <div class="px-5 py-10 text-center">
                                        <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-3 ring-1 ring-white/8">
                                            <i class="fas fa-bell-slash text-white/30"></i>
                                        </div>
                                        <p class="text-sm text-white/30">No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="w-px h-6 bg-white/8 mx-1 hidden sm:block"></div>
                    <div class="flex items-center gap-2 pl-1">
                        <div class="relative">
                            <img src="{{ auth()->user()->avatar_url }}" class="w-9 h-9 rounded-xl object-cover ring-2 ring-white/10" alt="">
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 rounded-full ring-2 ring-surface-900"></div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Sidebar Overlay --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-surface-950/60 backdrop-blur-sm z-30 lg:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full');this.classList.add('hidden')"></div>

    {{-- Real-time Badge Polling --}}
    @auth
    <script>
    (function() {
        let interval = 30000;
        function updateBadges() {
            fetch('{{ route("badges.counts") }}', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.ok ? r.json() : null)
            .then(badges => {
                if (!badges) return;
                document.querySelectorAll('[data-badge]').forEach(el => {
                    const key = el.dataset.badge;
                    const count = badges[key] ?? 0;
                    el.textContent = count;
                    el.style.display = count > 0 ? '' : 'none';
                });
            })
            .catch(() => {});
        }
        setInterval(updateBadges, interval);
    })();
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
