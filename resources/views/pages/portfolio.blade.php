@extends('layouts.app')
@section('title', 'Portfolio - ICodeDev')

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
            <span class="text-white">Portfolio</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
                <i class="fas fa-rocket text-primary-400 text-xs"></i> Our Work
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1.1] tracking-tight mb-6">
                Our <span class="text-shimmer">Portfolio</span>
            </h1>
            <p class="text-lg sm:text-xl text-gray-400 max-w-2xl leading-relaxed">Explore our completed projects and see the quality of work we deliver.</p>
        </div>
    </div>
</section>

{{-- Portfolio Grid --}}
<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        {{-- Filters --}}
        <div class="flex flex-wrap justify-center gap-2 mb-16 animate-on-scroll">
            <button data-filter="all" class="magnetic px-5 py-2.5 rounded-full font-medium text-sm bg-linear-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/25 transition-all duration-300">All Projects</button>
            @foreach($categories as $cat)
            <button data-filter="{{ $cat }}" class="magnetic px-5 py-2.5 rounded-full font-medium text-sm bg-white/5 text-white/50 border border-white/10 hover:border-primary-500/30 hover:text-primary-400 hover:bg-primary-500/10 shadow-sm transition-all duration-300">{{ $cat }}</button>
            @endforeach
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($portfolios as $portfolio)
            <a href="{{ route('portfolio.show', $portfolio) }}" data-category="{{ $portfolio->category }}" class="group card-hover animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/3">
                    <img src="{{ $portfolio->thumbnail_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-linear-to-t from-surface-950/80 via-surface-950/0 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6">
                        <span class="text-white text-sm font-medium flex items-center gap-2"><i class="fas fa-external-link-alt"></i> View Project</span>
                    </div>
                    <span class="absolute top-4 left-4 px-3.5 py-1.5 glass-dark rounded-lg text-xs font-bold text-white/90 shadow-lg">{{ $portfolio->category }}</span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary-400 transition-colors duration-300">{{ $portfolio->title }}</h3>
                    <p class="text-white/50 text-sm leading-relaxed mb-4">{{ Str::limit($portfolio->short_description, 80) }}</p>
                    @if($portfolio->technologies)
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                        <span class="px-2 py-0.5 bg-white/5 text-white/50 rounded text-xs font-medium">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-span-full py-24 animate-on-scroll">
                <div class="max-w-md mx-auto text-center">
                    <div class="w-20 h-20 bg-linear-to-br from-primary-500/10 to-secondary-500/10 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-folder-open text-3xl text-white/20"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Projects Coming Soon</h3>
                    <p class="text-white/50 leading-relaxed mb-8">We're working on some exciting projects. Stay tuned for updates!</p>
                    <a href="{{ route('contact') }}" class="btn-primary magnetic">Start a Project</a>
                </div>
            </div>
            @endforelse
        </div>

        @if($portfolios->hasPages())
        <div class="mt-16 flex justify-center">{{ $portfolios->links() }}</div>
        @endif
    </div>
</section>
@endsection
