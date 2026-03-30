@extends('layouts.app')
@section('title', $portfolio->meta_title ?? $portfolio->title . ' - ICodeDev Portfolio')

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
            <a href="{{ route('portfolio') }}" class="hover:text-white transition-colors">Portfolio</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
            <span class="text-white">{{ $portfolio->title }}</span>
        </nav>
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center animate-on-scroll">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-2 glass-neon rounded-full text-sm font-medium mb-6">
                    {{ $portfolio->category }}
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] tracking-tight mb-6">{{ $portfolio->title }}</h1>
                <p class="text-lg text-gray-400 leading-relaxed">{{ $portfolio->short_description }}</p>
            </div>
            <div class="flex items-center justify-start lg:justify-end gap-4 flex-wrap">
                @if($portfolio->live_url)
                <a href="{{ $portfolio->live_url }}" target="_blank" rel="noopener noreferrer" class="magnetic group inline-flex items-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-6 py-3.5 rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 hover:scale-[1.02] transition-all duration-500">
                    <i class="fas fa-external-link-alt"></i> Live Demo
                </a>
                @endif
                @if($portfolio->completion_date)
                <div class="inline-flex items-center gap-2 px-5 py-3.5 glass-neon rounded-xl text-gray-300 text-sm">
                    <i class="fas fa-calendar"></i> {{ $portfolio->completion_date->format('M Y') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16">
            <div class="lg:col-span-2">
                @if($portfolio->thumbnail)
                <div class="mb-12 animate-on-scroll">
                    <div class="tilt-card relative">
                        <div class="absolute -inset-6 bg-linear-to-r from-primary-500/15 via-secondary-500/10 to-accent-500/15 rounded-4xl blur-3xl opacity-60 animate-gradient"></div>
                        <img src="{{ $portfolio->thumbnail_url }}" alt="{{ $portfolio->title }}" class="relative w-full rounded-2xl shadow-2xl">
                    </div>
                </div>
                @endif
                <div class="prose prose-lg prose-invert max-w-none prose-headings:font-black prose-headings:tracking-tight prose-p:text-white/60 prose-p:leading-relaxed animate-on-scroll">{!! nl2br(e($portfolio->description)) !!}</div>
                @if($portfolio->images)
                <div class="mt-16 animate-on-scroll">
                    <h3 class="text-2xl font-black text-white tracking-tight mb-8">Screenshots</h3>
                    <div class="grid sm:grid-cols-2 gap-5">
                        @foreach($portfolio->images as $image)
                        <div class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-500">
                            <img src="{{ asset('storage/' . $image) }}" alt="Screenshot" class="w-full h-auto group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-surface-950/0 group-hover:bg-surface-950/20 transition-colors duration-500 flex items-center justify-center">
                                <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 scale-75 group-hover:scale-100 transition-all duration-500 shadow-lg">
                                    <i class="fas fa-expand text-gray-700"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div>
                <div class="card-glass p-8 sticky top-24 rounded-2xl space-y-0 animate-on-scroll">
                    @if($portfolio->client_name)
                    <div class="pb-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Client</span>
                        <p class="font-bold text-white mt-1.5 text-lg">{{ $portfolio->client_name }}</p>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    @endif
                    @if($portfolio->technologies)
                    <div class="py-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Technologies</span>
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach($portfolio->technologies as $t)
                            <span class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium border border-white/5">{{ $t }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    @endif
                    @if($portfolio->client_rating)
                    <div class="py-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rating</span>
                        <div class="flex items-center gap-1 text-amber-400 mt-2">
                            @for($i = 0; $i < $portfolio->client_rating; $i++)<i class="fas fa-star"></i>@endfor
                        </div>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    @endif
                    @if($portfolio->client_feedback)
                    <div class="py-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Client Feedback</span>
                        <div class="mt-3 relative">
                            <i class="fas fa-quote-left text-primary-500/20 text-2xl absolute -top-1 -left-1"></i>
                            <p class="text-white/60 italic text-sm leading-relaxed pl-6">{{ $portfolio->client_feedback }}</p>
                        </div>
                    </div>
                    <div class="h-px bg-white/5"></div>
                    @endif
                    <div class="pt-6">
                        <a href="{{ route('contact') }}" class="magnetic group flex items-center justify-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-6 py-4 rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:shadow-primary-500/35 transition-all duration-500 w-full">
                            <i class="fas fa-paper-plane"></i> Start Similar Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora"><div class="aurora-blob w-100 h-100 bg-primary-500/5 bottom-[-10%] left-[-5%]"></div></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-12 gap-6 animate-on-scroll">
            <div>
                <span class="section-label mb-5"><i class="fas fa-layer-group text-xs"></i> More Work</span>
                <h2 class="section-title mt-5">Related <span class="gradient-text">Projects</span></h2>
            </div>
            <a href="{{ route('portfolio') }}" class="inline-flex items-center gap-2 text-primary-400 font-semibold hover:text-primary-500 hover:gap-3 transition-all duration-300 text-sm">
                View All Projects <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($related as $item)
            <a href="{{ route('portfolio.show', $item) }}" class="group card-hover animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/3">
                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-linear-to-t from-surface-950/80 via-surface-950/0 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6">
                        <span class="text-white text-sm font-medium flex items-center gap-2"><i class="fas fa-external-link-alt"></i> View Project</span>
                    </div>
                    @if($item->category)
                    <span class="absolute top-4 left-4 px-3.5 py-1.5 glass-dark rounded-lg text-xs font-bold text-white/90 shadow-lg">{{ $item->category }}</span>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary-400 transition-colors duration-300">{{ $item->title }}</h3>
                    @if($item->short_description)
                    <p class="text-white/50 text-sm leading-relaxed">{{ Str::limit($item->short_description, 80) }}</p>
                    @endif
                    @if($item->technologies)
                    <div class="flex flex-wrap gap-1.5 mt-4">
                        @foreach(array_slice($item->technologies, 0, 3) as $tech)
                        <span class="px-2 py-0.5 bg-white/5 text-white/50 rounded text-xs font-medium">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
