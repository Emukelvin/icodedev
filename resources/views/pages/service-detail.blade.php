@extends('layouts.app')
@section('title', $service->meta_title ?? $service->title . ' - ICodeDev')
@section('meta_description', $service->meta_description ?? $service->short_description)

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
            <a href="{{ route('services') }}" class="hover:text-white transition-colors">Services</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
            <span class="text-white">{{ $service->title }}</span>
        </nav>
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center animate-on-scroll">
            <div>
                <div class="w-16 h-16 glass-neon rounded-2xl flex items-center justify-center mb-6 text-3xl">
                    <i class="fas fa-{{ $service->icon ?? 'code' }}"></i>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] tracking-tight mb-6">{{ $service->title }}</h1>
                <p class="text-lg sm:text-xl text-gray-400 leading-relaxed">{{ $service->short_description }}</p>
            </div>
            @if($service->image)
            <div class="tilt-card relative">
                <div class="absolute -inset-6 bg-linear-to-r from-primary-500/20 via-secondary-500/15 to-accent-500/20 rounded-4xl blur-3xl opacity-60 animate-gradient"></div>
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="relative rounded-2xl shadow-2xl w-full">
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16">
            <div class="lg:col-span-2 animate-on-scroll">
                <div class="prose prose-lg prose-invert max-w-none prose-headings:font-black prose-headings:tracking-tight prose-p:text-white/60 prose-p:leading-relaxed">{!! nl2br(e($service->description)) !!}</div>

                @if($service->features)
                <div class="mt-16">
                    <h3 class="text-2xl font-black text-white tracking-tight mb-8">Key Features</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach($service->features as $feature)
                        <div class="group flex items-center gap-3 p-4 bg-emerald-500/10 rounded-2xl border border-emerald-500/10 hover:shadow-lg hover:shadow-emerald-500/5 transition-all duration-300">
                            <div class="w-8 h-8 bg-emerald-500/20 text-emerald-400 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <span class="text-white/70">{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div>
                <div class="card-glass p-8 sticky top-24 rounded-2xl animate-on-scroll">
                    <h3 class="text-lg font-bold text-white mb-5">Technologies</h3>
                    @if($service->technologies)
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($service->technologies as $tech)
                        <span class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium border border-white/5">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                    <div class="h-px bg-white/5 mb-8"></div>
                    <div class="space-y-3">
                        <a href="{{ route('contact') }}" class="magnetic group flex items-center justify-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-6 py-4 rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 transition-all duration-500 w-full">
                            <i class="fas fa-paper-plane"></i> Request This Service
                        </a>
                        <a href="https://wa.me/2347038024207" target="_blank" rel="noopener noreferrer" class="magnetic flex items-center justify-center gap-2.5 bg-linear-to-r from-emerald-600 to-emerald-500 text-white font-semibold px-6 py-4 rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-xl transition-all duration-500 w-full">
                            <i class="fab fa-whatsapp text-lg"></i> Chat With Us
                        </a>
                    </div>
                    <div class="h-px bg-white/5 my-8"></div>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center gap-3 text-white/50"><i class="fas fa-clock text-primary-500"></i><span>Fast turnaround times</span></div>
                        <div class="flex items-center gap-3 text-white/50"><i class="fas fa-shield-alt text-primary-500"></i><span>Quality guaranteed</span></div>
                        <div class="flex items-center gap-3 text-white/50"><i class="fas fa-headset text-primary-500"></i><span>Dedicated support</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($packages->count() > 0)
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora"><div class="aurora-blob w-100 h-100 bg-primary-500/5 top-[-10%] right-[-5%]"></div></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-tag text-xs"></i> Pricing</span>
            <h2 class="section-title mt-5">Pricing for <span class="gradient-text">{{ $service->title }}</span></h2>
            <p class="section-subtitle">Choose the perfect plan for your project.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
            @foreach($packages as $package)
            <div class="relative {{ $package->is_popular ? 'card-glow border-2 border-primary-500/50 shadow-xl shadow-primary-500/10 scale-[1.03] z-10' : 'card-hover' }} p-8 text-center rounded-2xl animate-on-scroll group">
                @if($package->is_popular)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span class="inline-flex items-center gap-1.5 px-5 py-2 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-full text-xs font-bold shadow-xl shadow-primary-500/30"><i class="fas fa-fire text-amber-300"></i> Popular</span>
                </div>
                @endif
                <h3 class="text-xl font-bold text-white mb-2 mt-2">{{ $package->name }}</h3>
                <div class="mb-6"><span class="text-4xl font-black text-white tracking-tight {{ $package->is_popular ? 'gradient-text' : '' }}">{{ $cs }}{{ number_format($package->price) }}</span></div>
                @if($package->features)
                <ul class="text-left space-y-3 mb-8">
                    @foreach($package->features as $f)
                    <li class="flex items-start gap-3 text-white/60 text-sm"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>{{ $f }}</li>
                    @endforeach
                </ul>
                @endif
                <a href="{{ route('contact') }}" class="{{ $package->is_popular ? 'btn-primary' : 'btn-secondary' }} w-full magnetic">Choose Plan</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
