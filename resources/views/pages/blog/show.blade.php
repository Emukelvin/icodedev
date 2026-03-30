@extends('layouts.app')
@section('title', $post->meta_title ?? $post->title . ' - ICodeDev Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
<article>
    <section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden">
        <div class="aurora">
            <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
            <div class="aurora-blob w-75 h-75 bg-secondary-500/15 bottom-[-10%] left-[20%]"></div>
        </div>
        <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 relative">
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-10 animate-on-scroll">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                <a href="{{ route('blog') }}" class="hover:text-white transition-colors">Blog</a>
                <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
                <span class="text-gray-300 truncate max-w-50">{{ Str::limit($post->title, 30) }}</span>
            </nav>
            <div class="animate-on-scroll">
                @if($post->category)<span class="inline-flex px-3 py-1.5 glass-neon rounded-full text-xs font-semibold mb-5">{{ $post->category->name }}</span>@endif
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-6 leading-tight">{{ $post->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm text-gray-400">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ $post->author->avatar_url }}" class="w-9 h-9 rounded-full ring-2 ring-white/10"><span class="font-medium text-gray-300">{{ $post->author->name }}</span>
                    </div>
                    <span class="w-1 h-1 bg-primary-400 rounded-full hidden sm:block"></span>
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                    <span class="w-1 h-1 bg-primary-400 rounded-full hidden sm:block"></span>
                    <span>{{ $post->read_time }} min read</span>
                    <span class="w-1 h-1 bg-primary-400 rounded-full hidden sm:block"></span>
                    <span><i class="fas fa-eye mr-1 text-gray-500"></i>{{ number_format($post->views_count) }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 lg:py-20 relative">
        <div class="absolute inset-0 cyber-grid opacity-10 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            @if($post->featured_image)
            <div class="tilt-card -mt-8 mb-12 animate-on-scroll">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full rounded-2xl shadow-xl">
            </div>
            @endif
            <div class="prose prose-lg prose-invert max-w-none mb-12">{!! $post->body !!}</div>

            @if($post->tags->count() > 0)
            <div class="flex flex-wrap items-center gap-2 mb-12 pt-8 border-t border-white/5 animate-on-scroll">
                <span class="text-sm font-bold text-white/50 mr-1">Tags:</span>
                @foreach($post->tags as $tag)
                <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="px-3 py-1.5 bg-white/5 text-white/50 rounded-lg text-xs font-medium hover:bg-primary-500/10 hover:text-primary-400 transition-all duration-500">{{ $tag->name }}</a>
                @endforeach
            </div>
            @endif

            @if($post->allow_comments)
            <div class="border-t border-white/5 pt-12" id="comments">
                <h3 class="text-2xl font-black mb-8">Comments ({{ $post->comments->count() }})</h3>

                @foreach($post->comments as $comment)
                <div class="flex gap-4 mb-6 animate-on-scroll">
                    <div class="w-10 h-10 bg-linear-to-br from-primary-500/20 to-primary-500/10 rounded-full flex items-center justify-center text-primary-400 font-bold shrink-0">
                        {{ substr($comment->user?->name ?? $comment->guest_name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-white">{{ $comment->user?->name ?? $comment->guest_name }}</span>
                            <span class="text-sm text-white/50">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-white/70">{{ $comment->body }}</p>
                        @foreach($comment->replies ?? [] as $reply)
                        <div class="flex gap-3 mt-4 ml-4 pl-4 border-l-2 border-primary-500/20">
                            <div class="w-8 h-8 bg-white/5 rounded-full flex items-center justify-center text-white/60 text-sm font-bold shrink-0">{{ substr($reply->user?->name ?? $reply->guest_name, 0, 1) }}</div>
                            <div>
                                <div class="flex items-center gap-2 mb-1"><span class="font-bold text-sm">{{ $reply->user?->name ?? $reply->guest_name }}</span><span class="text-xs text-white/50">{{ $reply->created_at->diffForHumans() }}</span></div>
                                <p class="text-white/70 text-sm">{{ $reply->body }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <form action="{{ route('blog.comment', $post) }}" method="POST" class="card-hover p-6 mt-8 animate-on-scroll">
                    @csrf
                    <h4 class="font-bold mb-4">Leave a Comment</h4>
                    @guest
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div><label class="label">Name *</label><input type="text" name="guest_name" required class="input-field" value="{{ old('guest_name') }}"></div>
                        <div><label class="label">Email *</label><input type="email" name="guest_email" required class="input-field" value="{{ old('guest_email') }}"></div>
                    </div>
                    @endguest
                    <div class="mb-4"><textarea name="body" rows="4" required class="input-field" placeholder="Write your comment...">{{ old('body') }}</textarea></div>
                    <div style="position:absolute;left:-9999px;"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
                    <button type="submit" class="btn-primary magnetic">Post Comment</button>
                </form>
            </div>
            @endif
        </div>
    </section>
</article>

@if($related->count() > 0)
<section class="py-20 lg:py-28 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-100 h-100 bg-primary-500/10 top-[-20%] left-[-10%]"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex items-end justify-between mb-10 animate-on-scroll">
            <h2 class="text-2xl font-black text-white">Related Articles</h2>
            <a href="{{ route('blog') }}" class="text-primary-400 text-sm font-semibold hover:text-primary-500 hidden sm:block group">View All <i class="fas fa-arrow-right text-xs ml-1 group-hover:translate-x-1 transition-transform duration-300"></i></a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($related as $item)
            <a href="{{ route('blog.show', $item) }}" class="group card-hover animate-on-scroll">
                <div class="aspect-16/10 overflow-hidden"><img src="{{ $item->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"></div>
                <div class="p-6">
                    <h3 class="font-bold text-white group-hover:text-primary-400 transition-colors duration-500 mb-2 leading-snug">{{ $item->title }}</h3>
                    <span class="text-xs text-white/40 font-medium">{{ $item->published_at->format('M d, Y') }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
