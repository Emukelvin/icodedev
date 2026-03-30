@extends('layouts.app')
@section('title', 'AI Project Estimator - ICodeDev')
@section('meta_description', 'Get an instant AI-powered estimate for your software project. Calculate costs for websites, mobile apps, and desktop software.')
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
            <span class="text-white">Estimator</span>
        </nav>
        <div class="max-w-3xl animate-on-scroll">
            <span class="inline-flex items-center gap-2.5 px-5 py-2.5 glass-neon rounded-full text-sm font-medium mb-8"><i class="fas fa-robot text-primary-400 text-xs"></i> AI-Powered Estimator</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6">Build Your <span class="text-shimmer">Dream App</span></h1>
            <p class="text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">Answer a few questions and get an instant cost estimate for your project. Our AI-powered calculator considers complexity, features, and timeline.</p>
        </div>
    </div>
</section>

<section class="py-28 lg:py-36 relative">
    <div class="absolute inset-0 cyber-grid opacity-15 pointer-events-none"></div>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        {{-- Progress Bar --}}
        <div class="mb-12 animate-on-scroll">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-bold text-white/70">Step <span id="current-step">1</span> of 5</span>
                <span class="text-sm font-medium text-white/40" id="progress-text">20%</span>
            </div>
            <div class="w-full bg-white/5 rounded-full h-2.5 overflow-hidden">
                <div id="progress-bar" class="bg-linear-to-r from-primary-600 to-secondary-500 h-2.5 rounded-full transition-all duration-500" style="width: 20%"></div>
            </div>
        </div>

        <div class="card-hover p-8 md:p-12 animate-on-scroll">
            {{-- Step 1: Project Type --}}
            <div class="estimator-step" data-step="1">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-br from-primary-500/10 to-primary-500/5 text-primary-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">What type of project?</h2>
                    <p class="text-white/50 text-sm">Select the type of software you want to build.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    @foreach([
                        ['value' => 'website', 'icon' => 'globe', 'title' => 'Website', 'desc' => 'Web app, e-commerce, SaaS platform'],
                        ['value' => 'mobile', 'icon' => 'mobile-alt', 'title' => 'Mobile App', 'desc' => 'iOS, Android, or cross-platform'],
                        ['value' => 'desktop', 'icon' => 'desktop', 'title' => 'Desktop App', 'desc' => 'Windows, macOS, or Linux software'],
                    ] as $type)
                    <label class="cursor-pointer">
                        <input type="radio" name="project_type" value="{{ $type['value'] }}" class="hidden peer">
                        <div class="card-hover p-6 text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 peer-checked:ring-2 peer-checked:ring-primary-500/30 hover:border-primary-500/30 transition-all duration-500">
                            <div class="w-12 h-12 bg-white/5 text-white/50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-xl transition-all duration-500">
                                <i class="fas fa-{{ $type['icon'] }}"></i>
                            </div>
                            <h3 class="font-bold text-white mb-1">{{ $type['title'] }}</h3>
                            <p class="text-xs text-white/50">{{ $type['desc'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Step 2: Complexity --}}
            <div class="estimator-step hidden" data-step="2">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-br from-secondary-500/10 to-secondary-500/5 text-secondary-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">Project Complexity</h2>
                    <p class="text-white/50 text-sm">How complex is your project?</p>
                </div>
                <div class="space-y-3">
                    @foreach([
                        ['value' => 'simple', 'title' => 'Simple', 'desc' => '3-5 pages/screens, basic features, contact forms, static content', 'price' => $cs . '150,000 - ' . $cs . '300,000'],
                        ['value' => 'medium', 'title' => 'Medium', 'desc' => '6-15 pages/screens, user authentication, CMS, basic API integration', 'price' => $cs . '300,000 - ' . $cs . '600,000'],
                        ['value' => 'complex', 'title' => 'Complex', 'desc' => '15+ pages/screens, payment integration, real-time features, admin panel', 'price' => $cs . '600,000 - ' . $cs . '1,500,000'],
                        ['value' => 'enterprise', 'title' => 'Enterprise', 'desc' => 'Large-scale system, multiple integrations, high availability, custom architecture', 'price' => $cs . '1,500,000+'],
                    ] as $level)
                    <label class="cursor-pointer block">
                        <input type="radio" name="complexity" value="{{ $level['value'] }}" class="hidden peer">
                        <div class="card-hover p-5 flex items-center gap-4 peer-checked:border-primary-500 peer-checked:bg-primary-500/10 peer-checked:ring-2 peer-checked:ring-primary-500/30 hover:border-primary-500/30 transition-all duration-500">
                            <div class="flex-1">
                                <h3 class="font-bold text-white">{{ $level['title'] }}</h3>
                                <p class="text-xs text-white/50 mt-0.5">{{ $level['desc'] }}</p>
                            </div>
                            <span class="px-3 py-1.5 bg-linear-to-r from-primary-500/10 to-primary-500/5 text-primary-400 rounded-lg text-xs font-bold whitespace-nowrap">{{ $level['price'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Step 3: Features --}}
            <div class="estimator-step hidden" data-step="3">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-br from-amber-500/10 to-amber-500/5 text-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">Select Features</h2>
                    <p class="text-white/50 text-sm">Choose the features you need (select all that apply).</p>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    @foreach([
                        ['value' => 'auth', 'label' => 'User Authentication', 'price' => 50000, 'icon' => 'lock'],
                        ['value' => 'payment', 'label' => 'Payment Integration', 'price' => 80000, 'icon' => 'credit-card'],
                        ['value' => 'admin', 'label' => 'Admin Dashboard', 'price' => 100000, 'icon' => 'tachometer-alt'],
                        ['value' => 'cms', 'label' => 'Content Management', 'price' => 70000, 'icon' => 'edit'],
                        ['value' => 'api', 'label' => 'API Integration', 'price' => 60000, 'icon' => 'plug'],
                        ['value' => 'realtime', 'label' => 'Real-time Features', 'price' => 90000, 'icon' => 'bolt'],
                        ['value' => 'notifications', 'label' => 'Push Notifications', 'price' => 40000, 'icon' => 'bell'],
                        ['value' => 'analytics', 'label' => 'Analytics Dashboard', 'price' => 60000, 'icon' => 'chart-bar'],
                        ['value' => 'search', 'label' => 'Advanced Search', 'price' => 40000, 'icon' => 'search'],
                        ['value' => 'multilang', 'label' => 'Multi-language', 'price' => 50000, 'icon' => 'language'],
                        ['value' => 'chat', 'label' => 'Chat/Messaging', 'price' => 80000, 'icon' => 'comments'],
                        ['value' => 'file_upload', 'label' => 'File Upload System', 'price' => 40000, 'icon' => 'cloud-upload-alt'],
                    ] as $feature)
                    <label class="cursor-pointer block">
                        <input type="checkbox" name="features[]" value="{{ $feature['value'] }}" data-price="{{ $feature['price'] }}" class="hidden peer">
                        <div class="card-hover p-4 flex items-center gap-3 peer-checked:border-primary-500 peer-checked:bg-primary-500/10 peer-checked:ring-2 peer-checked:ring-primary-500/30 hover:border-primary-500/30 transition-all duration-500">
                            <div class="w-10 h-10 bg-white/5 text-white/40 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fas fa-{{ $feature['icon'] }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="font-semibold text-white text-sm block">{{ $feature['label'] }}</span>
                                <span class="text-xs text-white/40">+{{ $cs }}{{ number_format($feature['price']) }}</span>
                            </div>
                            <div class="w-5 h-5 border-2 border-white/20 rounded-md flex items-center justify-center shrink-0 peer-checked:bg-primary-500 peer-checked:border-primary-500 transition-all duration-300">
                                <i class="fas fa-check text-white text-[10px]"></i>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Step 4: Design & Timeline --}}
            <div class="estimator-step hidden" data-step="4">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-br from-emerald-500/10 to-emerald-500/5 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">Design & Timeline</h2>
                    <p class="text-white/50 text-sm">Choose your design level and preferred timeline.</p>
                </div>

                <div class="mb-8">
                    <h3 class="font-bold text-white mb-3 text-sm uppercase tracking-wider">Design Quality</h3>
                    <div class="space-y-3">
                        @foreach([
                            ['value' => 'template', 'title' => 'Template-Based', 'desc' => 'Pre-built templates with customization', 'multiplier' => '1.0'],
                            ['value' => 'custom', 'title' => 'Custom Design', 'desc' => 'Unique design by professional designers', 'multiplier' => '1.5'],
                            ['value' => 'premium', 'title' => 'Premium Brand Design', 'desc' => 'Full branding + UI/UX research + prototyping', 'multiplier' => '2.0'],
                        ] as $design)
                        <label class="cursor-pointer block">
                            <input type="radio" name="design" value="{{ $design['value'] }}" data-multiplier="{{ $design['multiplier'] }}" class="hidden peer">
                            <div class="card-hover p-4 flex items-center gap-4 peer-checked:border-primary-500 peer-checked:bg-primary-500/10 peer-checked:ring-2 peer-checked:ring-primary-500/30 hover:border-primary-500/30 transition-all duration-500">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-white text-sm">{{ $design['title'] }}</h4>
                                    <p class="text-xs text-white/50 mt-0.5">{{ $design['desc'] }}</p>
                                </div>
                                <span class="px-2.5 py-1 bg-white/5 text-white/60 rounded-lg text-xs font-bold">&times;{{ $design['multiplier'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-white mb-3 text-sm uppercase tracking-wider">Timeline</h3>
                    <div class="space-y-3">
                        @foreach([
                            ['value' => 'relaxed', 'title' => 'Relaxed (2-3 months)', 'desc' => 'Standard delivery, no rush', 'multiplier' => '1.0'],
                            ['value' => 'standard', 'title' => 'Standard (1-2 months)', 'desc' => 'Normal pace delivery', 'multiplier' => '1.2'],
                            ['value' => 'rush', 'title' => 'Rush (2-4 weeks)', 'desc' => 'Expedited delivery', 'multiplier' => '1.5'],
                            ['value' => 'urgent', 'title' => 'Urgent (Under 2 weeks)', 'desc' => 'Priority team assignment', 'multiplier' => '2.0'],
                        ] as $timeline)
                        <label class="cursor-pointer block">
                            <input type="radio" name="timeline" value="{{ $timeline['value'] }}" data-multiplier="{{ $timeline['multiplier'] }}" class="hidden peer">
                            <div class="card-hover p-4 flex items-center gap-4 peer-checked:border-primary-500 peer-checked:bg-primary-500/10 peer-checked:ring-2 peer-checked:ring-primary-500/30 hover:border-primary-500/30 transition-all duration-500">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-white text-sm">{{ $timeline['title'] }}</h4>
                                    <p class="text-xs text-white/50 mt-0.5">{{ $timeline['desc'] }}</p>
                                </div>
                                <span class="px-2.5 py-1 bg-white/5 text-white/60 rounded-lg text-xs font-bold">&times;{{ $timeline['multiplier'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Step 5: Estimate Result --}}
            <div class="estimator-step hidden" data-step="5">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-linear-to-br from-emerald-500/10 to-emerald-500/5 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">Your Project Estimate</h2>
                    <p class="text-white/50 text-sm">Here's your AI-powered cost estimate.</p>
                </div>

                <div class="relative bg-surface-950 text-white rounded-2xl p-10 text-center mb-8 overflow-hidden">
                    <div class="aurora">
                        <div class="aurora-blob w-50 h-50 bg-primary-600/30 top-[-30%] right-[-10%]"></div>
                        <div class="aurora-blob w-40 h-40 bg-secondary-500/20 bottom-[-20%] left-[-5%]"></div>
                    </div>
                    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
                    <div class="relative">
                        <p class="text-gray-400 text-xs uppercase tracking-[0.2em] font-bold mb-3">Estimated Project Cost</p>
                        <div class="text-5xl sm:text-6xl font-black mb-2 gradient-text" id="estimate-amount">{{ $cs }}0</div>
                        <p class="text-white/50 text-sm" id="estimate-range">Range: {{ $cs }}0 - {{ $cs }}0</p>
                    </div>
                </div>

                <div id="estimate-breakdown" class="card-hover p-6 mb-8">
                    <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Cost Breakdown</h3>
                    <div class="space-y-3" id="breakdown-items"></div>
                    <div class="border-t border-white/5 mt-4 pt-4 flex justify-between font-bold text-lg">
                        <span>Total Estimate</span>
                        <span id="breakdown-total" class="gradient-text">{{ $cs }}0</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="card-hover p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-linear-to-br from-blue-500/10 to-blue-500/5 text-blue-400 rounded-xl flex items-center justify-center"><i class="fas fa-clock"></i></div>
                            <div>
                                <p class="text-xs text-white/40 font-bold">Estimated Duration</p>
                                <p class="font-bold text-white" id="estimate-duration">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-hover p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-linear-to-br from-emerald-500/10 to-emerald-500/5 text-emerald-400 rounded-xl flex items-center justify-center"><i class="fas fa-users"></i></div>
                            <div>
                                <p class="text-xs text-white/40 font-bold">Team Size</p>
                                <p class="font-bold text-white" id="estimate-team">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('contact') }}" class="btn-primary py-4 w-full block text-center text-base magnetic"><i class="fas fa-paper-plane mr-2"></i>Request Exact Quote</a>
                    <button onclick="resetEstimator()" class="btn-secondary w-full magnetic"><i class="fas fa-redo mr-2"></i>Start Over</button>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex justify-between mt-10 pt-6 border-t border-white/5" id="step-navigation">
                <button id="prev-step" class="btn-secondary hidden magnetic"><i class="fas fa-arrow-left mr-2"></i>Previous</button>
                <div class="flex-1"></div>
                <button id="next-step" class="btn-primary magnetic">Next Step <i class="fas fa-arrow-right ml-2"></i></button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    let step = 1;
    const totalSteps = 5;
    const steps = document.querySelectorAll('.estimator-step');
    const prevBtn = document.getElementById('prev-step');
    const nextBtn = document.getElementById('next-step');
    const progressBar = document.getElementById('progress-bar');
    const currentStepEl = document.getElementById('current-step');
    const progressText = document.getElementById('progress-text');

    const currencySymbol = '{{ $cs }}';
    const basePrices = { website: 150000, mobile: 250000, desktop: 200000 };
    const complexityMultipliers = { simple: 1, medium: 2, complex: 4, enterprise: 8 };

    function showStep(n) {
        steps.forEach(s => s.classList.add('hidden'));
        document.querySelector(`[data-step="${n}"]`).classList.remove('hidden');
        currentStepEl.textContent = n;
        const pct = (n / totalSteps) * 100;
        progressBar.style.width = pct + '%';
        progressText.textContent = Math.round(pct) + '%';
        prevBtn.classList.toggle('hidden', n === 1);
        if (n === totalSteps) {
            nextBtn.classList.add('hidden');
            calculateEstimate();
        } else {
            nextBtn.classList.remove('hidden');
            nextBtn.textContent = n === totalSteps - 1 ? 'Get Estimate' : 'Next Step';
            nextBtn.innerHTML = n === totalSteps - 1
                ? '<i class="fas fa-calculator mr-2"></i>Get Estimate'
                : 'Next Step <i class="fas fa-arrow-right ml-2"></i>';
        }
    }

    nextBtn.addEventListener('click', () => {
        if (step === 1 && !document.querySelector('input[name="project_type"]:checked')) {
            alert('Please select a project type.'); return;
        }
        if (step === 2 && !document.querySelector('input[name="complexity"]:checked')) {
            alert('Please select a complexity level.'); return;
        }
        if (step === 4) {
            if (!document.querySelector('input[name="design"]:checked')) {
                alert('Please select a design level.'); return;
            }
            if (!document.querySelector('input[name="timeline"]:checked')) {
                alert('Please select a timeline.'); return;
            }
        }
        if (step < totalSteps) { step++; showStep(step); }
    });

    prevBtn.addEventListener('click', () => {
        if (step > 1) { step--; showStep(step); }
    });

    window.resetEstimator = function() {
        step = 1;
        document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(i => i.checked = false);
        showStep(1);
    };

    function calculateEstimate() {
        const type = document.querySelector('input[name="project_type"]:checked')?.value || 'website';
        const complexity = document.querySelector('input[name="complexity"]:checked')?.value || 'simple';
        const design = document.querySelector('input[name="design"]:checked');
        const timeline = document.querySelector('input[name="timeline"]:checked');

        let base = basePrices[type] * complexityMultipliers[complexity];
        let featuresCost = 0;
        const selectedFeatures = [];

        document.querySelectorAll('input[name="features[]"]:checked').forEach(f => {
            const price = parseInt(f.dataset.price);
            featuresCost += price;
            selectedFeatures.push({ label: f.closest('label').querySelector('.font-medium').textContent, price });
        });

        let subtotal = base + featuresCost;
        const designMult = parseFloat(design?.dataset.multiplier || 1);
        const timelineMult = parseFloat(timeline?.dataset.multiplier || 1);
        let total = subtotal * designMult * timelineMult;

        const low = Math.round(total * 0.85);
        const high = Math.round(total * 1.15);
        total = Math.round(total);

        document.getElementById('estimate-amount').textContent = currencySymbol + total.toLocaleString();
        document.getElementById('estimate-range').textContent = `Range: ${currencySymbol}${low.toLocaleString()} - ${currencySymbol}${high.toLocaleString()}`;
        document.getElementById('breakdown-total').textContent = currencySymbol + total.toLocaleString();

        // Breakdown
        let html = `<div class="flex justify-between text-sm"><span class="text-white/60">Base (${type} / ${complexity})</span><span class="font-medium">${currencySymbol}${base.toLocaleString()}</span></div>`;
        selectedFeatures.forEach(f => {
            html += `<div class="flex justify-between text-sm"><span class="text-white/60">${f.label}</span><span class="font-medium">+${currencySymbol}${f.price.toLocaleString()}</span></div>`;
        });
        if (designMult > 1) html += `<div class="flex justify-between text-sm"><span class="text-white/60">Design multiplier</span><span class="font-medium">×${designMult}</span></div>`;
        if (timelineMult > 1) html += `<div class="flex justify-between text-sm"><span class="text-gray-600">Timeline multiplier</span><span class="font-medium">×${timelineMult}</span></div>`;
        document.getElementById('breakdown-items').innerHTML = html;

        // Duration & team
        const durations = { simple: '2-3 weeks', medium: '1-2 months', complex: '2-4 months', enterprise: '4-8 months' };
        const teams = { simple: '1-2 developers', medium: '2-3 developers', complex: '3-5 developers', enterprise: '5+ developers' };
        document.getElementById('estimate-duration').textContent = durations[complexity] || '-';
        document.getElementById('estimate-team').textContent = teams[complexity] || '-';
    }
});
</script>
@endpush
