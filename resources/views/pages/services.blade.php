@extends('layouts.app')
@section('title', 'Our Services - ICodeDev')

@section('content')
{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/25 top-[-20%] left-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] right-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 relative">
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
            <span class="text-white">Services</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
                <i class="fas fa-cubes text-primary-400 text-xs"></i> What We Do
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] tracking-tight mb-6">
                Our <span class="text-shimmer">Services</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl leading-relaxed">Comprehensive software development solutions to help your business grow and succeed in the digital world.</p>
        </div>
    </div>
</section>

{{-- Services Listing --}}
<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="space-y-28 lg:space-y-36">
            @forelse($services as $index => $service)
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center animate-on-scroll">
                <div class="{{ $index % 2 ? 'lg:order-2' : '' }}">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-linear-to-br from-primary-600 to-secondary-500 text-white text-sm font-bold rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="h-px flex-1 bg-linear-to-r from-primary-500/30 to-transparent"></div>
                    </div>
                    <div class="w-14 h-14 bg-linear-to-br from-primary-500/10 to-secondary-500/10 text-primary-400 rounded-2xl flex items-center justify-center mb-5 text-2xl">
                        <i class="fas fa-{{ $service->icon ?? 'code' }}"></i>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight mb-4">{{ $service->title }}</h2>
                    <p class="text-white/50 text-lg leading-relaxed mb-6">{{ $service->short_description }}</p>
                    @if($service->features)
                    <ul class="space-y-3 mb-8">
                        @foreach(array_slice($service->features, 0, 6) as $feature)
                        <li class="flex items-center gap-3 text-white/60">
                            <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
                            <span>{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    @if($service->technologies)
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($service->technologies as $tech)
                        <span class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium border border-white/5">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('services.show', $service) }}" class="magnetic group inline-flex items-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 hover:scale-[1.02] transition-all duration-500">
                        Learn More
                        <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1.5"></i>
                    </a>
                </div>
                <div class="{{ $index % 2 ? 'lg:order-1' : '' }}">
                    @if($service->image)
                    <div class="tilt-card relative">
                        <div class="absolute -inset-6 bg-linear-to-r from-primary-500/15 via-secondary-500/10 to-accent-500/15 rounded-4xl blur-3xl opacity-60 animate-gradient"></div>
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="relative rounded-2xl shadow-2xl w-full">
                    </div>
                    @else
                    <div class="tilt-card relative">
                        <div class="absolute -inset-6 bg-linear-to-r from-primary-500/15 via-secondary-500/10 to-accent-500/15 rounded-4xl blur-3xl opacity-60"></div>
                        <div class="relative bg-linear-to-br from-primary-500/10 to-secondary-500/10 rounded-2xl h-80 lg:h-96 flex items-center justify-center border border-primary-500/10">
                            <i class="fas fa-{{ $service->icon ?? 'code' }} text-7xl text-white/20"></i>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            @foreach([
                ['icon' => 'globe', 'title' => 'Website Development', 'desc' => 'We build fast, secure, and scalable websites using Laravel, React, and modern web technologies. From corporate sites to e-commerce platforms.', 'techs' => ['Laravel', 'React', 'Vue.js', 'WordPress']],
                ['icon' => 'mobile-alt', 'title' => 'Mobile App Development', 'desc' => 'Cross-platform and native mobile applications for iOS and Android. Beautiful interfaces with powerful functionality.', 'techs' => ['Flutter', 'React Native', 'Swift', 'Kotlin']],
                ['icon' => 'desktop', 'title' => 'Desktop Software Development', 'desc' => 'Custom desktop applications for Windows, macOS, and Linux. Enterprise-grade software built for performance.', 'techs' => ['Electron', 'C#', '.NET', 'Java']],
                ['icon' => 'paint-brush', 'title' => 'UI/UX Design', 'desc' => 'User-centered design that looks beautiful and works intuitively. From wireframes to polished interfaces.', 'techs' => ['Figma', 'Adobe XD', 'Sketch']],
                ['icon' => 'plug', 'title' => 'API Development', 'desc' => 'Robust RESTful and GraphQL APIs that power your applications and integrations.', 'techs' => ['REST', 'GraphQL', 'Laravel', 'Node.js']],
                ['icon' => 'tools', 'title' => 'Maintenance & Support', 'desc' => 'Ongoing maintenance, updates, and support to keep your software running smoothly.', 'techs' => ['Monitoring', 'Updates', 'Security']],
            ] as $index => $s)
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center animate-on-scroll">
                <div class="{{ $index % 2 ? 'lg:order-2' : '' }}">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-linear-to-br from-primary-600 to-secondary-500 text-white text-sm font-bold rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="h-px flex-1 bg-linear-to-r from-primary-500/30 to-transparent"></div>
                    </div>
                    <div class="w-14 h-14 bg-linear-to-br from-primary-500/10 to-secondary-500/10 text-primary-400 rounded-2xl flex items-center justify-center mb-5 text-2xl">
                        <i class="fas fa-{{ $s['icon'] }}"></i>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight mb-4">{{ $s['title'] }}</h2>
                    <p class="text-white/50 text-lg leading-relaxed mb-6">{{ $s['desc'] }}</p>
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($s['techs'] as $tech)
                        <span class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium border border-white/5">{{ $tech }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 hover:scale-[1.02] transition-all duration-500">
                        Request This Service
                        <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1.5"></i>
                    </a>
                </div>
                <div class="{{ $index % 2 ? 'lg:order-1' : '' }}">
                    <div class="tilt-card relative">
                        <div class="absolute -inset-6 bg-linear-to-r from-primary-500/15 via-secondary-500/10 to-accent-500/15 rounded-4xl blur-3xl opacity-60"></div>
                        <div class="relative bg-linear-to-br from-primary-500/10 to-secondary-500/10 rounded-2xl h-80 lg:h-96 flex items-center justify-center border border-primary-500/10">
                            <i class="fas fa-{{ $s['icon'] }} text-7xl text-white/20"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="relative py-28 lg:py-36 bg-surface-950 text-white overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-10%] left-[15%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-10%] right-[15%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative animate-on-scroll">
        <span class="inline-flex items-center gap-2 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
            <i class="fas fa-sparkles text-amber-400"></i> Custom Solutions
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-6">Need a Custom<br><span class="text-shimmer">Solution?</span></h2>
        <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto">Tell us about your project and we'll provide a detailed quote within 24 hours.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-white text-surface-900 font-bold px-8 py-4 rounded-2xl hover:bg-gray-100 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.03]">
                <i class="fas fa-paper-plane"></i> Get Custom Quote
                <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1.5"></i>
            </a>
            <a href="https://wa.me/2347038024207" target="_blank" rel="noopener noreferrer" class="magnetic inline-flex items-center gap-2.5 bg-linear-to-r from-emerald-600 to-emerald-500 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-emerald-500/30 hover:shadow-2xl hover:shadow-emerald-500/40 transition-all duration-500 hover:scale-[1.03]">
                <i class="fab fa-whatsapp text-lg"></i> Chat on WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
