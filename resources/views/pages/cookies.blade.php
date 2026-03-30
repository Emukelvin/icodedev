@extends('layouts.app')
@section('title', 'Cookies Policy - ICodeDev')
@section('content')

{{-- Hero --}}
<section data-dark-hero class="relative bg-surface-950 text-white overflow-hidden pt-32 pb-20">
    <div class="aurora">
        <div class="aurora-blob w-125 h-125 bg-secondary-500/20 top-[-20%] right-[-10%]"></div>
        <div class="aurora-blob w-100 h-100 bg-primary-600/15 bottom-[-20%] left-[-10%]"></div>
    </div>
    <div class="absolute inset-0 cyber-grid opacity-20 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <nav class="flex items-center gap-2 text-sm text-white/40 mb-10 animate-on-scroll">
            <a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors">Home</a>
            <i class="fas fa-chevron-right text-white/20 text-xs"></i>
            <span class="text-white/70">Cookies Policy</span>
        </nav>
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Cookies <span class="gradient-text">Policy</span></h1>
        <p class="text-lg text-white/50">Last updated: {{ now()->format('F d, Y') }}</p>
    </div>
</section>

<section class="py-20 lg:py-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-invert prose-p:text-white/60 prose-headings:text-white prose-strong:text-white prose-li:text-white/60 prose-a:text-primary-400 max-w-none space-y-12">

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-cookie-bite text-amber-400"></i> What Are Cookies?</h2>
                <p>Cookies are small text files stored on your device when you visit our website. They help us provide a better experience by remembering your preferences, understanding how you use our site, and enabling certain features.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-cog text-primary-400"></i> Essential Cookies</h2>
                <p>These cookies are necessary for the website to function properly:</p>
                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left py-3 px-4 text-white/80">Cookie</th>
                                <th class="text-left py-3 px-4 text-white/80">Purpose</th>
                                <th class="text-left py-3 px-4 text-white/80">Duration</th>
                            </tr>
                        </thead>
                        <tbody class="text-white/60">
                            <tr class="border-b border-white/5">
                                <td class="py-3 px-4 font-mono text-xs">XSRF-TOKEN</td>
                                <td class="py-3 px-4">Cross-site request forgery protection</td>
                                <td class="py-3 px-4">2 hours</td>
                            </tr>
                            <tr class="border-b border-white/5">
                                <td class="py-3 px-4 font-mono text-xs">icodedev_session</td>
                                <td class="py-3 px-4">Session management and authentication</td>
                                <td class="py-3 px-4">2 hours</td>
                            </tr>
                            <tr class="border-b border-white/5">
                                <td class="py-3 px-4 font-mono text-xs">remember_web_*</td>
                                <td class="py-3 px-4">Remember me functionality</td>
                                <td class="py-3 px-4">5 years</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-chart-bar text-secondary-400"></i> Analytics Cookies</h2>
                <p>We use analytics cookies to understand how visitors interact with our website:</p>
                <ul>
                    <li>Page views and navigation patterns</li>
                    <li>Traffic sources and referral data</li>
                    <li>Device and browser information</li>
                    <li>Geographic location (country level)</li>
                </ul>
                <p>This data is aggregated and anonymized. We do not use it to identify individual visitors.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-sliders-h text-emerald-400"></i> Preference Cookies</h2>
                <p>These cookies remember your preferences and choices:</p>
                <ul>
                    <li>Language and region settings</li>
                    <li>Theme preferences (dark/light mode)</li>
                    <li>Cookie consent choices</li>
                    <li>Dashboard layout preferences</li>
                </ul>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-toggle-on text-accent-400"></i> Managing Cookies</h2>
                <p>You can control cookies through your browser settings:</p>
                <ul>
                    <li><strong>Chrome:</strong> Settings → Privacy and Security → Cookies</li>
                    <li><strong>Firefox:</strong> Settings → Privacy & Security → Cookies</li>
                    <li><strong>Safari:</strong> Preferences → Privacy → Cookies</li>
                    <li><strong>Edge:</strong> Settings → Cookies and Site Permissions</li>
                </ul>
                <p>Please note that disabling essential cookies may affect website functionality.</p>
            </div>

            <div class="card-hover p-8 lg:p-10 animate-on-scroll">
                <h2 class="flex items-center gap-3"><i class="fas fa-envelope text-primary-400"></i> Contact</h2>
                <p>For questions about our cookie practices, contact us at:</p>
                <p><strong>Email:</strong> <a href="mailto:hello@icodedev.com">hello@icodedev.com</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
