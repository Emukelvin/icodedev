@extends('layouts.dashboard')
@section('title', 'My Reviews')

@section('sidebar')
@include('client.partials.sidebar', ['active' => 'testimonials'])
@endsection

@section('page-title', 'My Reviews')
@section('page-subtitle', 'Share your experience with us')

@section('content')
<div class="max-w-4xl">

    {{-- Hero Banner --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 mb-8 bg-linear-to-r from-amber-600/20 to-primary-600/20 relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-5 text-[120px] leading-none pr-6 pt-2"><i class="fas fa-quote-right"></i></div>
        <div class="relative flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2"><i class="fas fa-star text-amber-400 mr-2"></i>Your Voice Matters</h2>
                <p class="text-white/60">Share your experience working with us. Approved reviews are showcased on our website to help other clients.</p>
            </div>
            <div class="text-center shrink-0">
                <div class="text-4xl font-bold text-amber-400">{{ $testimonials->count() }}</div>
                <div class="text-sm text-white/50">Reviews Submitted</div>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    @if($testimonials->count())
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5 text-center">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 ring-1 ring-amber-500/20 flex items-center justify-center mx-auto mb-3"><i class="fas fa-clock text-amber-400"></i></div>
            <div class="text-2xl font-bold text-white">{{ $testimonials->where('status', 'pending')->count() }}</div>
            <div class="text-xs text-white/40 mt-1">Pending Review</div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5 text-center">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 ring-1 ring-emerald-500/20 flex items-center justify-center mx-auto mb-3"><i class="fas fa-check-circle text-emerald-400"></i></div>
            <div class="text-2xl font-bold text-white">{{ $testimonials->where('status', 'approved')->count() }}</div>
            <div class="text-xs text-white/40 mt-1">Approved & Live</div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5 text-center">
            <div class="w-10 h-10 rounded-xl bg-primary-500/10 ring-1 ring-primary-500/20 flex items-center justify-center mx-auto mb-3"><i class="fas fa-star text-primary-400"></i></div>
            @php $avgRating = $testimonials->avg('rating'); @endphp
            <div class="text-2xl font-bold text-white">{{ $avgRating ? number_format($avgRating, 1) : '-' }}</div>
            <div class="text-xs text-white/40 mt-1">Avg Rating</div>
        </div>
    </div>
    @endif

    {{-- Submit Review Card --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden mb-8">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-pen-fancy text-amber-400 text-sm"></i></div>
            <div>
                <h2 class="text-sm font-bold text-white">Write a Review</h2>
                <p class="text-xs text-white/40">Tell the world about your experience</p>
            </div>
        </div>

        <form action="{{ route('client.testimonials.store') }}" method="POST" class="p-6">
            @csrf

            {{-- Rating Section --}}
            <div class="mb-6" x-data="{ rating: {{ old('rating', 0) }}, hoverRating: 0, setRating(val) { this.rating = val; } }">
                <label class="label mb-3">How would you rate your experience? <span class="text-red-400">*</span></label>
                <input type="hidden" name="rating" x-model="rating">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1">
                        <span class="inline-flex text-3xl cursor-pointer p-1 transition-all duration-200"
                            @click.prevent.stop="setRating(1)" @mouseenter="hoverRating = 1" @mouseleave="hoverRating = 0"
                            :class="(hoverRating || rating) >= 1 ? 'text-amber-400 scale-110' : 'text-white/15 hover:text-amber-400/50'"><i class="fas fa-star pointer-events-none"></i></span>
                        <span class="inline-flex text-3xl cursor-pointer p-1 transition-all duration-200"
                            @click.prevent.stop="setRating(2)" @mouseenter="hoverRating = 2" @mouseleave="hoverRating = 0"
                            :class="(hoverRating || rating) >= 2 ? 'text-amber-400 scale-110' : 'text-white/15 hover:text-amber-400/50'"><i class="fas fa-star pointer-events-none"></i></span>
                        <span class="inline-flex text-3xl cursor-pointer p-1 transition-all duration-200"
                            @click.prevent.stop="setRating(3)" @mouseenter="hoverRating = 3" @mouseleave="hoverRating = 0"
                            :class="(hoverRating || rating) >= 3 ? 'text-amber-400 scale-110' : 'text-white/15 hover:text-amber-400/50'"><i class="fas fa-star pointer-events-none"></i></span>
                        <span class="inline-flex text-3xl cursor-pointer p-1 transition-all duration-200"
                            @click.prevent.stop="setRating(4)" @mouseenter="hoverRating = 4" @mouseleave="hoverRating = 0"
                            :class="(hoverRating || rating) >= 4 ? 'text-amber-400 scale-110' : 'text-white/15 hover:text-amber-400/50'"><i class="fas fa-star pointer-events-none"></i></span>
                        <span class="inline-flex text-3xl cursor-pointer p-1 transition-all duration-200"
                            @click.prevent.stop="setRating(5)" @mouseenter="hoverRating = 5" @mouseleave="hoverRating = 0"
                            :class="(hoverRating || rating) >= 5 ? 'text-amber-400 scale-110' : 'text-white/15 hover:text-amber-400/50'"><i class="fas fa-star pointer-events-none"></i></span>
                    </div>
                    <span class="text-sm font-medium ml-2">
                        <span x-show="!rating && !hoverRating" class="text-white/30">Select a rating</span>
                        <span x-show="(hoverRating || rating) === 1" x-cloak class="text-red-400">Poor</span>
                        <span x-show="(hoverRating || rating) === 2" x-cloak class="text-orange-400">Fair</span>
                        <span x-show="(hoverRating || rating) === 3" x-cloak class="text-amber-400">Good</span>
                        <span x-show="(hoverRating || rating) === 4" x-cloak class="text-emerald-400">Very Good</span>
                        <span x-show="(hoverRating || rating) === 5" x-cloak class="text-emerald-400">Excellent!</span>
                    </span>
                </div>
                @error('rating')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Position --}}
            <div class="mb-5">
                <label class="label">Your Position / Title</label>
                <input type="text" name="position" class="input-field" placeholder="e.g. CEO, CTO, Founder, Marketing Director" value="{{ old('position', auth()->user()->company ? '' : '') }}">
                <p class="text-xs text-white/25 mt-1">Optional — displayed alongside your review</p>
            </div>

            {{-- Review Content --}}
            <div class="mb-6" x-data="{ chars: {{ strlen(old('content', '')) }} }">
                <label class="label">Your Review <span class="text-red-400">*</span></label>
                <textarea name="content" rows="5" class="input-field" placeholder="What did you love about working with us? How did we help your business? Would you recommend us to others?" required minlength="20" maxlength="2000" @input="chars = $event.target.value.length">{{ old('content') }}</textarea>
                <div class="flex items-center justify-between mt-1.5">
                    @error('content')<p class="text-red-400 text-xs">{{ $message }}</p>@enderror
                    <span class="text-xs ml-auto" :class="chars < 20 ? 'text-red-400/60' : 'text-white/25'"><span x-text="chars"></span> / 2000</span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-xs text-white/25"><i class="fas fa-shield-alt mr-1"></i>Reviews are moderated before publishing</p>
                <button type="submit" class="btn-primary"><i class="fas fa-paper-plane mr-2"></i>Submit Review</button>
            </div>
        </form>
    </div>

    {{-- Previous Reviews --}}
    @if($testimonials->count())
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider">Your Submitted Reviews</h3>
    </div>
    <div class="space-y-4">
        @foreach($testimonials as $testimonial)
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden transition-all hover:border-white/10">
            <div class="p-6">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex items-center gap-3">
                        {{-- Stars --}}
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-sm {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-white/10' }}"></i>
                            @endfor
                        </div>
                        <span class="text-white/30 text-xs">&middot;</span>
                        <span class="text-white/30 text-xs">{{ $testimonial->created_at->diffForHumans() }}</span>
                    </div>
                    @if($testimonial->status === 'approved')
                    <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20"><i class="fas fa-check-circle text-[10px]"></i> Approved</span>
                    @elseif($testimonial->status === 'pending')
                    <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20"><i class="fas fa-clock text-[10px]"></i> Pending Review</span>
                    @else
                    <span class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-red-500/15 text-red-400 ring-1 ring-red-500/20"><i class="fas fa-times-circle text-[10px]"></i> Rejected</span>
                    @endif
                </div>

                {{-- Quote --}}
                <div class="relative pl-4 border-l-2 border-primary-500/20">
                    <i class="fas fa-quote-left text-primary-500/10 text-lg absolute -left-1 -top-1"></i>
                    <p class="text-white/70 text-sm leading-relaxed">{{ $testimonial->content }}</p>
                </div>

                {{-- Meta --}}
                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-white/5 text-xs text-white/30">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Submitted {{ $testimonial->created_at->format('M d, Y \a\t g:i A') }}</span>
                    @if($testimonial->status === 'approved')
                    <span class="text-emerald-400/60">&middot; Visible on website</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    {{-- Empty State --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <div class="w-16 h-16 rounded-2xl bg-amber-500/10 ring-1 ring-amber-500/20 flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-star text-amber-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-white mb-2">No Reviews Yet</h3>
        <p class="text-white/40 text-sm max-w-sm mx-auto">You haven't submitted any reviews yet. Use the form above to share your experience working with us!</p>
    </div>
    @endif
</div>
@endsection
