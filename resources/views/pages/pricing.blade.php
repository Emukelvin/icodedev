@extends('layouts.app')
@section('title', 'Pricing - ICodeDev')
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
            <span class="text-white">Pricing</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8"><i class="fas fa-tags text-primary-400 text-xs"></i> Transparent Pricing</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6">Plans That <span class="text-shimmer">Scale</span></h1>
            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">Choose a package that suits your needs or request a custom quote for your unique project.</p>
        </div>
    </div>
</section>

<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
            @forelse($packages as $package)
            <div class="relative group animate-on-scroll {{ $package->is_popular ? 'md:-mt-4 md:-mb-4' : '' }}">
                @if($package->is_popular)
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-full text-xs font-bold shadow-lg shadow-primary-600/30"><i class="fas fa-fire text-amber-300"></i> Most Popular</span>
                </div>
                @endif
                <div class="{{ $package->is_popular ? 'card-glow' : 'card-hover' }} h-full p-8 lg:p-10 text-center {{ $package->is_popular ? 'border-2 border-primary-500 shadow-xl shadow-primary-600/10' : '' }}">
                    <h3 class="text-xl font-black text-white mb-2">{{ $package->name }}</h3>
                    <p class="text-white/50 text-sm mb-8">{{ $package->description }}</p>
                    <div class="mb-8">
                        <span class="text-5xl font-black gradient-text">{{ $cs }}{{ number_format($package->price) }}</span>
                        @if($package->billing_cycle !== 'one-time')<span class="text-white/40 text-sm font-medium">/{{ $package->billing_cycle }}</span>@endif
                    </div>
                    @if($package->features)
                    <ul class="text-left space-y-3 mb-10">
                        @foreach($package->features as $feature)
                        <li class="flex items-start gap-3 text-sm text-white/60"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i><span>{{ $feature }}</span></li>
                        @endforeach
                    </ul>
                    @endif
                    <a href="{{ route('contact') }}" class="{{ $package->is_popular ? 'btn-primary' : 'btn-secondary' }} w-full py-3 magnetic">Get Started</a>
                </div>
            </div>
            @empty
            @foreach([
                ['name' => 'Basic', 'price' => 150000, 'desc' => 'Perfect for small businesses and landing pages', 'features' => ['Up to 5 Pages', 'Responsive Design', 'Contact Form', 'Basic SEO Setup', 'Social Media Integration', '1 Month Support']],
                ['name' => 'Standard', 'price' => 400000, 'popular' => true, 'desc' => 'Great for growing businesses with custom needs', 'features' => ['Up to 15 Pages', 'Custom Design', 'CMS Integration', 'Payment Integration', 'Email Notifications', 'Analytics Dashboard', 'API Integration', '3 Months Support']],
                ['name' => 'Premium', 'price' => 800000, 'desc' => 'Full-scale enterprise solutions', 'features' => ['Unlimited Pages', 'Custom Application', 'Advanced Security', 'Admin Dashboard', 'Real-time Features', 'Performance Optimization', 'API Development', '6 Months Support', 'Priority Support']],
            ] as $i => $pkg)
            <div class="relative group animate-on-scroll {{ isset($pkg['popular']) ? 'md:-mt-4 md:-mb-4' : '' }}">
                @if(isset($pkg['popular']))
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-linear-to-r from-primary-600 to-primary-500 text-white rounded-full text-xs font-bold shadow-lg shadow-primary-600/30"><i class="fas fa-fire text-amber-300"></i> Most Popular</span>
                </div>
                @endif
                <div class="{{ isset($pkg['popular']) ? 'card-glow' : 'card-hover' }} h-full p-8 lg:p-10 text-center {{ isset($pkg['popular']) ? 'border-2 border-primary-500 shadow-xl shadow-primary-600/10' : '' }}">
                    <h3 class="text-xl font-black text-white mb-2">{{ $pkg['name'] }}</h3>
                    <p class="text-white/50 text-sm mb-8">{{ $pkg['desc'] }}</p>
                    <div class="mb-8"><span class="text-5xl font-black gradient-text">{{ $cs }}{{ number_format($pkg['price']) }}</span></div>
                    <ul class="text-left space-y-3 mb-10">
                        @foreach($pkg['features'] as $f)<li class="flex items-start gap-3 text-sm text-white/60"><i class="fas fa-check-circle text-emerald-500 mt-0.5"></i><span>{{ $f }}</span></li>@endforeach
                    </ul>
                    <a href="{{ route('contact') }}" class="{{ isset($pkg['popular']) ? 'btn-primary' : 'btn-secondary' }} w-full py-3 magnetic">Get Started</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- Feature Comparison Table --}}
<section class="py-28 lg:py-36 bg-surface-900/30 relative overflow-hidden">
    <div class="aurora">
        <div class="aurora-blob w-100 h-100 bg-primary-500/10 top-[-20%] right-[-10%]"></div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-14 animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8 mx-auto"><i class="fas fa-table text-primary-400 text-xs"></i> Feature Matrix</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-5">Compare <span class="gradient-text">Plans</span></h2>
            <p class="text-white/50 max-w-xl mx-auto">See what's included in each package at a glance.</p>
        </div>
        <div class="card-hover overflow-hidden animate-on-scroll">
            <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-surface-900/50">
                        <th class="text-left py-4 px-6 font-bold text-white/70">Feature</th>
                        <th class="text-center py-4 px-4 font-bold text-white/70">Basic</th>
                        <th class="text-center py-4 px-4 font-bold text-primary-400 bg-primary-500/5">Standard</th>
                        <th class="text-center py-4 px-4 font-bold text-white/70">Premium</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach([
                        ['Number of Pages', 'Up to 5', 'Up to 15', 'Unlimited'],
                        ['Custom Design', false, true, true],
                        ['Responsive/Mobile', true, true, true],
                        ['SEO Optimization', 'Basic', 'Advanced', 'Full Suite'],
                        ['CMS Integration', false, true, true],
                        ['Payment Integration', false, true, true],
                        ['Admin Dashboard', false, false, true],
                        ['API Development', false, false, true],
                        ['Email Notifications', false, true, true],
                        ['Analytics Dashboard', false, true, true],
                        ['Real-time Features', false, false, true],
                        ['Performance Optimization', false, false, true],
                        ['Support Duration', '1 month', '3 months', '6 months'],
                        ['Priority Support', false, false, true],
                        ['Source Code Access', true, true, true],
                    ] as $row)
                    <tr class="hover:bg-white/5 transition-all duration-500">
                        <td class="py-3.5 px-6 font-medium text-white/70">{{ $row[0] }}</td>
                        @for($i = 1; $i <= 3; $i++)
                        <td class="py-3.5 px-4 text-center {{ $i === 2 ? 'bg-primary-500/5' : '' }}">
                            @if(is_bool($row[$i]))
                                @if($row[$i]) <i class="fas fa-check-circle text-emerald-500"></i> @else <i class="fas fa-minus text-white/20"></i> @endif
                            @else
                                <span class="text-white/60 font-medium">{{ $row[$i] }}</span>
                            @endif
                        </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</section>

{{-- Custom Quote --}}
<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-14 animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8 mx-auto"><i class="fas fa-file-invoice text-primary-400 text-xs"></i> Custom Quote</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-5">Need Something <span class="gradient-text">Specific</span>?</h2>
            <p class="text-white/50 max-w-xl mx-auto">Tell us about your project and we'll craft a tailored proposal.</p>
        </div>
        <form action="{{ route('quote.submit') }}" method="POST" class="card-hover p-8 lg:p-10 space-y-6 animate-on-scroll">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="label">Name *</label><input type="text" name="name" required class="input-field" value="{{ old('name', auth()->user()->name ?? '') }}"></div>
                <div><label class="label">Email *</label><input type="email" name="email" required class="input-field" value="{{ old('email', auth()->user()->email ?? '') }}"></div>
                <div><label class="label">Phone</label><input type="tel" name="phone" class="input-field" value="{{ old('phone') }}"></div>
                <div><label class="label">Company</label><input type="text" name="company" class="input-field" value="{{ old('company') }}"></div>
            </div>
            <div>
                <label class="label">Service Type *</label>
                <select name="service_type" required class="input-field">
                    <option value="">Select Service</option>
                    @foreach($services as $service)<option value="{{ $service->title }}">{{ $service->title }}</option>@endforeach
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label class="label">Project Description *</label>
                <textarea name="project_description" rows="5" required class="input-field" placeholder="Describe your project in detail...">{{ old('project_description') }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="label">Estimated Budget ({{ $cs }})</label><input type="number" name="estimated_budget" class="input-field" placeholder="e.g., 500000"></div>
                <div><label class="label">Timeline</label>
                    <select name="timeline" class="input-field">
                        <option value="">Select</option>
                        <option value="ASAP">ASAP</option>
                        <option value="1-2 weeks">1-2 weeks</option>
                        <option value="1 month">1 month</option>
                        <option value="2-3 months">2-3 months</option>
                        <option value="Flexible">Flexible</option>
                    </select>
                </div>
            </div>
            <div style="position:absolute;left:-9999px;"><input type="text" name="website_url" tabindex="-1" autocomplete="off"></div>
            @include('partials.recaptcha')
            <button type="submit" class="btn-primary w-full py-4 text-base magnetic"><i class="fas fa-paper-plane mr-2"></i>Submit Quote Request</button>
        </form>
    </div>
</section>
@endsection
