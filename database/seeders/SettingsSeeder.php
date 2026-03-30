<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_description', 'value' => 'Professional Web, Mobile & Desktop Software Development Company.', 'group' => 'general'],
            ['key' => 'logo_url', 'value' => '', 'group' => 'general'],
            ['key' => 'favicon_url', 'value' => '', 'group' => 'general'],
            ['key' => 'copyright_text', 'value' => 'ICodeDev. All rights reserved.', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => '₦', 'group' => 'general'],
            ['key' => 'currency_code', 'value' => 'NGN', 'group' => 'general'],
            ['key' => 'support_email', 'value' => 'support@icodedev.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+234 703 802 4207', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Lagos, Nigeria', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'hello@icodedev.com', 'group' => 'contact'],
            ['key' => 'whatsapp_number', 'value' => '+2347038024207', 'group' => 'contact'],
            ['key' => 'map_embed_url', 'value' => '', 'group' => 'contact'],
            ['key' => 'business_hours', 'value' => 'Mon-Fri: 9AM - 6PM WAT', 'group' => 'contact'],
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social_tiktok', 'value' => '', 'group' => 'social'],
            ['key' => 'social_discord', 'value' => '', 'group' => 'social'],
            ['key' => 'meta_description', 'value' => 'ICodeDev - Professional Web, Mobile & Desktop Software Development.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'web development, mobile app, desktop software, Laravel, React, ICodeDev', 'group' => 'seo'],
            ['key' => 'og_image', 'value' => '', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'gtm_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'head_scripts', 'value' => '', 'group' => 'seo'],
            ['key' => 'footer_scripts', 'value' => '', 'group' => 'seo'],
            ['key' => 'enable_blog', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_portfolio', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_pricing', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_testimonials', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_team', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_newsletter', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_whatsapp', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_scroll_progress', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_client_logos', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_faq', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_estimator', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_registration', 'value' => '1', 'group' => 'features'],
            ['key' => 'enable_email_verification', 'value' => '0', 'group' => 'features'],
            ['key' => 'hero_title', 'value' => '', 'group' => 'content'],
            ['key' => 'hero_subtitle', 'value' => '', 'group' => 'content'],
            ['key' => 'cta_button_text', 'value' => 'Start Your Project', 'group' => 'content'],
            ['key' => 'cta_button_url', 'value' => '/contact', 'group' => 'content'],
            ['key' => 'footer_description', 'value' => 'Building world-class websites, mobile apps, and enterprise software. Your vision, our code.', 'group' => 'content'],
            ['key' => 'enable_announcement', 'value' => '0', 'group' => 'content'],
            ['key' => 'announcement_text', 'value' => '', 'group' => 'content'],
            ['key' => 'paystack_public_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'paystack_secret_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'flutterwave_public_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'flutterwave_secret_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'enable_paystack', 'value' => '1', 'group' => 'payment'],
            ['key' => 'enable_flutterwave', 'value' => '1', 'group' => 'payment'],
            ['key' => 'enable_bank_transfer', 'value' => '0', 'group' => 'payment'],
            ['key' => 'enable_crypto', 'value' => '0', 'group' => 'payment'],
            ['key' => 'bank_name', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_account_name', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_account_number', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_sort_code', 'value' => '', 'group' => 'payment'],
            ['key' => 'bank_instructions', 'value' => 'Please use your invoice number as payment reference.', 'group' => 'payment'],
            ['key' => 'maintenance_mode', 'value' => '0', 'group' => 'maintenance'],
            ['key' => 'maintenance_title', 'value' => "We'll Be Back Soon", 'group' => 'maintenance'],
            ['key' => 'maintenance_message', 'value' => "We're performing scheduled maintenance.", 'group' => 'maintenance'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], ['value' => $s['value'], 'group' => $s['group']]);
        }

        Setting::clearCache();

        $this->command->info('Seeded ' . count($settings) . ' settings. Total: ' . Setting::count());
    }
}
