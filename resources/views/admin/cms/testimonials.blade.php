@extends('layouts.dashboard')
@section('title', 'Testimonials - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Testimonials</h1>
        <p class="text-sm text-white/50 mt-1">Manage client testimonials and reviews</p>
    </div>
    <button onclick="document.getElementById('testimonial-modal').style.display='flex'" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Testimonial</button>
</div>

{{-- Pending Alert Banner --}}
@if($counts['pending'] > 0)
<div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-5 mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-500/15 flex items-center justify-center shrink-0">
            <i class="fas fa-bell text-amber-400 text-lg animate-pulse"></i>
        </div>
        <div>
            <h3 class="text-sm font-bold text-amber-400">{{ $counts['pending'] }} Review{{ $counts['pending'] > 1 ? 's' : '' }} Pending Approval</h3>
            <p class="text-xs text-white/50 mt-0.5">Client-submitted reviews are waiting for your review before appearing on the website.</p>
        </div>
    </div>
    <a href="{{ route('admin.cms.testimonials', ['filter' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20 hover:bg-amber-500/25 transition-all whitespace-nowrap"><i class="fas fa-eye mr-1.5"></i>View Pending</a>
</div>
@endif

{{-- Filter Tabs --}}
<div class="flex items-center gap-1 mb-8 bg-surface-800/60 backdrop-blur-sm rounded-xl border border-white/6 p-1.5 w-fit">
    <a href="{{ route('admin.cms.testimonials') }}"
       class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'all' ? 'bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
        All <span class="ml-1.5 px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'all' ? 'bg-primary-500/20' : 'bg-white/5' }}">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('admin.cms.testimonials', ['filter' => 'pending']) }}"
       class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'pending' ? 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
        <i class="fas fa-clock mr-1.5"></i>Pending <span class="ml-1.5 px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'pending' ? 'bg-amber-500/20' : 'bg-white/5' }}">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('admin.cms.testimonials', ['filter' => 'approved']) }}"
       class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'approved' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
        <i class="fas fa-check-circle mr-1.5"></i>Approved <span class="ml-1.5 px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'approved' ? 'bg-emerald-500/20' : 'bg-white/5' }}">{{ $counts['approved'] }}</span>
    </a>
    <a href="{{ route('admin.cms.testimonials', ['filter' => 'rejected']) }}"
       class="px-4 py-2 rounded-lg text-xs font-semibold transition-all {{ $filter === 'rejected' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
        <i class="fas fa-times-circle mr-1.5"></i>Rejected <span class="ml-1.5 px-1.5 py-0.5 rounded-md text-[10px] {{ $filter === 'rejected' ? 'bg-red-500/20' : 'bg-white/5' }}">{{ $counts['rejected'] }}</span>
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($testimonials as $testimonial)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden hover:border-white/12 transition-all group {{ ($testimonial->status ?? 'approved') === 'pending' ? 'ring-1 ring-amber-500/20' : '' }}">
        <div class="p-6">
            {{-- Status Badge + Quote Icon --}}
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-quote-left text-primary-500/20 text-2xl"></i>
                <div class="flex items-center gap-2">
                    @if($testimonial->user_id)
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-purple-500/10 text-purple-400 ring-1 ring-purple-500/20">Client Submitted</span>
                    @endif
                    @if(($testimonial->status ?? 'approved') === 'pending')
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20">Pending</span>
                    @elseif(($testimonial->status ?? 'approved') === 'rejected')
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-red-500/15 text-red-400 ring-1 ring-red-500/20">Rejected</span>
                    @else
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20">Approved</span>
                    @endif
                </div>
            </div>

            {{-- Content --}}
            <p class="text-white/60 text-sm leading-relaxed mb-5 line-clamp-4">{{ $testimonial->content }}</p>

            {{-- Stars --}}
            <div class="flex gap-0.5 mb-5">
                @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star text-sm {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-white/10' }}"></i>
                @endfor
            </div>

            {{-- Author --}}
            <div class="flex items-center gap-3 pt-5 border-t border-white/5">
                @if($testimonial->avatar ?? $testimonial->client_avatar)
                <img src="{{ Storage::url($testimonial->avatar ?? $testimonial->client_avatar) }}" class="w-11 h-11 rounded-xl object-cover ring-1 ring-white/10">
                @else
                <div class="w-11 h-11 rounded-xl bg-linear-to-br from-primary-500/20 to-purple-500/20 ring-1 ring-primary-500/20 flex items-center justify-center shrink-0">
                    <span class="text-sm font-black text-primary-400">{{ strtoupper(substr($testimonial->client_name, 0, 1)) }}</span>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-white text-sm">{{ $testimonial->client_name }}</h3>
                    <p class="text-xs text-white/40 truncate">
                        @if($testimonial->position ?? $testimonial->client_position){{ $testimonial->position ?? $testimonial->client_position }}@endif
                        @if(($testimonial->position ?? $testimonial->client_position) && ($testimonial->company ?? $testimonial->client_company)) &middot; @endif
                        @if($testimonial->company ?? $testimonial->client_company){{ $testimonial->company ?? $testimonial->client_company }}@endif
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-2 pt-4 mt-4 border-t border-white/5">
                @if(($testimonial->status ?? 'approved') !== 'approved')
                <form action="{{ route('admin.cms.testimonials.approve', $testimonial) }}" method="POST">@csrf @method('PATCH')
                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20 hover:bg-emerald-500/25 transition-all"><i class="fas fa-check mr-1.5"></i>Approve</button>
                </form>
                @endif
                @if(($testimonial->status ?? 'approved') !== 'rejected')
                <form action="{{ route('admin.cms.testimonials.reject', $testimonial) }}" method="POST">@csrf @method('PATCH')
                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 text-red-400 ring-1 ring-red-500/20 hover:bg-red-500/20 transition-all"><i class="fas fa-times mr-1.5"></i>Reject</button>
                </form>
                @endif
                <a href="{{ route('admin.cms.testimonials.edit', $testimonial) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 hover:bg-primary-500/25 transition-all"><i class="fas fa-edit mr-1.5"></i>Edit</a>
                <form action="{{ route('admin.cms.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Delete this testimonial?')">@csrf @method('DELETE')
                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-400 bg-red-500/10 ring-1 ring-red-500/20 hover:bg-red-500/20 transition-all"><i class="fas fa-trash mr-1.5"></i>Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fas fa-star text-white/15 text-4xl mb-4 block"></i>
        @if($filter !== 'all')
        <p class="text-white/40 mb-4">No {{ $filter }} testimonials</p>
        <a href="{{ route('admin.cms.testimonials') }}" class="btn-secondary inline-block"><i class="fas fa-arrow-left mr-2"></i>View All</a>
        @else
        <p class="text-white/40 mb-4">No testimonials yet</p>
        <button onclick="document.getElementById('testimonial-modal').style.display='flex'" class="btn-primary inline-block"><i class="fas fa-plus mr-2"></i>Add First Testimonial</button>
        @endif
    </div>
    @endforelse
</div>

{{-- Add Testimonial Modal --}}
<div id="testimonial-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 items-center justify-center" style="display:none">
    <div class="bg-surface-800/95 backdrop-blur-xl rounded-2xl border border-white/8 max-w-lg w-full mx-4 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-star text-amber-400 text-sm"></i></div>
                <h2 class="text-lg font-bold text-white">Add Testimonial</h2>
            </div>
            <button onclick="document.getElementById('testimonial-modal').style.display='none'" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-white/30 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form action="{{ route('admin.cms.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Client Name *</label><input type="text" name="client_name" class="input-field" required placeholder="John Doe"></div>
                <div><label class="label">Company</label><input type="text" name="company" class="input-field" placeholder="Company Inc."></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="label">Position</label><input type="text" name="position" class="input-field" placeholder="CEO"></div>
                <div>
                    <label class="label">Rating *</label>
                    <select name="rating" class="input-field" required>
                        @for($i=5;$i>=1;$i--)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div><label class="label">Testimonial *</label><textarea name="content" rows="4" class="input-field" required placeholder="What did the client say..."></textarea></div>
            <div>
                <label class="label">Avatar</label>
                <input type="file" name="avatar" class="input-field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25" accept="image/*">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('testimonial-modal').style.display='none'" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Save Testimonial</button>
            </div>
        </form>
    </div>
</div>
@endsection
