@extends('layouts.app')
@section('title', 'FAQ - ICodeDev')
@section('content')

{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden pt-32 pb-20">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-accent-500/20 top-[-20%] left-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] right-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="flex items-center gap-2 text-sm text-white/40 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-white/20 text-xs"></i>
            <span class="text-white/70">FAQ</span>
        </nav>
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Frequently Asked <span class="gradient-text">Questions</span></h1>
        <p class="text-lg text-white/50">Everything you need to know about working with us</p>
    </div>
</section>

<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- General --}}
        <div class="mb-16 animate-on-scroll">
            <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-primary-500/20 flex items-center justify-center text-primary-400">
                    <i class="fas fa-info-circle"></i>
                </span>
                General
            </h2>
            <div class="space-y-4" x-data="{open: null}">
                @foreach([
                    ['What does ICodeDev do?', 'ICodeDev is a full-service technology company specializing in web development, mobile apps, desktop software, UI/UX design, API development, and cloud/DevOps solutions. We help businesses of all sizes build world-class digital products.'],
                    ['Where are you located?', 'We are based in Lagos, Nigeria, but we work with clients globally. Our team collaborates remotely to deliver projects across different time zones.'],
                    ['What industries do you work with?', 'We work across diverse industries including fintech, healthcare, e-commerce, education, logistics, real estate, and more. Our solutions are tailored to each industry\'s unique needs.'],
                    ['Do you offer free consultations?', 'Yes! We offer a free 30-minute discovery call to discuss your project requirements, timeline, and budget. Use our contact form or project estimator to get started.']
                ] as $index => $faq)
                <div class="card-hover overflow-hidden">
                    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-white pr-4">{{ $faq[0] }}</span>
                        <i class="fas fa-chevron-down text-primary-400 text-sm transition-transform duration-300" :class="open === {{ $index }} && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse x-cloak class="px-6 pb-6">
                        <p class="text-white/60 leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Process --}}
        <div class="mb-16 animate-on-scroll">
            <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-secondary-500/20 flex items-center justify-center text-secondary-400">
                    <i class="fas fa-cogs"></i>
                </span>
                Our Process
            </h2>
            <div class="space-y-4" x-data="{open: null}">
                @foreach([
                    ['What is your development process?', 'We follow an Agile methodology: Discovery & Planning → UI/UX Design → Development (in sprints) → Testing & QA → Deployment → Support. You\'ll have full visibility through your client dashboard with regular updates.'],
                    ['How long does a typical project take?', 'Timelines vary based on complexity. A simple website takes 2-4 weeks, a web application 6-12 weeks, and a mobile app 8-16 weeks. We provide accurate estimates after understanding your requirements.'],
                    ['How do you handle project communication?', 'Each client gets access to a dedicated dashboard for real-time project updates, file sharing, and messaging. We also conduct weekly stand-up calls and provide regular progress reports.'],
                    ['Can I make changes during development?', 'Absolutely. Our Agile approach accommodates change requests. We discuss the impact on timeline and budget, then integrate approved changes into the next sprint.']
                ] as $index => $faq)
                <div class="card-hover overflow-hidden">
                    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-white pr-4">{{ $faq[0] }}</span>
                        <i class="fas fa-chevron-down text-secondary-400 text-sm transition-transform duration-300" :class="open === {{ $index }} && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse x-cloak class="px-6 pb-6">
                        <p class="text-white/60 leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Pricing & Payment --}}
        <div class="mb-16 animate-on-scroll">
            <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <i class="fas fa-credit-card"></i>
                </span>
                Pricing & Payment
            </h2>
            <div class="space-y-4" x-data="{open: null}">
                @foreach([
                    ['How much do your services cost?', 'Our pricing depends on project complexity, features, and timeline. We offer three packages: Starter, Professional, and Enterprise (custom). Use our Project Estimator tool for an instant estimate.'],
                    ['What payment methods do you accept?', 'We accept bank transfers, Paystack, and Flutterwave. International clients can pay via wire transfer or online payment gateways.'],
                    ['What is your payment structure?', 'Typically 40-50% upfront, 30% at mid-project milestone, and the remaining balance upon delivery. Enterprise clients may negotiate custom payment schedules.'],
                    ['Do you offer refunds?', 'We offer partial refunds for work not yet started. Completed milestones are non-refundable. Full refund details are in our project agreements.']
                ] as $index => $faq)
                <div class="card-hover overflow-hidden">
                    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-white pr-4">{{ $faq[0] }}</span>
                        <i class="fas fa-chevron-down text-emerald-400 text-sm transition-transform duration-300" :class="open === {{ $index }} && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse x-cloak class="px-6 pb-6">
                        <p class="text-white/60 leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Support --}}
        <div class="mb-16 animate-on-scroll">
            <h2 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-accent-500/20 flex items-center justify-center text-accent-400">
                    <i class="fas fa-headset"></i>
                </span>
                Support & Maintenance
            </h2>
            <div class="space-y-4" x-data="{open: null}">
                @foreach([
                    ['Do you provide post-launch support?', 'Yes. Every project includes a 30-day warranty for bug fixes. We also offer monthly maintenance plans that include updates, security patches, backups, and priority support.'],
                    ['What if something breaks after launch?', 'During the 30-day warranty, we fix bugs at no extra cost. After that, bugs are covered under your maintenance plan or billed at our standard hourly rate.'],
                    ['Do you help with hosting and domain?', 'Absolutely. We help set up and manage hosting, domains, SSL certificates, and DNS configuration. We recommend and configure the best infrastructure for your project.'],
                    ['Can I hire you for ongoing development?', 'Yes! We offer dedicated developer arrangements and retainer agreements for clients who need ongoing development, feature additions, and technical support.']
                ] as $index => $faq)
                <div class="card-hover overflow-hidden">
                    <button @click="open === {{ $index }} ? open = null : open = {{ $index }}" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-white pr-4">{{ $faq[0] }}</span>
                        <i class="fas fa-chevron-down text-accent-400 text-sm transition-transform duration-300" :class="open === {{ $index }} && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === {{ $index }}" x-collapse x-cloak class="px-6 pb-6">
                        <p class="text-white/60 leading-relaxed">{{ $faq[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- CTA --}}
        <div class="card-hover p-10 lg:p-14 text-center animate-on-scroll">
            <h2 class="text-2xl lg:text-3xl font-bold text-white mb-4">Still Have Questions?</h2>
            <p class="text-white/50 mb-8 max-w-lg mx-auto">We're here to help. Reach out and our team will get back to you within 24 hours.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="btn-primary px-8 py-4 rounded-xl font-semibold">
                    <i class="fas fa-envelope mr-2"></i> Contact Us
                </a>
                <a href="{{ route('project.estimator') }}" class="btn-outline px-8 py-4 rounded-xl font-semibold">
                    <i class="fas fa-calculator mr-2"></i> Get an Estimate
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
