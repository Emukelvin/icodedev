@extends('layouts.app')
@section('title', $post->meta_title ?? $post->title . ' - ICodeDev Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
{{-- Reading Progress Bar --}}
<div id="reading-progress" class="fixed top-0 left-0 h-1 bg-linear-to-r from-primary-500 via-secondary-500 to-accent-500 z-[100] transition-none" style="width: 0%"></div>

<article>
    {{-- ═══════════════════════════════════════════════════════════
         HERO - Immersive header with featured image
         ═══════════════════════════════════════════════════════════ --}}
    <section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden">
        <div class="aurora">
            <div class="aurora-blob w-150 h-150 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
            <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-10%] left-[10%]"></div>
        </div>
        <div class="absolute inset-0 cyber-grid opacity-25 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-10 lg:pt-40 lg:pb-14 relative">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-white/40 mb-8 animate-on-scroll">
                <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors"><i class="fas fa-home text-xs"></i></a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <a href="{{ route('blog') }}" class="hover:text-primary-400 transition-colors">Blog</a>
                @if($post->category)
                <i class="fas fa-chevron-right text-[9px]"></i>
                <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="hover:text-primary-400 transition-colors">{{ $post->category->name }}</a>
                @endif
            </nav>

            <div class="max-w-4xl animate-on-scroll">
                {{-- Category Badge --}}
                @if($post->category)
                <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="inline-flex items-center gap-2 px-4 py-2 glass-neon rounded-full text-xs font-bold mb-6 hover:scale-105 transition-transform">
                    <span class="w-2 h-2 bg-primary-400 rounded-full"></span>
                    {{ $post->category->name }}
                </a>
                @endif

                {{-- Title --}}
                <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-[3.25rem] font-black tracking-tight leading-[1.1] mb-8">{{ $post->title }}</h1>

                {{-- Excerpt --}}
                @if($post->excerpt)
                <p class="text-lg sm:text-xl text-white/60 leading-relaxed max-w-3xl mb-8">{{ $post->excerpt }}</p>
                @endif

                {{-- Author & Meta Row --}}
                <div class="flex flex-wrap items-center gap-6">
                    <a href="#author-card" class="flex items-center gap-3 group">
                        <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}" class="w-12 h-12 rounded-full ring-2 ring-primary-500/30 group-hover:ring-primary-400 transition-all">
                        <div>
                            <p class="font-bold text-white text-sm group-hover:text-primary-400 transition-colors">{{ $post->author->name }}</p>
                            <p class="text-white/40 text-xs">{{ $post->published_at->format('F j, Y') }}</p>
                        </div>
                    </a>
                    <div class="hidden sm:flex items-center gap-4 text-sm text-white/40">
                        <span class="flex items-center gap-1.5"><i class="far fa-clock text-primary-400/60"></i> {{ $post->read_time }} min read</span>
                        <span class="w-1 h-1 bg-white/20 rounded-full"></span>
                        <span class="flex items-center gap-1.5"><i class="far fa-eye text-primary-400/60"></i> {{ number_format($post->views_count) }} views</span>
                        @if($post->allow_comments)
                        <span class="w-1 h-1 bg-white/20 rounded-full"></span>
                        <a href="#comments" class="flex items-center gap-1.5 hover:text-primary-400 transition-colors"><i class="far fa-comment text-primary-400/60"></i> {{ $post->comments->count() }} comments</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured Image - Full Width --}}
        @if($post->featured_image)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-0 relative">
            <div class="relative rounded-t-3xl overflow-hidden shadow-2xl shadow-black/50 animate-on-scroll">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full aspect-[21/9] object-cover">
                <div class="absolute inset-0 bg-linear-to-t from-surface-950 via-transparent to-transparent"></div>
            </div>
        </div>
        @endif
    </section>

    {{-- ═══════════════════════════════════════════════════════════
         CONTENT BODY - Two-column layout with sticky sidebar
         ═══════════════════════════════════════════════════════════ --}}
    <section class="py-12 lg:py-16 bg-surface-950 relative">
        <div class="absolute inset-0 cyber-grid opacity-5 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-12 gap-10 xl:gap-14">

                {{-- Main Content --}}
                <div class="lg:col-span-8 xl:col-span-8">
                    {{-- Article Body --}}
                    <div id="article-body" class="prose prose-lg prose-invert max-w-none
                        prose-headings:font-black prose-headings:tracking-tight prose-headings:scroll-mt-24
                        prose-h2:text-2xl prose-h2:sm:text-3xl prose-h2:mt-14 prose-h2:mb-6 prose-h2:pb-4 prose-h2:border-b prose-h2:border-white/5
                        prose-h3:text-xl prose-h3:sm:text-2xl prose-h3:mt-10 prose-h3:mb-4
                        prose-p:text-white/70 prose-p:leading-[1.85] prose-p:mb-6
                        prose-a:text-primary-400 prose-a:no-underline hover:prose-a:text-primary-300 prose-a:font-semibold prose-a:transition-colors
                        prose-strong:text-white prose-strong:font-bold
                        prose-code:text-primary-300 prose-code:bg-white/5 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded-md prose-code:text-sm prose-code:font-normal prose-code:before:content-none prose-code:after:content-none
                        prose-pre:bg-surface-900 prose-pre:border prose-pre:border-white/5 prose-pre:rounded-2xl prose-pre:shadow-xl prose-pre:shadow-black/20
                        prose-blockquote:border-l-primary-500 prose-blockquote:bg-primary-500/5 prose-blockquote:rounded-r-2xl prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:not-italic
                        prose-img:rounded-2xl prose-img:shadow-xl prose-img:shadow-black/30
                        prose-ul:text-white/70 prose-ol:text-white/70
                        prose-li:marker:text-primary-400
                        animate-on-scroll"
                    >
                        {!! $post->body !!}
                    </div>

                    {{-- Tags --}}
                    @if($post->tags->count() > 0)
                    <div class="mt-12 pt-8 border-t border-white/5 animate-on-scroll">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="text-sm font-bold text-white/40 mr-1"><i class="fas fa-tags text-xs mr-1"></i> Tags:</span>
                            @foreach($post->tags as $tag)
                            <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="px-4 py-2 bg-white/5 text-white/60 rounded-xl text-xs font-semibold hover:bg-primary-500/10 hover:text-primary-400 border border-white/5 hover:border-primary-500/20 transition-all duration-300">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Share Row --}}
                    <div class="mt-8 pt-8 border-t border-white/5 animate-on-scroll">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <span class="text-sm font-bold text-white/40"><i class="fas fa-share-alt text-xs mr-1.5"></i> Share this article</span>
                            <div class="flex items-center gap-3">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#1DA1F2] hover:text-white hover:border-[#1DA1F2] hover:scale-110 transition-all duration-300" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] hover:scale-110 transition-all duration-300" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] hover:scale-110 transition-all duration-300" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.querySelector('i').className = 'fas fa-check'; setTimeout(() => { this.querySelector('i').className = 'fas fa-link'; }, 2000); })" class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-primary-500 hover:text-white hover:border-primary-500 hover:scale-110 transition-all duration-300 cursor-pointer" title="Copy link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Author Card --}}
                    <div id="author-card" class="mt-10 card-hover p-8 animate-on-scroll scroll-mt-24">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}" class="w-20 h-20 rounded-2xl ring-2 ring-primary-500/20 object-cover shrink-0">
                            <div>
                                <p class="text-xs text-primary-400 font-bold uppercase tracking-widest mb-1">Written by</p>
                                <h3 class="text-xl font-black text-white mb-2">{{ $post->author->name }}</h3>
                                @if($post->author->bio ?? false)
                                <p class="text-white/50 text-sm leading-relaxed mb-4">{{ $post->author->bio }}</p>
                                @else
                                <p class="text-white/50 text-sm leading-relaxed mb-4">Author at ICodeDev. Sharing insights on web development, technology, and best practices.</p>
                                @endif
                                <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-primary-400 text-sm font-semibold hover:text-primary-300 transition-colors">
                                    View all posts <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Prev / Next Navigation --}}
                    @if($previousPost || $nextPost)
                    <div class="mt-10 grid sm:grid-cols-2 gap-4 animate-on-scroll">
                        @if($previousPost)
                        <a href="{{ route('blog.show', $previousPost) }}" class="group card-hover p-6 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/40 group-hover:text-primary-400 group-hover:bg-primary-500/10 transition-all shrink-0 mt-0.5">
                                <i class="fas fa-arrow-left text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-white/30 font-bold uppercase tracking-wider mb-1">Previous</p>
                                <p class="text-sm font-bold text-white group-hover:text-primary-400 transition-colors leading-snug truncate">{{ $previousPost->title }}</p>
                            </div>
                        </a>
                        @else
                        <div></div>
                        @endif
                        @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost) }}" class="group card-hover p-6 flex items-start gap-4 sm:text-right sm:flex-row-reverse">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/40 group-hover:text-primary-400 group-hover:bg-primary-500/10 transition-all shrink-0 mt-0.5">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-white/30 font-bold uppercase tracking-wider mb-1">Next</p>
                                <p class="text-sm font-bold text-white group-hover:text-primary-400 transition-colors leading-snug truncate">{{ $nextPost->title }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                    @endif

                    {{-- Comments Section --}}
                    @if($post->allow_comments)
                    <div class="mt-14 pt-10 border-t border-white/5" id="comments">
                        <div class="flex items-center justify-between mb-10 animate-on-scroll">
                            <h3 class="text-2xl font-black text-white flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-400 text-sm"><i class="far fa-comment-dots"></i></span>
                                Comments
                                <span class="text-base text-white/30 font-medium">({{ $post->comments->count() }})</span>
                            </h3>
                        </div>

                        {{-- Comment List --}}
                        @forelse($post->comments as $comment)
                        <div class="mb-8 animate-on-scroll">
                            <div class="flex gap-4">
                                <div class="w-11 h-11 bg-linear-to-br from-primary-500/20 to-secondary-500/10 rounded-xl flex items-center justify-center text-primary-400 font-bold shrink-0 text-sm">
                                    {{ strtoupper(substr($comment->user?->name ?? $comment->guest_name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="font-bold text-white text-sm">{{ $comment->user?->name ?? $comment->guest_name }}</span>
                                        <span class="text-xs text-white/30">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-white/60 text-sm leading-relaxed">{{ $comment->body }}</p>

                                    {{-- Replies --}}
                                    @foreach($comment->replies ?? [] as $reply)
                                    <div class="mt-5 ml-2 pl-5 border-l-2 border-primary-500/10">
                                        <div class="flex gap-3">
                                            <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center text-white/50 text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($reply->user?->name ?? $reply->guest_name, 0, 1)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                                    <span class="font-bold text-white text-sm">{{ $reply->user?->name ?? $reply->guest_name }}</span>
                                                    <span class="text-xs text-white/30">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-white/60 text-sm leading-relaxed">{{ $reply->body }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 animate-on-scroll">
                            <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 text-white/20 text-xl">
                                <i class="far fa-comment"></i>
                            </div>
                            <p class="text-white/30 text-sm font-medium">No comments yet. Be the first to share your thoughts!</p>
                        </div>
                        @endforelse

                        {{-- Comment Form --}}
                        <form action="{{ route('blog.comment', $post) }}" method="POST" class="mt-10 card-hover p-8 animate-on-scroll">
                            @csrf
                            <h4 class="text-lg font-black text-white mb-6 flex items-center gap-2">
                                <i class="fas fa-pen text-primary-400 text-sm"></i> Leave a Comment
                            </h4>
                            @guest
                            <div class="grid md:grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="label">Name <span class="text-red-400">*</span></label>
                                    <input type="text" name="guest_name" required class="input-field" value="{{ old('guest_name') }}" placeholder="Your name">
                                </div>
                                <div>
                                    <label class="label">Email <span class="text-red-400">*</span></label>
                                    <input type="email" name="guest_email" required class="input-field" value="{{ old('guest_email') }}" placeholder="your@email.com">
                                </div>
                            </div>
                            @endguest
                            <div class="mb-5">
                                <textarea name="body" rows="5" required class="input-field" placeholder="Share your thoughts on this article...">{{ old('body') }}</textarea>
                            </div>
                            <div style="position:absolute;left:-9999px;"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                            <button type="submit" class="btn-primary magnetic inline-flex items-center gap-2">
                                <i class="fas fa-paper-plane text-sm"></i> Post Comment
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-4 xl:col-span-4">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        {{-- Table of Contents --}}
                        <div id="toc-container" class="card-hover p-6 hidden lg:block animate-on-scroll">
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-list-ul text-primary-400 text-xs"></i> On This Page
                            </h3>
                            <nav id="toc-nav" class="space-y-1 text-sm max-h-[60vh] overflow-y-auto scrollbar-thin"></nav>
                        </div>

                        {{-- Quick Info --}}
                        <div class="card-hover p-6 animate-on-scroll">
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-info-circle text-primary-400 text-xs"></i> Article Info
                            </h3>
                            <div class="space-y-3.5">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/40">Published</span>
                                    <span class="text-white/70 font-medium">{{ $post->published_at->format('M d, Y') }}</span>
                                </div>
                                @if($post->updated_at->gt($post->published_at->addDay()))
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/40">Updated</span>
                                    <span class="text-white/70 font-medium">{{ $post->updated_at->format('M d, Y') }}</span>
                                </div>
                                @endif
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/40">Read time</span>
                                    <span class="text-white/70 font-medium">{{ $post->read_time }} min</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/40">Views</span>
                                    <span class="text-white/70 font-medium">{{ number_format($post->views_count) }}</span>
                                </div>
                                @if($post->category)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/40">Category</span>
                                    <a href="{{ route('blog', ['category' => $post->category->slug]) }}" class="text-primary-400 font-medium hover:text-primary-300 transition-colors">{{ $post->category->name }}</a>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Share Buttons (Sidebar) --}}
                        <div class="card-hover p-6 animate-on-scroll">
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-share-alt text-primary-400 text-xs"></i> Share
                            </h3>
                            <div class="grid grid-cols-4 gap-3">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#1DA1F2] hover:text-white hover:border-[#1DA1F2] transition-all duration-300" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] transition-all duration-300" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] transition-all duration-300" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.querySelector('i').className = 'fas fa-check'; setTimeout(() => { this.querySelector('i').className = 'fas fa-link'; }, 2000); })" class="aspect-square rounded-xl bg-white/5 border border-white/5 flex items-center justify-center text-white/50 hover:bg-primary-500 hover:text-white hover:border-primary-500 transition-all duration-300 cursor-pointer" title="Copy link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Tags (Sidebar) --}}
                        @if($post->tags->count() > 0)
                        <div class="card-hover p-6 animate-on-scroll">
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i class="fas fa-tags text-primary-400 text-xs"></i> Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium hover:bg-primary-500/10 hover:text-primary-400 border border-white/5 hover:border-primary-500/20 transition-all duration-300">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
</article>

{{-- ═══════════════════════════════════════════════════════════
     RELATED ARTICLES
     ═══════════════════════════════════════════════════════════ --}}
@if($related->count() > 0)
<section class="py-20 lg:py-28 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-100 h-100 bg-primary-500/10 top-[-20%] left-[-10%]"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex items-end justify-between mb-12 animate-on-scroll">
            <div>
                <span class="section-label mb-3"><i class="fas fa-newspaper text-xs"></i> Keep Reading</span>
                <h2 class="text-2xl sm:text-3xl font-black text-white mt-3">Related <span class="gradient-text">Articles</span></h2>
            </div>
            <a href="{{ route('blog') }}" class="text-primary-400 text-sm font-semibold hover:text-primary-300 hidden sm:flex items-center gap-2 group transition-colors">
                View All Articles <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
            </a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $item)
            <a href="{{ route('blog.show', $item) }}" class="group card-hover animate-on-scroll block">
                <div class="aspect-16/10 overflow-hidden relative">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @if($item->category)
                    <span class="absolute top-4 left-4 px-3 py-1 glass-dark rounded-lg text-xs font-bold text-primary-400">{{ $item->category->name }}</span>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-white group-hover:text-primary-400 transition-colors duration-300 mb-3 leading-snug">{{ $item->title }}</h3>
                    @if($item->excerpt)
                    <p class="text-white/40 text-sm leading-relaxed mb-4 line-clamp-2">{{ Str::limit($item->excerpt, 100) }}</p>
                    @endif
                    <div class="flex items-center gap-3 text-xs text-white/30 font-medium">
                        <span>{{ $item->published_at->format('M d, Y') }}</span>
                        <span class="w-1 h-1 bg-white/20 rounded-full"></span>
                        <span>{{ $item->read_time }} min read</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8 sm:hidden animate-on-scroll">
            <a href="{{ route('blog') }}" class="text-primary-400 text-sm font-semibold hover:text-primary-300 inline-flex items-center gap-2">View All Articles <i class="fas fa-arrow-right text-xs"></i></a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════
     NEWSLETTER CTA
     ═══════════════════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-surface-950 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/15 top-[-10%] left-[15%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/10 bottom-[-10%] right-[15%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative animate-on-scroll">
        <span class="inline-flex items-center gap-2 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
            <i class="fas fa-envelope text-primary-400 text-xs"></i> Newsletter
        </span>
        <h2 class="text-2xl sm:text-3xl font-black text-white mb-4">Stay in the <span class="text-shimmer">Loop</span></h2>
        <p class="text-white/50 mb-8 max-w-lg mx-auto">Get the latest articles, tutorials, and tech insights delivered straight to your inbox.</p>
        <form action="{{ route('newsletter.submit') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            @csrf
            <input type="email" name="email" required placeholder="Enter your email" class="input-field flex-1 text-center sm:text-left">
            <button type="submit" class="btn-primary magnetic whitespace-nowrap">Subscribe</button>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading Progress Bar
    const progressBar = document.getElementById('reading-progress');
    const article = document.getElementById('article-body');
    if (progressBar && article) {
        window.addEventListener('scroll', function() {
            const rect = article.getBoundingClientRect();
            const articleTop = rect.top + window.scrollY;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrolled = window.scrollY - articleTop + windowHeight * 0.3;
            const progress = Math.min(100, Math.max(0, (scrolled / articleHeight) * 100));
            progressBar.style.width = progress + '%';
        }, { passive: true });
    }

    // Auto-generate Table of Contents from h2/h3 in article
    const tocNav = document.getElementById('toc-nav');
    const tocContainer = document.getElementById('toc-container');
    if (tocNav && article) {
        const headings = article.querySelectorAll('h2, h3');
        if (headings.length >= 2) {
            tocContainer.classList.remove('hidden');
            tocContainer.classList.add('block');
            headings.forEach(function(heading, index) {
                if (!heading.id) heading.id = 'heading-' + index;
                const link = document.createElement('a');
                link.href = '#' + heading.id;
                link.textContent = heading.textContent;
                link.dataset.target = heading.id;
                const isH3 = heading.tagName === 'H3';
                link.className = (isH3 ? 'pl-4 ' : '') + 'block py-1.5 px-3 rounded-lg text-white/40 hover:text-primary-400 hover:bg-white/5 transition-all duration-200 truncate';
                if (isH3) link.classList.add('text-xs');
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById(heading.id).scrollIntoView({ behavior: 'smooth' });
                });
                tocNav.appendChild(link);
            });

            // Highlight active heading
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        tocNav.querySelectorAll('a').forEach(function(a) {
                            a.classList.remove('text-primary-400', 'bg-white/5', 'font-semibold');
                            a.classList.add('text-white/40');
                        });
                        const active = tocNav.querySelector('[data-target="' + entry.target.id + '"]');
                        if (active) {
                            active.classList.add('text-primary-400', 'bg-white/5', 'font-semibold');
                            active.classList.remove('text-white/40');
                        }
                    }
                });
            }, { rootMargin: '-80px 0px -70% 0px' });
            headings.forEach(function(h) { observer.observe(h); });
        }
    }
});
</script>
@endpush
@endsection
