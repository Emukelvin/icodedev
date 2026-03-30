@extends('layouts.app')
@section('title', 'Terms of Service - ICodeDev')
@section('content')

{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden pt-32 pb-20">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] left-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-accent-500/15 bottom-[-20%] right-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="flex items-center gap-2 text-sm text-white/40 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-white/20 text-xs"></i>
            <span class="text-white/70">Terms of Service</span>
        </nav>
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Terms of <span class="gradient-text">Service</span></h1>
        <p class="text-lg text-white/50">Last updated: {{ now()->format('F d, Y') }}</p>
    </div>
</section>

<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-invert prose-p:text-white/60 prose-headings:text-white prose-strong:text-white prose-li:text-white/60 prose-a:text-primary-400 max-w-none space-y-12">

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-file-contract text-primary-400"></i> Agreement to Terms</h2>
                <p>By accessing or using ICodeDev's website and services, you agree to be bound by these Terms of Service. If you do not agree, please do not use our services.</p>
                <p>These terms apply to all visitors, users, and clients who access or use our platform and services.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-laptop-code text-secondary-400"></i> Services</h2>
                <p>ICodeDev provides professional technology services including:</p>
                <ul>
                    <li>Web Development & Design</li>
                    <li>Mobile Application Development</li>
                    <li>UI/UX Design</li>
                    <li>Desktop Software Development</li>
                    <li>API Development & Integration</li>
                    <li>Cloud & DevOps Solutions</li>
                </ul>
                <p>Each project is governed by a separate project agreement or statement of work that details scope, timelines, and deliverables.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-credit-card text-emerald-400"></i> Payments & Billing</h2>
                <ul>
                    <li>Payment terms are specified in each project agreement or invoice</li>
                    <li>An initial deposit (typically 40-50%) is required before project commencement</li>
                    <li>Final payment is due upon project completion and delivery</li>
                    <li>Late payments may incur additional charges as specified in the project agreement</li>
                    <li>All prices are in the currency stated on the invoice</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-copyright text-amber-400"></i> Intellectual Property</h2>
                <ul>
                    <li>Upon full payment, clients receive full ownership of custom code and designs created specifically for their project</li>
                    <li>ICodeDev retains the right to use project screenshots in portfolios unless otherwise agreed</li>
                    <li>Third-party components (libraries, frameworks, assets) remain under their respective licenses</li>
                    <li>Pre-existing ICodeDev tools, frameworks, and templates remain our property</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-user-shield text-accent-400"></i> Client Responsibilities</h2>
                <ul>
                    <li>Provide accurate and timely information, content, and feedback</li>
                    <li>Ensure all provided content does not infringe third-party rights</li>
                    <li>Maintain confidentiality of login credentials and access details</li>
                    <li>Respond to review requests within agreed timelines</li>
                    <li>Provide a secure and authorized environment for deployments</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-tools text-primary-400"></i> Warranty & Support</h2>
                <ul>
                    <li>We provide a 30-day warranty period after project delivery for bug fixes</li>
                    <li>Ongoing maintenance and support are available under separate agreements</li>
                    <li>We do not guarantee uninterrupted or error-free service for hosted solutions</li>
                    <li>Scope changes after project approval may incur additional costs</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-ban text-red-400"></i> Limitation of Liability</h2>
                <p>ICodeDev shall not be liable for any indirect, incidental, special, or consequential damages arising from the use of our services. Our total liability shall not exceed the total amount paid by the client for the specific project in question.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-envelope text-primary-400"></i> Contact</h2>
                <p>For questions about these Terms, contact us at:</p>
                <p><strong>Email:</strong> <a href="mailto:hello@icodedev.com">hello@icodedev.com</a><br>
                <strong>Phone:</strong> +234 703 802 4207</p>
            </div>
        </div>
    </div>
</section>
@endsection
