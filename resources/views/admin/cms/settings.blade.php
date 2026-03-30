@extends('layouts.dashboard')
@section('title', 'Site Settings - ICodeDev Admin')
@section('sidebar')@include('admin.partials.sidebar')@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-white">Site Settings</h1>
    <p class="text-sm text-white/50 mt-1">Configure global site settings — changes affect all public and dashboard pages</p>
</div>

{{-- Tab Navigation --}}
<div class="flex flex-wrap gap-2 mb-8" x-data="{tab: 'general'}">
    @foreach(['general' => 'General', 'contact' => 'Contact', 'social' => 'Social Media', 'seo' => 'SEO & Analytics', 'features' => 'Feature Toggles', 'content' => 'Content', 'payment' => 'Payment Methods', 'notifications' => 'Email Notifications', 'recaptcha' => 'reCAPTCHA', 'maintenance' => 'Maintenance'] as $key => $label)
    <button @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'bg-primary-600 text-white border-primary-600' : 'bg-white/4 text-white/50 border-white/6 hover:bg-white/8 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-semibold border transition-all duration-300">
        {{ $label }}
    </button>
    @endforeach

<form action="{{ route('admin.cms.settings.update') }}" method="POST" enctype="multipart/form-data" class="w-full mt-6">
    @csrf @method('PUT')

    {{-- GENERAL --}}
    <div x-show="tab === 'general'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">General Settings</h2>
            <p class="text-xs text-white/40 mb-6">Basic site identity and branding</p>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">Site Name</label><input type="text" name="settings[site_name]" class="input-field" value="{{ $settings['site_name'] ?? 'ICodeDev' }}"></div>
                <div><label class="label">Tagline</label><input type="text" name="settings[site_tagline]" class="input-field" value="{{ $settings['site_tagline'] ?? '' }}"></div>
            </div>
            <div class="mb-6"><label class="label">Site Description</label><textarea name="settings[site_description]" rows="3" class="input-field" placeholder="Brief description of your company">{{ $settings['site_description'] ?? '' }}</textarea></div>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="label">Logo</label>
                    @if(!empty($settings['logo_url']))
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $settings['logo_url'] }}" alt="Current Logo" class="h-10 rounded-lg bg-white/5 p-1">
                        <span class="text-xs text-white/40">Current logo</span>
                    </div>
                    @endif
                    <input type="file" name="logo_file" accept="image/*" class="input-field text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-primary-600 file:text-white hover:file:bg-primary-500 file:cursor-pointer">
                    <p class="text-xs text-white/30 mt-1">Recommended: PNG or SVG, max 2MB</p>
                </div>
                <div>
                    <label class="label">Favicon</label>
                    @if(!empty($settings['favicon_url']))
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $settings['favicon_url'] }}" alt="Current Favicon" class="h-8 w-8 rounded bg-white/5 p-1">
                        <span class="text-xs text-white/40">Current favicon</span>
                    </div>
                    @endif
                    <input type="file" name="favicon_file" accept="image/*,.ico" class="input-field text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-primary-600 file:text-white hover:file:bg-primary-500 file:cursor-pointer">
                    <p class="text-xs text-white/30 mt-1">Recommended: ICO or PNG 32x32, max 2MB</p>
                </div>
            </div>
            <div class="mb-6">
                <label class="label"><i class="fas fa-file-invoice text-primary-400 mr-2"></i>Invoice Logo</label>
                <p class="text-xs text-white/40 mb-3">This logo appears on client invoices and PDF downloads. If not set, the site logo above will be used.</p>
                @if(!empty($settings['invoice_logo']))
                <div class="mb-3 flex items-center gap-3 p-3 rounded-lg bg-white/3 border border-white/5 w-fit">
                    <img src="{{ $settings['invoice_logo'] }}" alt="Current Invoice Logo" class="h-12 rounded">
                    <span class="text-xs text-white/40">Current invoice logo</span>
                </div>
                @endif
                <input type="file" name="invoice_logo_file" accept="image/*" class="input-field text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-primary-600 file:text-white hover:file:bg-primary-500 file:cursor-pointer">
                <p class="text-xs text-white/30 mt-1">Recommended: PNG or SVG with transparent background, max 2MB</p>
            </div>
            <div class="mb-6">
                <label class="label"><i class="fas fa-envelope text-primary-400 mr-2"></i>Email Logo</label>
                <p class="text-xs text-white/40 mb-3">This logo appears at the top of all outgoing email notifications. If not set, the site logo will be used.</p>
                @if(!empty($settings['email_logo']))
                <div class="mb-3 flex items-center gap-3 p-3 rounded-lg bg-white/3 border border-white/5 w-fit">
                    <img src="{{ $settings['email_logo'] }}" alt="Current Email Logo" class="h-12 rounded">
                    <span class="text-xs text-white/40">Current email logo</span>
                </div>
                @endif
                <input type="file" name="email_logo_file" accept="image/*" class="input-field text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-primary-600 file:text-white hover:file:bg-primary-500 file:cursor-pointer">
                <p class="text-xs text-white/30 mt-1">Recommended: PNG with transparent background, 200px wide, max 2MB</p>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div><label class="label">Copyright Text</label><input type="text" name="settings[copyright_text]" class="input-field" value="{{ $settings['copyright_text'] ?? '' }}" placeholder="ICodeDev. All rights reserved."></div>
                <div x-data="{
                    currencies: [
                        { symbol: '₦', code: 'NGN', name: 'Nigerian Naira' },
                        { symbol: '$', code: 'USD', name: 'US Dollar' },
                        { symbol: '€', code: 'EUR', name: 'Euro' },
                        { symbol: '£', code: 'GBP', name: 'British Pound' },
                        { symbol: '₹', code: 'INR', name: 'Indian Rupee' },
                        { symbol: '¥', code: 'JPY', name: 'Japanese Yen' },
                        { symbol: '¥', code: 'CNY', name: 'Chinese Yuan' },
                        { symbol: 'R', code: 'ZAR', name: 'South African Rand' },
                        { symbol: 'KSh', code: 'KES', name: 'Kenyan Shilling' },
                        { symbol: 'GH₵', code: 'GHS', name: 'Ghanaian Cedi' },
                        { symbol: 'CFA', code: 'XOF', name: 'West African CFA Franc' },
                        { symbol: 'R$', code: 'BRL', name: 'Brazilian Real' },
                        { symbol: 'A$', code: 'AUD', name: 'Australian Dollar' },
                        { symbol: 'C$', code: 'CAD', name: 'Canadian Dollar' },
                        { symbol: 'Fr', code: 'CHF', name: 'Swiss Franc' },
                        { symbol: '₿', code: 'BTC', name: 'Bitcoin' }
                    ],
                    selected: '{{ $settings['currency_symbol'] ?? '₦' }}'
                }">
                    <label class="label">Currency</label>
                    <select name="settings[currency_symbol]" x-model="selected" class="input-field">
                        <template x-for="c in currencies" :key="c.code">
                            <option :value="c.symbol" :selected="c.symbol === selected" x-text="c.symbol + ' - ' + c.code + ' (' + c.name + ')'"></option>
                        </template>
                    </select>
                    <input type="hidden" name="settings[currency_code]" :value="currencies.find(c => c.symbol === selected)?.code ?? 'NGN'">
                    <p class="text-xs text-white/30 mt-1">Select the currency to display across the entire site</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTACT --}}
    <div x-show="tab === 'contact'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Contact Information</h2>
            <p class="text-xs text-white/40 mb-6">Displayed in footer, contact page, and public pages</p>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">Contact Email</label><input type="email" name="settings[contact_email]" class="input-field" value="{{ $settings['contact_email'] ?? '' }}"></div>
                <div><label class="label">Support Email</label><input type="email" name="settings[support_email]" class="input-field" value="{{ $settings['support_email'] ?? '' }}" placeholder="support@icodedev.com"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">Phone Number</label><input type="text" name="settings[contact_phone]" class="input-field" value="{{ $settings['contact_phone'] ?? '' }}"></div>
                <div><label class="label">WhatsApp Number</label><input type="text" name="settings[whatsapp_number]" class="input-field" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="+2347038024207"></div>
            </div>
            <div class="mb-6"><label class="label">Address</label><input type="text" name="settings[contact_address]" class="input-field" value="{{ $settings['contact_address'] ?? '' }}"></div>
            <div class="grid md:grid-cols-2 gap-6">
                <div><label class="label">Google Maps Embed URL</label><input type="url" name="settings[map_embed_url]" class="input-field" value="{{ $settings['map_embed_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?..."></div>
                <div><label class="label">Business Hours</label><input type="text" name="settings[business_hours]" class="input-field" value="{{ $settings['business_hours'] ?? '' }}" placeholder="Mon-Fri: 9AM - 6PM WAT"></div>
            </div>
        </div>
    </div>

    {{-- SOCIAL MEDIA --}}
    <div x-show="tab === 'social'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Social Media Links</h2>
            <p class="text-xs text-white/40 mb-6">Displayed in footer and about page social icons</p>
            <div class="grid md:grid-cols-2 gap-6">
                <div><label class="label"><i class="fab fa-facebook text-blue-500 mr-2"></i>Facebook</label><input type="url" name="settings[social_facebook]" class="input-field" value="{{ $settings['social_facebook'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-twitter text-sky-400 mr-2"></i>Twitter / X</label><input type="url" name="settings[social_twitter]" class="input-field" value="{{ $settings['social_twitter'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-instagram text-pink-500 mr-2"></i>Instagram</label><input type="url" name="settings[social_instagram]" class="input-field" value="{{ $settings['social_instagram'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-linkedin text-blue-400 mr-2"></i>LinkedIn</label><input type="url" name="settings[social_linkedin]" class="input-field" value="{{ $settings['social_linkedin'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-github text-white/70 mr-2"></i>GitHub</label><input type="url" name="settings[social_github]" class="input-field" value="{{ $settings['social_github'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-youtube text-red-500 mr-2"></i>YouTube</label><input type="url" name="settings[social_youtube]" class="input-field" value="{{ $settings['social_youtube'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-tiktok text-white/70 mr-2"></i>TikTok</label><input type="url" name="settings[social_tiktok]" class="input-field" value="{{ $settings['social_tiktok'] ?? '' }}"></div>
                <div><label class="label"><i class="fab fa-discord text-indigo-400 mr-2"></i>Discord</label><input type="url" name="settings[social_discord]" class="input-field" value="{{ $settings['social_discord'] ?? '' }}"></div>
            </div>
        </div>
    </div>

    {{-- SEO & ANALYTICS --}}
    <div x-show="tab === 'seo'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">SEO & Analytics</h2>
            <p class="text-xs text-white/40 mb-6">Search engine optimization and tracking</p>
            <div class="mb-6"><label class="label">Default Meta Description</label><textarea name="settings[meta_description]" rows="2" class="input-field" placeholder="Professional Web, Mobile & Desktop Software Development">{{ $settings['meta_description'] ?? '' }}</textarea></div>
            <div class="mb-6"><label class="label">Default Meta Keywords</label><input type="text" name="settings[meta_keywords]" class="input-field" value="{{ $settings['meta_keywords'] ?? '' }}" placeholder="web development, mobile app, Laravel, React, ICodeDev"></div>
            <div class="mb-6">
                <label class="label">OG Image</label>
                @if(!empty($settings['og_image']))
                <div class="mb-3 flex items-center gap-3">
                    <img src="{{ $settings['og_image'] }}" alt="Current OG Image" class="h-16 rounded-lg bg-white/5 p-1">
                    <span class="text-xs text-white/40">Current OG image</span>
                </div>
                @endif
                <input type="file" name="og_image_file" accept="image/*" class="input-field text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:bg-primary-600 file:text-white hover:file:bg-primary-500 file:cursor-pointer">
                <p class="text-xs text-white/30 mt-1">Recommended: 1200x630 PNG/JPG, max 2MB</p>
            </div>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">Google Analytics ID</label><input type="text" name="settings[google_analytics_id]" class="input-field" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX"></div>
                <div><label class="label">Google Tag Manager ID</label><input type="text" name="settings[gtm_id]" class="input-field" value="{{ $settings['gtm_id'] ?? '' }}" placeholder="GTM-XXXXXXX"></div>
            </div>
            <div class="mb-6"><label class="label">Head Scripts (analytics, pixels, etc.)</label><textarea name="settings[head_scripts]" rows="4" class="input-field font-mono text-xs" placeholder="<!-- Paste tracking scripts here -->">{{ $settings['head_scripts'] ?? '' }}</textarea></div>
            <div><label class="label">Footer Scripts</label><textarea name="settings[footer_scripts]" rows="4" class="input-field font-mono text-xs" placeholder="<!-- Paste footer scripts here -->">{{ $settings['footer_scripts'] ?? '' }}</textarea></div>
        </div>
    </div>

    {{-- FEATURE TOGGLES --}}
    <div x-show="tab === 'features'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Feature Toggles</h2>
            <p class="text-xs text-white/40 mb-6">Enable or disable site features across all pages</p>
            <div class="space-y-5">
                @foreach([
                    ['enable_blog', 'Blog Section', 'Show blog posts on homepage and enable the blog page'],
                    ['enable_portfolio', 'Portfolio Section', 'Show portfolio/projects on homepage and enable the portfolio page'],
                    ['enable_pricing', 'Pricing Section', 'Show pricing packages on homepage and enable the pricing page'],
                    ['enable_testimonials', 'Testimonials Section', 'Show client testimonials on homepage and about page'],
                    ['enable_team', 'Team Section', 'Show team members on homepage and about page'],
                    ['enable_newsletter', 'Newsletter Signup', 'Show newsletter subscription form in the footer'],
                    ['enable_whatsapp', 'WhatsApp Button', 'Show floating WhatsApp chat button on all pages'],
                    ['enable_scroll_progress', 'Scroll Progress Bar', 'Show the reading progress bar at the top of the page'],
                    ['enable_client_logos', 'Client Logos', 'Show trusted client logos section on homepage'],
                    ['enable_faq', 'FAQ Page', 'Enable the FAQ page link in the footer'],
                    ['enable_estimator', 'Project Estimator', 'Enable the project estimator tool'],
                    ['enable_registration', 'User Registration', 'Allow new users to register on the site'],
                ] as $toggle)
                <label class="flex items-start gap-4 p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 transition-all cursor-pointer group">
                    <div class="relative mt-0.5">
                        <input type="hidden" name="settings[{{ $toggle[0] }}]" value="0">
                        <input type="checkbox" name="settings[{{ $toggle[0] }}]" value="1" {{ ($settings[$toggle[0]] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-white/10 rounded-full peer-checked:bg-primary-600 transition-colors duration-300"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-300"></div>
                    </div>
                    <div>
                        <span class="font-semibold text-white text-sm">{{ $toggle[1] }}</span>
                        <p class="text-xs text-white/40 mt-0.5">{{ $toggle[2] }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div x-show="tab === 'content'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Homepage Content</h2>
            <p class="text-xs text-white/40 mb-6">Customize text displayed on the homepage hero and sections</p>
            <div class="mb-6"><label class="label">Hero Title</label><input type="text" name="settings[hero_title]" class="input-field" value="{{ $settings['hero_title'] ?? '' }}" placeholder="We Build Digital Products That Matter"></div>
            <div class="mb-6"><label class="label">Hero Subtitle</label><textarea name="settings[hero_subtitle]" rows="2" class="input-field" placeholder="From stunning websites to powerful mobile apps...">{{ $settings['hero_subtitle'] ?? '' }}</textarea></div>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">CTA Button Text</label><input type="text" name="settings[cta_button_text]" class="input-field" value="{{ $settings['cta_button_text'] ?? '' }}" placeholder="Start Your Project"></div>
                <div><label class="label">CTA Button URL</label><input type="text" name="settings[cta_button_url]" class="input-field" value="{{ $settings['cta_button_url'] ?? '' }}" placeholder="/contact"></div>
            </div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Footer Content</h2>
            <p class="text-xs text-white/40 mb-6">Customize footer text and tagline</p>
            <div class="mb-6"><label class="label">Footer Description</label><textarea name="settings[footer_description]" rows="2" class="input-field" placeholder="Building world-class websites, mobile apps, and enterprise software.">{{ $settings['footer_description'] ?? '' }}</textarea></div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Announcement Banner</h2>
            <p class="text-xs text-white/40 mb-6">Show a dismissible banner at the top of the site</p>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <label class="flex items-center gap-3">
                    <input type="hidden" name="settings[enable_announcement]" value="0">
                    <input type="checkbox" name="settings[enable_announcement]" value="1" {{ ($settings['enable_announcement'] ?? '0') === '1' ? 'checked' : '' }} class="w-4 h-4 rounded bg-white/10 border-white/20 text-primary-600 focus:ring-primary-500/30">
                    <span class="text-sm text-white font-medium">Enable Announcement Banner</span>
                </label>
            </div>
            <div><label class="label">Announcement Text</label><input type="text" name="settings[announcement_text]" class="input-field" value="{{ $settings['announcement_text'] ?? '' }}" placeholder="🚀 We just launched our new service! Check it out."></div>
        </div>
    </div>

    {{-- PAYMENT METHODS --}}
    <div x-show="tab === 'payment'" x-cloak>
        {{-- Payment Method Toggles --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Payment Method Toggles</h2>
            <p class="text-xs text-white/40 mb-6">Enable or disable payment methods available to clients</p>
            <div class="grid sm:grid-cols-2 gap-4">
                @foreach(['enable_paystack' => ['Paystack', 'fas fa-credit-card', 'Accept online payments via Paystack'], 'enable_flutterwave' => ['Flutterwave', 'fas fa-wallet', 'Accept online payments via Flutterwave'], 'enable_bank_transfer' => ['Bank Transfer', 'fas fa-university', 'Accept manual bank transfer payments'], 'enable_crypto' => ['Cryptocurrency', 'fab fa-bitcoin', 'Accept manual crypto payments']] as $key => [$label, $icon, $desc])
                <label class="flex items-start gap-4 p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 transition-all cursor-pointer">
                    <div class="relative mt-0.5">
                        <input type="hidden" name="settings[{{ $key }}]" value="0">
                        <input type="checkbox" name="settings[{{ $key }}]" value="1" {{ ($settings[$key] ?? '0') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-white/10 rounded-full peer-checked:bg-primary-600 transition-colors duration-300"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-300"></div>
                    </div>
                    <div>
                        <span class="font-semibold text-white text-sm"><i class="{{ $icon }} mr-2 text-primary-400"></i>{{ $label }}</span>
                        <p class="text-xs text-white/40 mt-0.5">{{ $desc }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Bank Transfer Details --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1"><i class="fas fa-university mr-2 text-primary-400"></i>Bank Transfer Details</h2>
            <p class="text-xs text-white/40 mb-6">Bank account details displayed to clients during payment</p>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div><label class="label">Bank Name</label><input type="text" name="settings[bank_name]" class="input-field" value="{{ $settings['bank_name'] ?? '' }}" placeholder="e.g. GTBank, Access Bank"></div>
                <div><label class="label">Account Name</label><input type="text" name="settings[bank_account_name]" class="input-field" value="{{ $settings['bank_account_name'] ?? '' }}" placeholder="e.g. ICodeDev Ltd"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div><label class="label">Account Number</label><input type="text" name="settings[bank_account_number]" class="input-field" value="{{ $settings['bank_account_number'] ?? '' }}" placeholder="e.g. 0123456789"></div>
                <div><label class="label">Sort Code / Routing Number</label><input type="text" name="settings[bank_sort_code]" class="input-field" value="{{ $settings['bank_sort_code'] ?? '' }}" placeholder="Optional"></div>
            </div>
            <div class="mt-6">
                <label class="label">Additional Bank Instructions</label>
                <textarea name="settings[bank_instructions]" rows="3" class="input-field" placeholder="e.g. Use your invoice number as payment reference...">{{ $settings['bank_instructions'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- Crypto Wallets Note --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1"><i class="fab fa-bitcoin mr-2 text-amber-400"></i>Cryptocurrency Wallets</h2>
            <p class="text-xs text-white/40 mb-4">Manage your crypto wallets separately</p>
            <a href="{{ route('admin.crypto-wallets.index') }}" class="btn-secondary"><i class="fas fa-external-link-alt mr-2"></i>Manage Crypto Wallets</a>
        </div>
    </div>

    {{-- EMAIL NOTIFICATIONS --}}
    <div x-show="tab === 'notifications'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1"><i class="fas fa-bell mr-2 text-primary-400"></i>Email Notification Settings</h2>
            <p class="text-xs text-white/40 mb-6">Enable or disable individual email notifications. Database notifications will still be recorded even if email is disabled.</p>

            <div class="space-y-4">
                @foreach([
                    'notify_welcome' => ['Welcome Email', 'Send a welcome email when a new user creates an account', 'fas fa-user-plus'],
                    'notify_invoice_sent' => ['Invoice Sent', 'Notify clients when a new invoice is generated', 'fas fa-file-invoice-dollar'],
                    'notify_payment_received' => ['Payment Receipt', 'Send payment confirmation email to clients after successful payment', 'fas fa-receipt'],
                    'notify_project_created' => ['Project Created', 'Notify clients when a new project is created for them', 'fas fa-project-diagram'],
                    'notify_project_status' => ['Project Status Changed', 'Notify clients when their project status is updated', 'fas fa-sync-alt'],
                    'notify_developer_assigned' => ['Developer Assigned', 'Notify clients when a development team is assigned to their project', 'fas fa-users'],
                    'notify_task_assigned' => ['Task Assigned', 'Notify developers when a new task is assigned to them', 'fas fa-tasks'],
                    'notify_task_updated' => ['Task Updates', 'Notify clients when a task status changes, comment is added, or file is uploaded', 'fas fa-clipboard-check'],
                    'notify_new_message' => ['New Message', 'Send email when a new message is received in a conversation', 'fas fa-comment-dots'],
                    'notify_contact_form' => ['Contact Form Confirmation', 'Send confirmation email to visitors who submit the contact form', 'fas fa-envelope'],
                    'notify_quote_request' => ['Quote Request Confirmation', 'Send confirmation email to visitors who submit a quote request', 'fas fa-calculator'],
                ] as $key => [$label, $description, $icon])
                <label class="flex items-start gap-4 p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 transition-all cursor-pointer">
                    <div class="relative mt-0.5">
                        <input type="hidden" name="settings[{{ $key }}]" value="0">
                        <input type="checkbox" name="settings[{{ $key }}]" value="1" {{ ($settings[$key] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-white/10 rounded-full peer-checked:bg-primary-600 transition-colors duration-300"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-300"></div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <i class="{{ $icon }} text-white/30 text-xs"></i>
                            <span class="font-semibold text-white text-sm">{{ $label }}</span>
                        </div>
                        <p class="text-xs text-white/40 mt-0.5">{{ $description }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RECAPTCHA --}}
    <div x-show="tab === 'recaptcha'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1"><i class="fas fa-shield-alt mr-2 text-green-400"></i>Google reCAPTCHA v2</h2>
            <p class="text-xs text-white/40 mb-6">Protect public forms (register, contact, quote request) from spam and bots using Google reCAPTCHA</p>

            <label class="flex items-start gap-4 p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 transition-all cursor-pointer mb-6">
                <div class="relative mt-0.5">
                    <input type="hidden" name="settings[recaptcha_enabled]" value="0">
                    <input type="checkbox" name="settings[recaptcha_enabled]" value="1" {{ ($settings['recaptcha_enabled'] ?? '0') === '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-white/10 rounded-full peer-checked:bg-green-600 transition-colors duration-300"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-300"></div>
                </div>
                <div>
                    <span class="font-semibold text-white text-sm">Enable reCAPTCHA</span>
                    <p class="text-xs text-white/40 mt-0.5">When enabled, reCAPTCHA will appear on registration, contact, and quote request forms</p>
                </div>
            </label>

            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                    <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Site Key</p>
                    <p class="text-sm text-white font-mono">{{ config('services.recaptcha.site_key') ? '••••••' . substr(config('services.recaptcha.site_key'), -6) : '' }}</p>
                    <p class="text-[10px] text-white/30 mt-1">{{ config('services.recaptcha.site_key') ? 'Configured in .env' : 'Not configured' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                    <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Secret Key</p>
                    <p class="text-sm text-white font-mono">{{ config('services.recaptcha.secret_key') ? '••••••' . substr(config('services.recaptcha.secret_key'), -6) : '' }}</p>
                    <p class="text-[10px] text-white/30 mt-1">{{ config('services.recaptcha.secret_key') ? 'Configured in .env' : 'Not configured' }}</p>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-blue-500/5 border border-blue-500/10">
                <p class="text-sm text-blue-300 font-semibold mb-2"><i class="fas fa-info-circle mr-2"></i>Setup Instructions</p>
                <ol class="text-xs text-white/50 space-y-1.5 list-decimal pl-4">
                    <li>Go to <a href="https://www.google.com/recaptcha/admin" target="_blank" class="text-primary-400 underline">Google reCAPTCHA Admin</a></li>
                    <li>Register a new site with <strong class="text-white/70">reCAPTCHA v2 "I'm not a robot" Checkbox</strong></li>
                    <li>Add your domain(s) to the allowed list</li>
                    <li>Add the following to your <code class="text-primary-400 bg-white/5 px-1.5 py-0.5 rounded">.env</code> file:</li>
                </ol>
                <div class="mt-3 p-3 rounded-lg bg-surface-900/80 border border-white/5 font-mono text-xs text-white/70">
                    <p>RECAPTCHA_SITE_KEY=your_site_key_here</p>
                    <p>RECAPTCHA_SECRET_KEY=your_secret_key_here</p>
                </div>
                <p class="text-xs text-white/40 mt-2"><i class="fas fa-lock mr-1 text-green-400/50"></i>Keys are stored securely in the .env file, not in the database</p>
            </div>
        </div>
    </div>

    {{-- MAINTENANCE --}}
    <div x-show="tab === 'maintenance'" x-cloak>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Maintenance Mode</h2>
            <p class="text-xs text-white/40 mb-6">Take the public site offline for maintenance (admin dashboard remains accessible)</p>
            <label class="flex items-start gap-4 p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 transition-all cursor-pointer mb-6">
                <div class="relative mt-0.5">
                    <input type="hidden" name="settings[maintenance_mode]" value="0">
                    <input type="checkbox" name="settings[maintenance_mode]" value="1" {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-white/10 rounded-full peer-checked:bg-red-600 transition-colors duration-300"></div>
                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow peer-checked:translate-x-5 transition-transform duration-300"></div>
                </div>
                <div>
                    <span class="font-semibold text-white text-sm">Enable Maintenance Mode</span>
                    <p class="text-xs text-white/40 mt-0.5">Public pages will show a maintenance message. Admin panel stays accessible.</p>
                </div>
            </label>
            <div class="mb-6"><label class="label">Maintenance Title</label><input type="text" name="settings[maintenance_title]" class="input-field" value="{{ $settings['maintenance_title'] ?? '' }}" placeholder="We'll Be Back Soon"></div>
            <div><label class="label">Maintenance Message</label><textarea name="settings[maintenance_message]" rows="3" class="input-field" placeholder="We're performing scheduled maintenance. Please check back shortly.">{{ $settings['maintenance_message'] ?? '' }}</textarea></div>
        </div>
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-6">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Cache Management</h2>
            <p class="text-xs text-white/40 mb-6">Clear cached settings to apply changes immediately</p>
            <p class="text-sm text-white/50 mb-4">Settings are cached for 1 hour for performance. Saving settings automatically clears the cache.</p>
        </div>
    </div>

    <div class="sticky bottom-0 bg-surface-950/90 backdrop-blur-sm py-4 border-t border-white/6 -mx-6 px-6 mt-6 flex items-center justify-between">
        <p class="text-xs text-white/30"><i class="fas fa-info-circle mr-1"></i> Changes apply to all pages instantly after saving</p>
        <button type="submit" class="btn-primary px-8">
            <i class="fas fa-save mr-2"></i> Save All Settings
        </button>
    </div>
</form>
</div>
@endsection
