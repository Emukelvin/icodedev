@extends('layouts.app')
@section('title', 'Blog - ICodeDev')

@section('content')
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] left-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 relative">
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-600"></i>
            <span class="text-white">Blog</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8"><i class="fas fa-pen-nib text-primary-400 text-xs"></i> Blog & Resources</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6">Insights & <span class="text-shimmer">Articles</span></h1>
            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">Tech insights, tutorials, and case studies from our team.</p>
        </div>
    </div>
</section>

<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-4 gap-12">
            <div class="lg:col-span-3">
                <form action="{{ route('blog') }}" method="GET" class="mb-10 animate-on-scroll">
                    <div class="flex gap-3">
                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" placeholder="Search articles..." class="input-field pl-11" value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn-primary magnetic">Search</button>
                    </div>
                </form>

                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="group card-hover animate-on-scroll">
                        <div class="aspect-16/10 overflow-hidden">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div class="p-6">
                            @if($post->category)
                            <span class="inline-flex px-2.5 py-1 glass-dark rounded-lg text-xs font-semibold mb-3 text-primary-400">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="text-lg font-bold text-white group-hover:text-primary-400 transition-colors duration-500 mb-2 leading-snug">{{ $post->title }}</h3>
                            <p class="text-white/50 text-sm leading-relaxed mb-4">{{ Str::limit($post->excerpt, 100) }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-400 font-medium">
                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                <span class="w-1 h-1 bg-primary-400 rounded-full"></span>
                                <span>{{ $post->read_time }} min read</span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-3 text-center py-24">
                        <div class="w-16 h-16 bg-linear-to-br from-primary-500/10 to-primary-500/5 rounded-2xl flex items-center justify-center mx-auto mb-5 text-primary-400 text-2xl"><i class="fas fa-newspaper"></i></div>
                        <h3 class="font-black text-white mb-2">No articles found</h3>
                        <p class="text-white/50">Check back soon for new content.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-12">{{ $posts->withQueryString()->links() }}</div>
            </div>

            <div class="space-y-6">
                <div class="card-hover p-6 animate-on-scroll">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Categories</h3>
                    <div class="space-y-1">
                        @foreach($categories as $category)
                        <a href="{{ route('blog', ['category' => $category->slug]) }}" class="flex justify-between items-center p-2.5 rounded-xl text-sm hover:bg-white/5 transition-all duration-500 {{ request('category') === $category->slug ? 'bg-primary-500/10 text-primary-400 font-semibold' : 'text-white/60' }}">
                            <span>{{ $category->name }}</span>
                            <span class="px-2 py-0.5 bg-white/5 text-white/40 rounded-md text-xs font-medium">{{ $category->posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-hover p-6 animate-on-scroll">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <a href="{{ route('blog', ['tag' => $tag->slug]) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-500 {{ request('tag') === $tag->slug ? 'bg-linear-to-r from-primary-600 to-primary-500 text-white shadow-lg shadow-primary-500/25' : 'bg-white/5 text-white/50 hover:bg-primary-500/10 hover:text-primary-400' }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
