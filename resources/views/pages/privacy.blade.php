@extends('layouts.app')
@section('title', 'Privacy Policy - ICodeDev')
@section('content')

{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden pt-32 pb-20">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-primary-600/20 top-[-20%] right-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-secondary-500/15 bottom-[-20%] left-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="flex items-center gap-2 text-sm text-white/40 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-white/20 text-xs"></i>
            <span class="text-white/70">Privacy Policy</span>
        </nav>
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Privacy <span class="gradient-text">Policy</span></h1>
        <p class="text-lg text-white/50">Last updated: {{ now()->format('F d, Y') }}</p>
    </div>
</section>

<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-invert prose-p:text-white/60 prose-headings:text-white prose-strong:text-white prose-li:text-white/60 prose-a:text-primary-400 max-w-none space-y-12">

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-shield-alt text-primary-400"></i> Information We Collect</h2>
                <p>We collect information you provide directly, including:</p>
                <ul>
                    <li><strong>Personal Information:</strong> Name, email address, phone number, and company details when you contact us, register, or use our services.</li>
                    <li><strong>Project Information:</strong> Requirements, files, and communications related to your projects.</li>
                    <li><strong>Payment Information:</strong> Billing details processed securely through third-party payment providers (Paystack, Flutterwave).</li>
                    <li><strong>Usage Data:</strong> Browser type, IP address, pages visited, and interaction data collected automatically.</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-bullseye text-secondary-400"></i> How We Use Your Information</h2>
                <ul>
                    <li>To provide, maintain, and improve our services</li>
                    <li>To communicate about projects, updates, and support</li>
                    <li>To process payments and send invoices</li>
                    <li>To send newsletters and promotional content (with your consent)</li>
                    <li>To analyze website usage and improve user experience</li>
                    <li>To comply with legal obligations</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-lock text-emerald-400"></i> Data Security</h2>
                <p>We implement industry-standard security measures to protect your data, including:</p>
                <ul>
                    <li>SSL/TLS encryption for all data transmission</li>
                    <li>Secure password hashing with bcrypt</li>
                    <li>Regular security audits and vulnerability assessments</li>
                    <li>Role-based access control for project data</li>
                    <li>Encrypted backups stored in secure cloud infrastructure</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-share-alt text-amber-400"></i> Data Sharing</h2>
                <p>We do not sell your personal information. We may share data with:</p>
                <ul>
                    <li><strong>Service Providers:</strong> Payment processors, hosting providers, and analytics tools</li>
                    <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                    <li><strong>Business Transfers:</strong> In connection with any merger or acquisition</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-user-check text-accent-400"></i> Your Rights</h2>
                <p>You have the right to:</p>
                <ul>
                    <li>Access, correct, or delete your personal data</li>
                    <li>Withdraw consent for marketing communications</li>
                    <li>Request a copy of your data in a portable format</li>
                    <li>Object to data processing in certain circumstances</li>
                </ul>
                <p>To exercise these rights, contact us at <a href="mailto:{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}">{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}</a>.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-envelope text-primary-400"></i> Contact Us</h2>
                <p>If you have questions about this Privacy Policy, contact us at:</p>
                <p><strong>Email:</strong> <a href="mailto:{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}">{{ $siteSettings['contact_email'] ?? config('mail.from.address') }}</a><br>
                @if($siteSettings['contact_phone'] ?? false)<strong>Phone:</strong> {{ $siteSettings['contact_phone'] }}<br>@endif
                @if($siteSettings['contact_address'] ?? false)<strong>Address:</strong> {{ $siteSettings['contact_address'] }}@endif</p>
            </div>
        </div>
    </div>
</section>
@endsection
