@extends('layouts.app')
@section('title', 'ICodeDev - Build Your Dream App')
@section('has-particles', true)

@section('content')
{{-- ═══════════════════════════════════════════════════════════════
     HERO SECTION - Immersive dark with particles, orbit rings & terminal
     ═══════════════════════════════════════════════════════════════ --}}
<section data-dark-hero class="relative min-h-screen flex items-center bg-surface-950 text-white overflow-hidden">
    {{-- Aurora Background --}}
    <div class="aurora">
        <div class="aurora-blob w-175 h-175 bg-primary-600/25 top-[-15%] left-[-8%]"></div>
        <div class="aurora-blob w-150 h-150 bg-secondary-500/20 bottom-[-15%] right-[-8%]"></div>
        <div class="aurora-blob w-125 h-125 bg-accent-500/10 top-[40%] left-[30%]"></div>
    </div>

    {{-- Cyber Grid --}}
    <div class="absolute inset-0 cyber-grid opacity-40 pointer-events-none"></div>

    {{-- Orbit Rings --}}
    <div class="hidden lg:block absolute top-1/2 left-[65%] w-125 h-125 orbit-ring border-primary-500/10" style="animation-duration: 25s;">
        <div class="orbit-dot bg-primary-400 text-primary-400" style="top: 0; left: 50%;"></div>
    </div>
    <div class="hidden lg:block absolute top-1/2 left-[65%] w-87.5 h-87.5 orbit-ring border-secondary-500/10" style="animation-duration: 35s; animation-direction: reverse;">
        <div class="orbit-dot bg-secondary-400 text-secondary-400" style="bottom: 0; right: 0;"></div>
    </div>

    {{-- Scan Line --}}
    <div class="absolute inset-0 scan-line pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 lg:pt-40 lg:pb-28 relative w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="animate-on-scroll" data-delay="0">
                    <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8">
                        <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span></span>
                        Available for new projects
                    </span>
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black leading-[1.05] tracking-tight mb-8 animate-on-scroll" data-delay="100">
                    We Build<br>
                    <span class="text-shimmer">Digital Products</span><br>
                    That Matter
                </h1>
                <p class="text-lg sm:text-xl text-gray-400 mb-10 max-w-xl leading-relaxed animate-on-scroll" data-delay="200">
                    From stunning websites to powerful mobile apps and enterprise software — we turn bold ideas into world-class digital experiences.
                </p>
                <div class="flex flex-wrap gap-4 animate-on-scroll" data-delay="300">
                    <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-linear-to-r from-primary-600 to-primary-500 text-white font-semibold px-8 py-4 rounded-2xl shadow-xl shadow-primary-500/30 hover:shadow-2xl hover:shadow-primary-500/40 hover:scale-[1.03] transition-all duration-500 relative overflow-hidden">
                        Start Your Project
                        <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1.5"></i>
                        <span class="absolute inset-0 bg-linear-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
                    </a>
                    <a href="{{ route('portfolio') }}" class="magnetic btn-neon px-8 py-4 rounded-2xl">
                        <i class="fas fa-play text-xs"></i> View Our Work
                    </a>
                </div>

                {{-- Stats row --}}
                <div class="mt-16 grid grid-cols-3 gap-4 sm:gap-8 animate-on-scroll" data-delay="400">
                    <div data-count-suffix="+">
                        <div class="text-2xl sm:text-4xl font-black tracking-tight gradient-text" data-counter="150">0</div>
                        <div class="text-white/50 text-xs sm:text-sm mt-1.5 font-medium">Projects Shipped</div>
                    </div>
                    <div class="border-l border-white/8 pl-4 sm:pl-8" data-count-suffix="+">
                        <div class="text-2xl sm:text-4xl font-black tracking-tight gradient-text" data-counter="80">0</div>
                        <div class="text-white/50 text-xs sm:text-sm mt-1.5 font-medium">Happy Clients</div>
                    </div>
                    <div class="border-l border-white/8 pl-4 sm:pl-8">
                        <div class="text-2xl sm:text-4xl font-black tracking-tight gradient-text"><span data-counter="99">0</span>%</div>
                        <div class="text-white/50 text-xs sm:text-sm mt-1.5 font-medium">Satisfaction</div>
                    </div>
                </div>
            </div>

            {{-- Code Terminal with 3D tilt --}}
            <div class="hidden lg:block animate-on-scroll" data-delay="200" data-animate="right">
                <div class="tilt-card relative">
                    {{-- Glow effect --}}
                    <div class="absolute -inset-6 bg-linear-to-r from-primary-500/20 via-secondary-500/15 to-accent-500/20 rounded-4xl blur-3xl opacity-60 animate-gradient"></div>

                    <div class="relative glass-neon rounded-2xl overflow-hidden shadow-2xl">
                        {{-- Terminal header --}}
                        <div class="flex items-center gap-2 px-5 py-3.5 border-b border-white/6 bg-white/2">
                            <div class="w-3 h-3 bg-red-500 rounded-full hover:brightness-125 transition"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full hover:brightness-125 transition"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full hover:brightness-125 transition"></div>
                            <span class="ml-3 text-xs text-gray-500 font-mono">ICodeDev.php</span>
                            <span class="ml-auto text-[10px] text-gray-600 font-mono">UTF-8</span>
                        </div>
                        <div class="p-6">
                            <pre class="text-[13px] leading-relaxed text-gray-300 font-mono"><code><span class="text-purple-400">class</span> <span class="text-yellow-300">ICodeDev</span>
{
    <span class="text-blue-400">public function</span> <span class="text-green-300">buildDreamApp</span>(<span class="text-orange-300">$idea</span>)
    {
        <span class="text-orange-300">$design</span>  = <span class="text-blue-400">$this</span>-><span class="text-cyan-300">createUI</span>(<span class="text-orange-300">$idea</span>);
        <span class="text-orange-300">$code</span>    = <span class="text-blue-400">$this</span>-><span class="text-cyan-300">develop</span>(<span class="text-orange-300">$design</span>);
        <span class="text-orange-300">$app</span>     = <span class="text-blue-400">$this</span>-><span class="text-cyan-300">deploy</span>(<span class="text-orange-300">$code</span>);

        <span class="text-purple-400">return</span> <span class="text-orange-300">$app</span>
            -><span class="text-cyan-300">withQuality</span>(<span class="text-green-300">'world-class'</span>)
            -><span class="text-cyan-300">launch</span>();<span class="animate-pulse text-primary-400">|</span>
    }
}</code></pre>
                        </div>
                        {{-- Terminal footer --}}
                        <div class="px-5 py-2.5 border-t border-white/4 bg-white/1 flex items-center gap-3">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-[10px] text-gray-600 font-mono">Ready</span>
                            <span class="ml-auto text-[10px] text-gray-600 font-mono">PHP 8.4</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-gray-500 text-xs animate-on-scroll" data-delay="600">
        <span class="font-medium tracking-widest uppercase text-[10px]">Scroll</span>
        <div class="w-5 h-8 rounded-full border border-gray-600/60 flex items-start justify-center p-1.5">
            <div class="w-1 h-1.5 bg-primary-400 rounded-full animate-bounce"></div>
        </div>
    </div>
</section>

{{-- Client Logos --}}
@if(isset($clientLogos) && $clientLogos->count() > 0)
<section class="py-14 bg-surface-900/30 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-[11px] font-bold text-white/40 uppercase tracking-[0.2em] mb-10">Trusted by leading companies</p>
        <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-8">
            @foreach($clientLogos as $logo)
            <img src="{{ asset('storage/' . $logo->logo) }}" alt="{{ $logo->name }}" class="h-8 opacity-30 hover:opacity-100 transition-all duration-500 grayscale hover:grayscale-0 hover:scale-110">
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     SERVICES SECTION - With tilt cards and gradient icons
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-cubes text-xs"></i> What We Do</span>
            <h2 class="section-title mt-5">Services We <span class="gradient-text">Offer</span></h2>
            <p class="section-subtitle">End-to-end solutions from concept to deployment, built for scale.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($services as $service)
            <div class="group tilt-card card-hover p-8 animate-on-scroll">
                <div class="w-14 h-14 bg-linear-to-br from-primary-500/10 to-secondary-500/10 text-primary-500 rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:bg-linear-to-br group-hover:from-primary-600 group-hover:to-secondary-500 group-hover:text-white group-hover:shadow-xl group-hover:shadow-primary-500/30 group-hover:scale-110 transition-all duration-500">
                    <i class="fas fa-{{ $service->icon ?? 'code' }}"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-400 transition-colors duration-300">{{ $service->title }}</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-5">{{ $service->short_description }}</p>
                @if($service->technologies)
                <div class="flex flex-wrap gap-1.5 mb-5">
                    @foreach(array_slice($service->technologies, 0, 4) as $tech)
                    <span class="px-2.5 py-1 bg-white/5 text-white/50 rounded-lg text-xs font-medium border border-white/5">{{ $tech }}</span>
                    @endforeach
                </div>
                @endif
                <a href="{{ route('services.show', $service) }}" class="inline-flex items-center gap-1.5 text-primary-400 font-semibold text-sm hover:gap-3 transition-all duration-300">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @empty
            @foreach([
                ['icon' => 'globe', 'title' => 'Website Development', 'desc' => 'Custom websites built with modern technologies for performance and scalability.'],
                ['icon' => 'mobile-alt', 'title' => 'Mobile App Development', 'desc' => 'Native and cross-platform mobile apps for iOS and Android.'],
                ['icon' => 'desktop', 'title' => 'Desktop Software', 'desc' => 'Powerful desktop applications for Windows, macOS, and Linux.'],
                ['icon' => 'paint-brush', 'title' => 'UI/UX Design', 'desc' => 'Beautiful, intuitive interfaces that users love to interact with.'],
                ['icon' => 'plug', 'title' => 'API Development', 'desc' => 'Robust RESTful APIs that power your applications seamlessly.'],
                ['icon' => 'tools', 'title' => 'Maintenance & Support', 'desc' => 'Ongoing support to keep your software running smoothly.'],
            ] as $s)
            <div class="group tilt-card card-hover p-8 animate-on-scroll">
                <div class="w-14 h-14 bg-linear-to-br from-primary-500/10 to-secondary-500/10 text-primary-500 rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:bg-linear-to-br group-hover:from-primary-600 group-hover:to-secondary-500 group-hover:text-white group-hover:shadow-xl group-hover:shadow-primary-500/30 group-hover:scale-110 transition-all duration-500">
                    <i class="fas fa-{{ $s['icon'] }}"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-400 transition-colors duration-300">{{ $s['title'] }}</h3>
                <p class="text-white/50 text-sm leading-relaxed">{{ $s['desc'] }}</p>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PORTFOLIO PREVIEW - With filter animations
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-100 h-100 bg-primary-500/5 top-0 right-[-5%]"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-16 gap-6 animate-on-scroll">
            <div>
                <span class="section-label mb-5"><i class="fas fa-rocket text-xs"></i> Our Work</span>
                <h2 class="section-title mt-5">Featured <span class="gradient-text">Projects</span></h2>
                <p class="text-white/50 mt-3 max-w-lg">See how we've helped businesses build amazing digital products.</p>
            </div>
            <a href="{{ route('portfolio') }}" class="btn-primary shrink-0 magnetic">View All <i class="fas fa-arrow-right text-sm"></i></a>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($portfolios as $portfolio)
            <a href="{{ route('portfolio.show', $portfolio) }}" class="group card-hover animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/3">
                    <img src="{{ $portfolio->thumbnail_url }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-linear-to-t from-surface-950/80 via-surface-950/0 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6">
                        <span class="text-white text-sm font-medium flex items-center gap-2"><i class="fas fa-external-link-alt"></i> View Project</span>
                    </div>
                    <span class="absolute top-4 left-4 px-3.5 py-1.5 glass-dark rounded-lg text-xs font-bold text-white/90 shadow-lg">{{ $portfolio->category }}</span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-primary-400 transition-colors duration-300">{{ $portfolio->title }}</h3>
                    <p class="text-white/50 text-sm leading-relaxed">{{ Str::limit($portfolio->short_description, 80) }}</p>
                    @if($portfolio->technologies)
                    <div class="flex flex-wrap gap-1.5 mt-4">
                        @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                        <span class="px-2 py-0.5 bg-white/5 text-white/50 rounded text-xs font-medium">{{ $tech }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </a>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="card-hover animate-on-scroll">
                <div class="aspect-4/3 bg-linear-to-br from-primary-500/10 to-secondary-500/10 flex items-center justify-center relative overflow-hidden">
                    <i class="fas fa-image text-4xl text-white/20"></i>
                    <div class="absolute inset-0 bg-linear-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-white mb-2">Sample Project {{ $i + 1 }}</h3>
                    <p class="text-white/50 text-sm">A cutting-edge application built with modern technologies.</p>
                </div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     HOW WE WORK - Interactive process timeline
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-route text-xs"></i> Our Process</span>
            <h2 class="section-title mt-5">How We <span class="gradient-text">Work</span></h2>
            <p class="section-subtitle">A proven process that delivers results, on time and on budget.</p>
        </div>

        {{-- Timeline connector (desktop) --}}
        <div class="hidden lg:block relative mb-16">
            <div class="absolute top-10 left-[12.5%] right-[12.5%] h-px bg-linear-to-r from-primary-500/30 via-secondary-500/30 to-accent-500/30"></div>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
            @foreach([
                ['icon' => 'lightbulb', 'step' => '01', 'title' => 'Discovery', 'desc' => 'We learn about your goals, audience, and requirements to build the right solution.', 'color' => 'from-primary-500 to-primary-600'],
                ['icon' => 'pencil-ruler', 'step' => '02', 'title' => 'Design', 'desc' => 'Our designers create beautiful, intuitive interfaces that delight your users.', 'color' => 'from-secondary-500 to-secondary-600'],
                ['icon' => 'code', 'step' => '03', 'title' => 'Develop', 'desc' => 'Our engineers build robust, scalable software using best practices.', 'color' => 'from-neon-purple to-accent-500'],
                ['icon' => 'rocket', 'step' => '04', 'title' => 'Launch', 'desc' => 'We deploy, test, and optimize to ensure a flawless launch experience.', 'color' => 'from-neon-green to-emerald-600'],
            ] as $step)
            <div class="text-center group animate-on-scroll">
                <div class="relative inline-flex mb-8">
                    <div class="w-20 h-20 bg-linear-to-br {{ $step['color'] }} rounded-3xl flex items-center justify-center text-white text-2xl shadow-xl group-hover:shadow-2xl group-hover:scale-110 transition-all duration-500">
                        <i class="fas fa-{{ $step['icon'] }}"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 w-8 h-8 bg-white text-surface-900 text-xs font-black rounded-xl flex items-center justify-center shadow-lg border-2 border-surface-800">{{ $step['step'] }}</span>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-400 transition-colors">{{ $step['title'] }}</h3>
                <p class="text-white/50 text-sm leading-relaxed max-w-xs mx-auto">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIALS - Glass card slider
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-125 h-100 bg-primary-500/5 bottom-[-10%] left-[-5%]"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-heart text-xs"></i> Testimonials</span>
            <h2 class="section-title mt-5">What Our Clients <span class="gradient-text">Say</span></h2>
        </div>
        <div id="testimonial-slider" class="max-w-3xl mx-auto">
            @forelse($testimonials as $testimonial)
            <div class="testimonial-slide {{ $loop->first ? '' : 'hidden' }}">
                <div class="card-glass p-10 sm:p-14 text-center relative">
                    {{-- Gradient border glow --}}
                    <div class="absolute -inset-px rounded-2xl bg-linear-to-br from-primary-500/20 via-transparent to-secondary-500/20 pointer-events-none"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-linear-to-br from-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 shadow-lg shadow-primary-500/25">
                            <i class="fas fa-quote-right text-xl"></i>
                        </div>
                        <div class="text-amber-400 text-sm mb-6 flex items-center justify-center gap-1">
                            @for($i = 0; $i < $testimonial->rating; $i++) <i class="fas fa-star"></i> @endfor
                        </div>
                        <blockquote class="text-lg sm:text-xl text-white/70 leading-relaxed mb-8 font-medium">"{{ $testimonial->content }}"</blockquote>
                        <div class="flex items-center justify-center gap-4">
                            @if($testimonial->client_avatar)
                            <img src="{{ asset('storage/' . $testimonial->client_avatar) }}" class="w-12 h-12 rounded-full object-cover ring-3 ring-primary-500/30 shadow-lg">
                            @else
                            <div class="w-12 h-12 bg-linear-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">{{ substr($testimonial->client_name, 0, 1) }}</div>
                            @endif
                            <div class="text-left">
                                <div class="font-bold text-white">{{ $testimonial->client_name }}</div>
                                <div class="text-sm text-white/50">{{ $testimonial->client_position }}{{ $testimonial->client_company ? ', ' . $testimonial->client_company : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card-glass p-10 sm:p-14 text-center">
                <div class="w-14 h-14 bg-linear-to-br from-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-6 shadow-lg shadow-primary-500/25">
                    <i class="fas fa-quote-right text-xl"></i>
                </div>
                <div class="text-amber-400 text-sm mb-6 flex items-center justify-center gap-1">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <blockquote class="text-lg sm:text-xl text-white/70 leading-relaxed mb-8 font-medium">"ICodeDev delivered an exceptional application that exceeded all our expectations. Professional, timely, and outstanding quality!"</blockquote>
                <div class="font-bold text-white">Happy Client</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TEAM SECTION - Meet the builders
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-users text-xs"></i> Our Team</span>
            <h2 class="section-title mt-5">Meet the <span class="gradient-text">Builders</span></h2>
            <p class="section-subtitle">Talented developers, designers, and strategists behind every project.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-16">
            @forelse($teamMembers as $member)
            <div class="group card-hover text-center animate-on-scroll">
                <div class="relative overflow-hidden aspect-4/5">
                    @if($member->avatar)
                    <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full bg-linear-to-br from-primary-500/20 to-secondary-500/20 flex items-center justify-center">
                        <span class="text-5xl font-black text-white/20">{{ substr($member->name, 0, 1) }}</span>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-linear-to-t from-surface-950 via-surface-950/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-6">
                        <div class="flex gap-3">
                            @if($member->social_links)
                                @foreach(collect($member->social_links)->take(3) as $platform => $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-primary-500 hover:scale-110 transition-all duration-300">
                                    <i class="fab fa-{{ $platform }} text-sm"></i>
                                </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <h4 class="font-bold text-white group-hover:text-primary-400 transition-colors">{{ $member->name }}</h4>
                    <p class="text-primary-400/70 text-sm font-medium">{{ $member->position }}</p>
                </div>
            </div>
            @empty
            @foreach([
                ['name' => 'Emmanuel A.', 'role' => 'CEO & Lead Developer', 'initial' => 'E'],
                ['name' => 'Sarah J.', 'role' => 'Project Manager', 'initial' => 'S'],
                ['name' => 'Ada N.', 'role' => 'UI/UX Designer', 'initial' => 'A'],
                ['name' => 'James O.', 'role' => 'Senior Developer', 'initial' => 'J'],
            ] as $t)
            <div class="group card-hover text-center animate-on-scroll">
                <div class="aspect-4/5 bg-linear-to-br from-primary-500/20 to-secondary-500/20 flex items-center justify-center">
                    <span class="text-5xl font-black text-white/20">{{ $t['initial'] }}</span>
                </div>
                <div class="p-5">
                    <h4 class="font-bold text-white">{{ $t['name'] }}</h4>
                    <p class="text-primary-400/70 text-sm font-medium">{{ $t['role'] }}</p>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        {{-- Stats Counter --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 animate-on-scroll">
            @foreach([
                ['icon' => 'fa-project-diagram', 'value' => $stats['projects'] ?? 150, 'suffix' => '+', 'label' => 'Projects Completed', 'color' => 'from-primary-500 to-primary-600'],
                ['icon' => 'fa-users', 'value' => $stats['clients'] ?? 80, 'suffix' => '+', 'label' => 'Happy Clients', 'color' => 'from-secondary-500 to-secondary-600'],
                ['icon' => 'fa-user-tie', 'value' => $stats['team'] ?? 25, 'suffix' => '+', 'label' => 'Team Members', 'color' => 'from-accent-500 to-accent-600'],
                ['icon' => 'fa-calendar-check', 'value' => $stats['years'] ?? 2, 'suffix' => '+', 'label' => 'Years of Experience', 'color' => 'from-emerald-500 to-emerald-600'],
            ] as $stat)
            <div class="card-hover p-6 lg:p-8 text-center group">
                <div class="w-14 h-14 bg-linear-to-br {{ $stat['color'] }} rounded-2xl flex items-center justify-center text-white text-xl mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:shadow-xl transition-all duration-500">
                    <i class="fas {{ $stat['icon'] }}"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-black text-white tracking-tight mb-1" data-count-suffix="{{ $stat['suffix'] }}">
                    <span data-counter="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}
                </div>
                <p class="text-white/50 text-sm font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 text-primary-400 font-semibold hover:text-primary-500 hover:gap-3 transition-all duration-300">
                More about our team <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PRICING HIGHLIGHTS - Glass cards with glow
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-tag text-xs"></i> Pricing</span>
            <h2 class="section-title mt-5">Transparent <span class="gradient-text">Pricing</span></h2>
            <p class="section-subtitle">Choose the perfect plan for your project. No hidden fees.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
            @forelse($packages as $package)
            <div class="relative group animate-on-scroll {{ $package->is_popular ? 'md:-mt-4 md:-mb-4' : '' }}">
                @if($package->is_popular)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-full text-xs font-bold shadow-lg shadow-primary-600/30"><i class="fas fa-fire text-amber-300"></i> Most Popular</span>
                </div>
                @endif
                <div class="{{ $package->is_popular ? 'card-glow border-2 border-primary-500 shadow-xl shadow-primary-600/10' : 'card-hover' }} h-full p-8 lg:p-10 text-center">
                    <h3 class="text-xl font-black text-white mb-2 mt-2">{{ $package->name }}</h3>
                    <p class="text-white/50 text-sm mb-8">{{ $package->description }}</p>
                    <div class="mb-8">
                        <span class="text-5xl font-black gradient-text">{{ $cs }}{{ number_format($package->price) }}</span>
                        @if($package->billing_cycle !== 'one-time')
                        <span class="text-white/40 text-sm font-medium">/{{ $package->billing_cycle }}</span>
                        @endif
                    </div>
                    @if($package->features)
                    <ul class="text-left space-y-3 mb-10">
                        @foreach($package->features as $feature)
                        <li class="flex items-start gap-3 text-sm text-white/60">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i><span>{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    <a href="{{ route('contact') }}" class="{{ $package->is_popular ? 'btn-primary' : 'btn-secondary' }} w-full py-3 magnetic">Get Started</a>
                </div>
            </div>
            @empty
            @foreach([
                ['name' => 'Basic', 'price' => 150000, 'desc' => 'Perfect for small businesses', 'features' => ['5 Pages Website', 'Responsive Design', 'Basic SEO', 'Contact Form', '1 Month Support']],
                ['name' => 'Standard', 'price' => 400000, 'popular' => true, 'desc' => 'Best for growing companies', 'features' => ['Up to 15 Pages', 'Custom Design', 'Advanced SEO', 'CMS Integration', 'Payment Integration', '3 Months Support']],
                ['name' => 'Premium', 'price' => 800000, 'desc' => 'For enterprise solutions', 'features' => ['Unlimited Pages', 'Custom Features', 'Full SEO Suite', 'Admin Dashboard', 'API Development', '6 Months Support']],
            ] as $pkg)
            <div class="relative group animate-on-scroll {{ isset($pkg['popular']) ? 'md:-mt-4 md:-mb-4' : '' }}">
                @if(isset($pkg['popular']))
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-full text-xs font-bold shadow-lg shadow-primary-600/30"><i class="fas fa-fire text-amber-300"></i> Most Popular</span>
                </div>
                @endif
                <div class="{{ isset($pkg['popular']) ? 'card-glow border-2 border-primary-500 shadow-xl shadow-primary-600/10' : 'card-hover' }} h-full p-8 lg:p-10 text-center">
                    <h3 class="text-xl font-black text-white mb-2 mt-2">{{ $pkg['name'] }}</h3>
                    <p class="text-white/50 text-sm mb-8">{{ $pkg['desc'] }}</p>
                    <div class="mb-8"><span class="text-5xl font-black gradient-text">{{ $cs }}{{ number_format($pkg['price']) }}</span></div>
                    <ul class="text-left space-y-3 mb-10">
                        @foreach($pkg['features'] as $f)
                        <li class="flex items-start gap-3 text-sm text-white/60"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i><span>{{ $f }}</span></li>
                        @endforeach
                    </ul>
                    <a href="{{ route('contact') }}" class="{{ isset($pkg['popular']) ? 'btn-primary' : 'btn-secondary' }} w-full py-3 magnetic">Get Started</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
        <div class="text-center mt-12 animate-on-scroll">
            <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 text-primary-400 font-semibold hover:text-primary-500 hover:gap-3 transition-all duration-300">
                View all pricing options <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TECHNOLOGY STACK - Infinite scrolling marquee
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-20 bg-surface-900/30 border-y border-white/5 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="text-center animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-layer-group text-xs"></i> Tech Stack</span>
            <h2 class="section-title mt-5">Technologies We <span class="gradient-text">Master</span></h2>
        </div>
    </div>
    <div class="relative">
        <div class="absolute left-0 top-0 bottom-0 w-32 bg-linear-to-r from-surface-950 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-32 bg-linear-to-l from-surface-950 to-transparent z-10 pointer-events-none"></div>
        <div class="flex gap-8 animate-marquee">
            @foreach(['Laravel', 'React', 'Vue.js', 'Flutter', 'Node.js', 'Python', 'PHP', 'TypeScript', 'Next.js', 'Tailwind CSS', 'PostgreSQL', 'MySQL', 'MongoDB', 'Redis', 'Docker', 'AWS', 'Firebase', 'GraphQL', 'Electron', 'C#/.NET'] as $tech)
            <div class="shrink-0 px-8 py-4 glass rounded-2xl border border-white/6 flex items-center gap-3 hover:border-primary-500/30 hover:bg-primary-500/5 transition-all duration-300">
                <span class="text-white/70 font-semibold text-sm whitespace-nowrap">{{ $tech }}</span>
            </div>
            @endforeach
            @foreach(['Laravel', 'React', 'Vue.js', 'Flutter', 'Node.js', 'Python', 'PHP', 'TypeScript', 'Next.js', 'Tailwind CSS', 'PostgreSQL', 'MySQL', 'MongoDB', 'Redis', 'Docker', 'AWS', 'Firebase', 'GraphQL', 'Electron', 'C#/.NET'] as $tech)
            <div class="shrink-0 px-8 py-4 glass rounded-2xl border border-white/6 flex items-center gap-3 hover:border-primary-500/30 hover:bg-primary-500/5 transition-all duration-300">
                <span class="text-white/70 font-semibold text-sm whitespace-nowrap">{{ $tech }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     WHY CHOOSE US - Differentiators with icons
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-28 lg:py-36 bg-surface-950 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-20 animate-on-scroll">
            <span class="section-label mb-5"><i class="fas fa-trophy text-xs"></i> Why Us</span>
            <h2 class="section-title mt-5">Why Choose <span class="gradient-text">ICodeDev</span></h2>
            <p class="section-subtitle">What sets us apart from the rest.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach([
                ['icon' => 'fas fa-bolt', 'title' => 'Lightning Fast Delivery', 'desc' => 'We deliver projects on time with an agile workflow that ensures rapid iteration and quick turnarounds without compromising quality.', 'color' => 'text-amber-400', 'bg' => 'from-amber-500/10 to-amber-600/10'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Enterprise Security', 'desc' => 'Every application is built with security-first principles — OWASP standards, encrypted data, and regular vulnerability assessments.', 'color' => 'text-emerald-400', 'bg' => 'from-emerald-500/10 to-emerald-600/10'],
                ['icon' => 'fas fa-expand-arrows-alt', 'title' => 'Scalable Architecture', 'desc' => 'We build for growth. Our solutions handle millions of users with clean, modular architecture that scales effortlessly.', 'color' => 'text-primary-400', 'bg' => 'from-primary-500/10 to-primary-600/10'],
                ['icon' => 'fas fa-headset', 'title' => '24/7 Dedicated Support', 'desc' => 'Our team is always available. Get priority support, bug fixes, and ongoing maintenance to keep your product running smoothly.', 'color' => 'text-secondary-400', 'bg' => 'from-secondary-500/10 to-secondary-600/10'],
                ['icon' => 'fas fa-hand-holding-usd', 'title' => 'Transparent Pricing', 'desc' => 'No hidden fees or surprise charges. Clear milestones, detailed invoices, and a payment structure that works for your budget.', 'color' => 'text-accent-400', 'bg' => 'from-accent-500/10 to-accent-600/10'],
                ['icon' => 'fas fa-chart-line', 'title' => 'Proven Track Record', 'desc' => 'Over 150+ projects delivered successfully with a 99% client satisfaction rate. We let our work speak for itself.', 'color' => 'text-neon-green', 'bg' => 'from-emerald-500/10 to-neon-green/10'],
            ] as $feature)
            <div class="group card-hover p-8 animate-on-scroll">
                <div class="w-14 h-14 bg-linear-to-br {{ $feature['bg'] }} {{ $feature['color'] }} rounded-2xl flex items-center justify-center mb-6 text-xl group-hover:scale-110 transition-all duration-500">
                    <i class="{{ $feature['icon'] }}"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-3 group-hover:text-primary-400 transition-colors duration-300">{{ $feature['title'] }}</h3>
                <p class="text-white/50 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     CTA SECTION - Dark with aurora and glowing text
     ═══════════════════════════════════════════════════════════════ --}}
<section class="relative py-28 lg:py-36 bg-surface-950 text-white overflow-hidden">
    {{-- Aurora --}}
    <div class="aurora">
        <div class="aurora-blob w-150 h-125 bg-primary-600/20 top-[-10%] left-[10%]"></div>
        <div class="aurora-blob w-125 h-100 bg-secondary-500/15 bottom-[-10%] right-[10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-accent-500/10 top-[20%] right-[20%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-30 pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative animate-on-scroll">
        <span class="inline-flex items-center gap-2 px-5 py-2 glass-neon rounded-full text-sm font-medium mb-8">
            <i class="fas fa-sparkles text-amber-400"></i> Let's Work Together
        </span>
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight mb-6">Ready to Build Something<br><span class="text-shimmer">Amazing?</span></h2>
        <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto">Let's turn your idea into reality. Get a free project estimate — no strings attached.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" class="magnetic group inline-flex items-center gap-2.5 bg-white text-surface-900 font-bold px-8 py-4 rounded-2xl hover:bg-gray-100 shadow-xl hover:shadow-2xl transition-all duration-500 hover:scale-[1.03]">
                <i class="fas fa-paper-plane"></i> Get Free Quote
                <i class="fas fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="https://wa.me/2347038024207" target="_blank" rel="noopener noreferrer" class="magnetic inline-flex items-center gap-2.5 bg-linear-to-r from-emerald-600 to-emerald-500 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-emerald-500/30 hover:shadow-2xl hover:shadow-emerald-500/40 transition-all duration-500 hover:scale-[1.03]">
                <i class="fab fa-whatsapp text-lg"></i> Chat on WhatsApp
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     LATEST BLOG POSTS
     ═══════════════════════════════════════════════════════════════ --}}
@if(isset($posts) && $posts->count() > 0)
<section class="py-28 lg:py-36 bg-surface-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-16 gap-6 animate-on-scroll">
            <div>
                <span class="section-label mb-5"><i class="fas fa-pen-nib text-xs"></i> Blog</span>
                <h2 class="section-title mt-5">Latest <span class="gradient-text">Articles</span></h2>
                <p class="text-white/50 mt-3">Insights, tutorials, and news from our team.</p>
            </div>
            <a href="{{ route('blog') }}" class="btn-secondary shrink-0 magnetic">View All <i class="fas fa-arrow-right text-sm"></i></a>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post) }}" class="group card-hover animate-on-scroll">
                <div class="aspect-16/10 overflow-hidden">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 text-xs text-gray-400 font-medium mb-3">
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                        <span class="w-1 h-1 bg-primary-400 rounded-full"></span>
                        <span>{{ $post->read_time }} min read</span>
                    </div>
                    <h3 class="text-lg font-bold text-white group-hover:text-primary-400 transition-colors duration-300 mb-2 leading-snug">{{ $post->title }}</h3>
                    <p class="text-white/50 text-sm leading-relaxed">{{ Str::limit($post->excerpt, 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
