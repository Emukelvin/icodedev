@extends('layouts.app')
@section('title', 'About Us - ICodeDev')

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
            <span class="text-white">About Us</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
                <i class="fas fa-users text-primary-400 text-xs"></i> Who We Are
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] tracking-tight mb-6">
                About <span class="text-shimmer">ICodeDev</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl leading-relaxed">We're a passionate team of developers, designers, and innovators building world-class software solutions.</p>
        </div>
    </div>
</section>

{{-- Story --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-center">
            <div class="animate-on-scroll">
                <span class="section-label mb-5"><i class="fas fa-book-open text-xs"></i> Our Story</span>
                <h2 class="section-title mt-5">Turning Ideas Into <span class="gradient-text">Digital Reality</span></h2>
                <div class="mt-8 space-y-5">
                    <p class="text-white/60 text-lg leading-relaxed">ICodeDev was born from a vision to make world-class software development accessible to businesses of all sizes. We believe every great idea deserves a brilliant digital solution.</p>
                    <p class="text-white/60 text-lg leading-relaxed">Our team brings together years of experience in web development, mobile applications, desktop software, and UI/UX design. We use cutting-edge technologies like Laravel, React, Flutter, and more to deliver solutions that exceed expectations.</p>
                    <p class="text-white/60 text-lg leading-relaxed">From startups to enterprises, we partner with our clients to understand their unique needs and deliver software that drives real business results.</p>
                </div>
                <div class="mt-10 flex items-center gap-4">
                    <div class="w-14 h-1.5 bg-linear-to-r from-primary-600 to-secondary-500 rounded-full"></div>
                    <div class="w-7 h-1.5 bg-primary-500/50 rounded-full"></div>
                    <div class="w-3 h-1.5 bg-primary-500/20 rounded-full"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 animate-on-scroll" data-animate="right">
                @foreach([
                    ['from' => 'from-primary-500 to-primary-700', 'shadow' => 'shadow-primary-500/20', 'text' => 'text-primary-100', 'counter' => $stats['projects'], 'label' => 'Projects Completed'],
                    ['from' => 'from-secondary-500 to-secondary-700', 'shadow' => 'shadow-secondary-500/20', 'text' => 'text-secondary-100', 'counter' => $stats['clients'], 'label' => 'Happy Clients'],
                    ['from' => 'from-emerald-500 to-emerald-700', 'shadow' => 'shadow-emerald-500/20', 'text' => 'text-emerald-100', 'counter' => $stats['team'], 'label' => 'Team Members'],
                    ['from' => 'from-amber-500 to-amber-700', 'shadow' => 'shadow-amber-500/20', 'text' => 'text-amber-100', 'counter' => $stats['years'], 'label' => 'Years Experience'],
                ] as $stat)
                <div class="tilt-card stat-card text-center relative overflow-hidden rounded-2xl bg-linear-to-br {{ $stat['from'] }} text-white p-5 sm:p-8 shadow-lg {{ $stat['shadow'] }} group hover:shadow-2xl transition-shadow duration-500">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="text-4xl sm:text-5xl font-black tracking-tight relative" data-counter="{{ $stat['counter'] }}">0</div>
                    <div class="{{ $stat['text'] }} text-sm mt-2 font-medium relative">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora"><div class="aurora-blob w-100 h-100 bg-secondary-500/5 bottom-[-10%] right-[-5%]"></div></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-diamond text-xs"></i> What We Stand For</span>
            <h2 class="section-title mt-5">Our Core <span class="gradient-text">Values</span></h2>
            <p class="section-subtitle">The principles that guide everything we build.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @foreach([
                ['icon' => 'gem', 'title' => 'Quality First', 'desc' => 'We never compromise on code quality and deliver pixel-perfect solutions.', 'color' => 'from-primary-500 to-primary-600'],
                ['icon' => 'handshake', 'title' => 'Client Partnership', 'desc' => 'Your success is our success. We work as an extension of your team.', 'color' => 'from-secondary-500 to-secondary-600'],
                ['icon' => 'lightbulb', 'title' => 'Innovation', 'desc' => 'We embrace new technologies and creative approaches.', 'color' => 'from-neon-purple to-accent-500'],
                ['icon' => 'clock', 'title' => 'On-time Delivery', 'desc' => 'We respect deadlines and deliver consistently on schedule.', 'color' => 'from-neon-green to-emerald-600'],
            ] as $value)
            <div class="group tilt-card card-hover p-8 text-center animate-on-scroll">
                <div class="w-16 h-16 bg-linear-to-br from-primary-500/10 to-secondary-500/10 text-primary-400 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl group-hover:bg-linear-to-br group-hover:{{ $value['color'] }} group-hover:text-white group-hover:shadow-xl group-hover:shadow-primary-500/30 group-hover:scale-110 transition-all duration-500">
                    <i class="fas fa-{{ $value['icon'] }}"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-400 transition-colors duration-300">{{ $value['title'] }}</h3>
                <p class="text-white/50 text-sm leading-relaxed">{{ $value['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-users text-xs"></i> Our Team</span>
            <h2 class="section-title mt-5">Meet The <span class="gradient-text">Experts</span></h2>
            <p class="section-subtitle">The talented people behind every successful project.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @forelse($teamMembers as $member)
            <div class="group card-hover overflow-hidden animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/5 bg-white/5">
                    @if($member->avatar)
                    <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-primary-500/10 to-secondary-500/10">
                        <span class="text-5xl font-black text-white/20">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                    @if($member->social_links)
                    <div class="absolute inset-0 bg-linear-to-t from-surface-950/80 via-surface-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-6">
                        <div class="flex items-center gap-3">
                            @foreach($member->social_links as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-surface-900 transition-all duration-300 border border-white/10 hover:scale-110">
                                <i class="fab fa-{{ $platform }}"></i>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-bold text-white">{{ $member->name }}</h3>
                    <p class="text-primary-400 text-sm font-medium mt-1">{{ $member->position }}</p>
                    @if($member->bio)
                    <p class="text-white/50 text-xs mt-2 leading-relaxed">{{ Str::limit($member->bio, 80) }}</p>
                    @endif
                </div>
            </div>
            @empty
            @foreach(['CEO & Founder', 'Lead Developer', 'UI/UX Designer', 'Project Manager'] as $role)
            <div class="group card-hover overflow-hidden animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/5 bg-linear-to-br from-primary-500/10 to-secondary-500/10 flex items-center justify-center">
                    <div class="text-5xl text-white/20 group-hover:scale-110 transition-transform duration-500"><i class="fas fa-user"></i></div>
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-bold text-white">Team Member</h3>
                    <p class="text-primary-400 text-sm font-medium mt-1">{{ $role }}</p>
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
            <i class="fas fa-briefcase text-amber-400"></i> Careers
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-6">Want to Join Our<br><span class="text-shimmer">Team?</span></h2>
        <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto">We're always looking for talented individuals to join our growing team. Let's build great things together.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-white text-surface-900 font-bold px-8 py-4 rounded-2xl hover:bg-gray-100 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.03]">
                Get In Touch
                <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1.5"></i>
            </a>
        </div>
    </div>
</section>
@endsection
