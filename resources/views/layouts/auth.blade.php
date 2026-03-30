<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') - {{ $siteSettings['site_name'] ?? 'ICodeDev' }}</title>
    <meta name="description" content="@yield('meta_description', 'Secure authentication for ' . ($siteSettings['site_name'] ?? 'ICodeDev'))">
    <link rel="icon" href="{{ !empty($siteSettings['favicon_url']) ? asset($siteSettings['favicon_url']) : asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-surface-950 min-h-screen text-white antialiased">
    {{-- Animated Background --}}
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-surface-950"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(99,102,241,0.12)_0%,transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(6,182,212,0.08)_0%,transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(139,92,246,0.05)_0%,transparent_40%)]"></div>
        <div class="aurora">
            <div class="aurora-blob w-[500px] h-[400px] bg-primary-600/10 top-[-15%] right-[-10%]" style="animation-duration:18s"></div>
            <div class="aurora-blob w-[400px] h-[350px] bg-secondary-500/8 bottom-[-15%] left-[-8%]" style="animation-duration:22s"></div>
            <div class="aurora-blob w-[300px] h-[250px] bg-accent-500/6 top-[35%] left-[25%]" style="animation-duration:25s"></div>
        </div>
        <div class="absolute inset-0 cyber-grid opacity-[0.08] pointer-events-none"></div>
        {{-- Floating particles --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-1 h-1 bg-primary-500/30 rounded-full top-[20%] left-[15%] animate-float" style="animation-duration:6s"></div>
            <div class="absolute w-1.5 h-1.5 bg-secondary-500/20 rounded-full top-[60%] left-[75%] animate-float" style="animation-duration:8s;animation-delay:2s"></div>
            <div class="absolute w-1 h-1 bg-accent-500/25 rounded-full top-[40%] left-[55%] animate-float" style="animation-duration:7s;animation-delay:4s"></div>
            <div class="absolute w-0.5 h-0.5 bg-primary-400/30 rounded-full top-[80%] left-[25%] animate-float" style="animation-duration:9s;animation-delay:1s"></div>
            <div class="absolute w-1 h-1 bg-secondary-400/20 rounded-full top-[10%] left-[85%] animate-float" style="animation-duration:7s;animation-delay:3s"></div>
        </div>
    </div>

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

    {{-- Content --}}
    <div class="relative z-10 min-h-screen">
        @yield('content')
    </div>

    {{-- Shared Scripts --}}
    <script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye', 'fa-eye-slash'); }
        else { input.type = 'password'; icon.classList.replace('fa-eye-slash', 'fa-eye'); }
    }
    function initStrengthBar(inputId, barId) {
        const pw = document.getElementById(inputId);
        if (!pw) return;
        pw.addEventListener('input', function() {
            const bars = document.querySelectorAll('#' + barId + ' > div');
            let s = 0;
            if (this.value.length >= 8) s++;
            if (/[A-Z]/.test(this.value)) s++;
            if (/[0-9]/.test(this.value)) s++;
            if (/[^A-Za-z0-9]/.test(this.value)) s++;
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-amber-400', 'bg-emerald-500'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];
            bars.forEach((b, i) => { b.className = 'h-1 flex-1 rounded-full transition-all duration-500 ' + (i < s ? colors[s - 1] : 'bg-white/8'); });
            const labelEl = document.getElementById(barId + '-label');
            if (labelEl) {
                labelEl.textContent = s > 0 ? labels[s - 1] : '';
                labelEl.className = 'text-xs font-medium transition-colors duration-300 ' + (s > 0 ? colors[s - 1].replace('bg-', 'text-') : 'text-white/20');
            }
        });
    }
    </script>
    @if(App\Rules\Recaptcha::isEnabled())
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    @stack('scripts')
</body>
</html>
