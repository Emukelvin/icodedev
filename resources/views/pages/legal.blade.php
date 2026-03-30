@extends('layouts.app')
@section('title', ($page->meta_title ?? $page->title) . ' - ' . ($siteSettings['site_name'] ?? 'ICodeDev'))
@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif
@section('content')

{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden pt-32 pb-20">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] left-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="flex items-center gap-2 text-sm text-white/40 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-white/20 text-xs"></i>
            <span class="text-white/70">{{ $page->title }}</span>
        </nav>
        @php
            $words = explode(' ', $page->title);
            $lastWord = array_pop($words);
            $firstWords = implode(' ', $words);
        @endphp
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">
            {{ $firstWords }} <span class="gradient-text">{{ $lastWord }}</span>
        </h1>
        <p class="text-lg text-white/50">
            <i class="fas fa-calendar-alt mr-2"></i>Last updated: {{ $page->updated_at->format('F d, Y') }}
        </p>
    </div>
</section>

{{-- Content --}}
<section class="py-20 lg:py-28">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- Sidebar / Table of Contents --}}
            <aside class="lg:w-64 shrink-0 animate-on-scroll" x-data="{ open: false }">
                <div class="lg:sticky lg:top-28">
                    {{-- Mobile toggle --}}
                    <button @click="open = !open" class="lg:hidden w-full flex items-center justify-between card-hover p-4 mb-4">
                        <span class="text-sm font-semibold text-white"><i class="fas fa-list mr-2 text-primary-400"></i>Table of Contents</span>
                        <i class="fas fa-chevron-down text-white/40 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <nav class="card-hover p-6 space-y-1" :class="{ 'hidden lg:block': !open }">
                        <h3 class="text-xs font-bold text-white/30 uppercase tracking-wider mb-4">On this page</h3>
                        <div id="toc-links" class="space-y-1"></div>
                    </nav>

                    {{-- Related Pages --}}
                    <div class="card-hover p-6 mt-6 hidden lg:block">
                        <h3 class="text-xs font-bold text-white/30 uppercase tracking-wider mb-4">Legal Pages</h3>
                        <div class="space-y-2">
                            <a href="{{ route('privacy') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ $page->slug === 'privacy-policy' ? 'bg-primary-500/10 text-primary-400' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                                <i class="fas fa-shield-alt w-4 text-center"></i> Privacy Policy
                            </a>
                            <a href="{{ route('terms') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ $page->slug === 'terms-of-service' ? 'bg-primary-500/10 text-primary-400' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                                <i class="fas fa-file-contract w-4 text-center"></i> Terms of Service
                            </a>
                            <a href="{{ route('cookies') }}"
                               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all {{ $page->slug === 'cookies-policy' ? 'bg-primary-500/10 text-primary-400' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                                <i class="fas fa-cookie-bite w-4 text-center"></i> Cookies Policy
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <div class="flex-1 min-w-0">
                <div class="legal-content prose prose-invert prose-p:text-white/60 prose-headings:text-white prose-strong:text-white prose-li:text-white/60 prose-a:text-primary-400 max-w-none">
                    {!! $page->content !!}
                </div>

                {{-- Contact Footer --}}
                <div class="card-hover p-8 lg:p-10 mt-12 animate-on-scroll">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3 mb-4">
                        <i class="fas fa-envelope text-primary-400"></i> Questions?
                    </h2>
                    <p class="text-white/60 mb-6">If you have any questions about this {{ $page->title }}, please contact us:</p>
                    <div class="flex flex-wrap gap-4">
                        @if($siteSettings['contact_email'] ?? false)
                        <a href="mailto:{{ $siteSettings['contact_email'] }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-500/10 text-primary-400 hover:bg-primary-500/20 transition-colors text-sm font-medium">
                            <i class="fas fa-envelope"></i> {{ $siteSettings['contact_email'] }}
                        </a>
                        @endif
                        @if($siteSettings['contact_phone'] ?? false)
                        <a href="tel:{{ $siteSettings['contact_phone'] }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/5 text-white/60 hover:bg-white/10 transition-colors text-sm font-medium">
                            <i class="fas fa-phone"></i> {{ $siteSettings['contact_phone'] }}
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Page Navigation (mobile) --}}
                <div class="lg:hidden mt-8 card-hover p-6">
                    <h3 class="text-xs font-bold text-white/30 uppercase tracking-wider mb-4">Other Legal Pages</h3>
                    <div class="space-y-2">
                        @if($page->slug !== 'privacy-policy')
                        <a href="{{ route('privacy') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition-all">
                            <i class="fas fa-shield-alt w-4 text-center"></i> Privacy Policy
                        </a>
                        @endif
                        @if($page->slug !== 'terms-of-service')
                        <a href="{{ route('terms') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition-all">
                            <i class="fas fa-file-contract w-4 text-center"></i> Terms of Service
                        </a>
                        @endif
                        @if($page->slug !== 'cookies-policy')
                        <a href="{{ route('cookies') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition-all">
                            <i class="fas fa-cookie-bite w-4 text-center"></i> Cookies Policy
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate TOC from legal-section h2 headings
    const content = document.querySelector('.legal-content');
    const tocContainer = document.getElementById('toc-links');
    if (!content || !tocContainer) return;

    const headings = content.querySelectorAll('.legal-section h2');
    headings.forEach(function(heading, index) {
        const id = 'section-' + index;
        heading.setAttribute('id', id);

        const text = heading.textContent.trim();
        const link = document.createElement('a');
        link.href = '#' + id;
        link.className = 'block px-3 py-2 rounded-lg text-sm text-white/50 hover:text-white hover:bg-white/5 transition-all toc-link';
        link.setAttribute('data-section', id);
        link.textContent = text;
        tocContainer.appendChild(link);
    });

    // Highlight active TOC item on scroll
    const tocLinks = document.querySelectorAll('.toc-link');
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                tocLinks.forEach(function(l) { l.classList.remove('bg-primary-500/10', 'text-primary-400'); });
                const active = document.querySelector('.toc-link[data-section="' + entry.target.id + '"]');
                if (active) {
                    active.classList.add('bg-primary-500/10', 'text-primary-400');
                }
            }
        });
    }, { rootMargin: '-20% 0px -60% 0px' });

    headings.forEach(function(h) { observer.observe(h); });
});
</script>
@endpush
@endsection
