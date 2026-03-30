@extends('layouts.app')
@section('title', $teamMember->name . ' - ' . $teamMember->position)

@section('content')
{{-- Hero / Profile Header --}}
<section class="relative pt-36 pb-20 lg:pt-44 lg:pb-28 bg-surface-950 text-white overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-150 h-150 bg-primary-600/20 top-[-15%] left-[-8%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-10%] right-[-5%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        {{-- Breadcrumb --}}
        <nav class="mb-10 animate-on-scroll">
            <ol class="flex items-center gap-2 text-sm text-white/50">
                <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a></li>
                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">About</a></li>
                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                <li class="text-primary-400">{{ $teamMember->name }}</li>
            </ol>
        </nav>

        <div class="grid md:grid-cols-3 gap-10 lg:gap-16 items-start">
            {{-- Avatar --}}
            <div class="animate-on-scroll">
                <div class="relative overflow-hidden rounded-3xl aspect-4/5 shadow-2xl shadow-primary-500/10 border border-white/5">
                    @if($teamMember->avatar)
                    <img src="{{ asset('storage/' . $teamMember->avatar) }}" alt="{{ $teamMember->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-linear-to-br from-primary-500/20 to-secondary-500/20 flex items-center justify-center">
                        <span class="text-8xl font-black text-white/20">{{ substr($teamMember->name, 0, 1) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="md:col-span-2 animate-on-scroll" data-delay="100">
                <span class="section-label mb-4"><i class="fas fa-user text-xs"></i> Team Member</span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mt-4 mb-3">{{ $teamMember->name }}</h1>
                <p class="text-primary-400 text-lg font-semibold mb-8">{{ $teamMember->position }}</p>

                @if($teamMember->bio)
                <div class="prose prose-invert prose-sm max-w-none mb-8">
                    <p class="text-white/70 text-base leading-relaxed whitespace-pre-line">{{ $teamMember->bio }}</p>
                </div>
                @endif

                {{-- Contact & Socials --}}
                <div class="flex flex-wrap items-center gap-4">
                    @if($teamMember->email)
                    <a href="mailto:{{ $teamMember->email }}" class="inline-flex items-center gap-2.5 px-5 py-3 glass-neon rounded-xl text-sm font-medium text-white hover:text-primary-400 transition-colors">
                        <i class="fas fa-envelope text-primary-400"></i> {{ $teamMember->email }}
                    </a>
                    @endif

                    @if($teamMember->social_links)
                        @foreach($teamMember->social_links as $platform => $url)
                            @if(!empty($url))
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-11 h-11 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/70 hover:bg-primary-500 hover:text-white hover:border-primary-500 hover:scale-110 transition-all duration-300" title="{{ ucfirst($platform) }}">
                                <i class="fab fa-{{ $platform }} text-lg"></i>
                            </a>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Other Team Members --}}
@if($otherMembers->isNotEmpty())
<section class="py-20 lg:py-28 bg-surface-900/30 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 animate-on-scroll">
            <h2 class="text-2xl sm:text-3xl font-black text-white">Meet Other <span class="gradient-text">Team Members</span></h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @foreach($otherMembers as $member)
            <a href="{{ route('team.show', $member) }}" class="group card-hover overflow-hidden animate-on-scroll block">
                <div class="relative overflow-hidden aspect-4/5 bg-white/5">
                    @if($member->avatar)
                    <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-primary-500/10 to-secondary-500/10">
                        <span class="text-5xl font-black text-white/20">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-bold text-white group-hover:text-primary-400 transition-colors">{{ $member->name }}</h3>
                    <p class="text-primary-400/70 text-sm font-medium mt-1">{{ $member->position }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 lg:py-28 bg-surface-950 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-100 h-100 bg-primary-600/15 top-[-10%] left-[20%]"></div>
    </div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative animate-on-scroll">
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Want to Work With Us?</h2>
        <p class="text-white/50 mb-8">Get in touch and let's discuss how we can bring your ideas to life.</p>
        <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-white text-surface-900 font-bold px-8 py-4 rounded-2xl hover:bg-gray-100 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.03]">
            Contact Us <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1.5"></i>
        </a>
    </div>
</section>
@endsection
