<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Learn how we collect, use, and protect your personal information.',
                'content' => $this->privacyContent(),
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'meta_title' => 'Terms of Service',
                'meta_description' => 'Read our terms of service governing the use of our website and services.',
                'content' => $this->termsContent(),
            ],
            [
                'title' => 'Cookies Policy',
                'slug' => 'cookies-policy',
                'meta_title' => 'Cookies Policy',
                'meta_description' => 'Learn about how we use cookies on our website.',
                'content' => $this->cookiesContent(),
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, ['is_active' => true])
            );
        }
    }

    private function privacyContent(): string
    {
        return <<<'HTML'
<div class="legal-section">
    <h2><i class="fas fa-shield-alt text-primary-400"></i> Information We Collect</h2>
    <p>We collect information you provide directly, including:</p>
    <ul>
        <li><strong>Personal Information:</strong> Name, email address, phone number, and company details when you contact us, register, or use our services.</li>
        <li><strong>Project Information:</strong> Requirements, files, and communications related to your projects.</li>
        <li><strong>Payment Information:</strong> Billing details processed securely through third-party payment providers (Paystack, Flutterwave).</li>
        <li><strong>Usage Data:</strong> Browser type, IP address, pages visited, and interaction data collected automatically.</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-bullseye text-secondary-400"></i> How We Use Your Information</h2>
    <ul>
        <li>To provide, maintain, and improve our services</li>
        <li>To communicate about projects, updates, and support</li>
        <li>To process payments and send invoices</li>
        <li>To send newsletters and promotional content (with your consent)</li>
        <li>To analyze website usage and improve user experience</li>
        <li>To comply with legal obligations</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-lock text-emerald-400"></i> Data Security</h2>
    <p>We implement industry-standard security measures to protect your data, including:</p>
    <ul>
        <li>SSL/TLS encryption for all data transmission</li>
        <li>Secure password hashing with bcrypt</li>
        <li>Regular security audits and vulnerability assessments</li>
        <li>Role-based access control for project data</li>
        <li>Encrypted backups stored in secure cloud infrastructure</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-share-alt text-amber-400"></i> Data Sharing</h2>
    <p>We do not sell your personal information. We may share data with:</p>
    <ul>
        <li><strong>Service Providers:</strong> Payment processors, hosting providers, and analytics tools</li>
        <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
        <li><strong>Business Transfers:</strong> In connection with any merger or acquisition</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-user-check text-accent-400"></i> Your Rights</h2>
    <p>You have the right to:</p>
    <ul>
        <li>Access, correct, or delete your personal data</li>
        <li>Withdraw consent for marketing communications</li>
        <li>Request a copy of your data in a portable format</li>
        <li>Object to data processing in certain circumstances</li>
    </ul>
    <p>To exercise these rights, contact us via the contact page.</p>
</div>

<div class="legal-section">
    <h2><i class="fas fa-sync-alt text-primary-400"></i> Changes to This Policy</h2>
    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date.</p>
</div>
HTML;
    }

    private function termsContent(): string
    {
        return <<<'HTML'
<div class="legal-section">
    <h2><i class="fas fa-file-contract text-primary-400"></i> Agreement to Terms</h2>
    <p>By accessing or using our website and services, you agree to be bound by these Terms of Service. If you do not agree, please do not use our services.</p>
    <p>These terms apply to all visitors, users, and clients who access or use our platform and services.</p>
</div>

<div class="legal-section">
    <h2><i class="fas fa-laptop-code text-secondary-400"></i> Services</h2>
    <p>We provide professional technology services including:</p>
    <ul>
        <li>Web Development &amp; Design</li>
        <li>Mobile Application Development</li>
        <li>UI/UX Design</li>
        <li>Desktop Software Development</li>
        <li>API Development &amp; Integration</li>
        <li>Cloud &amp; DevOps Solutions</li>
    </ul>
    <p>Each project is governed by a separate project agreement or statement of work that details scope, timelines, and deliverables.</p>
</div>

<div class="legal-section">
    <h2><i class="fas fa-credit-card text-emerald-400"></i> Payments &amp; Billing</h2>
    <ul>
        <li>Payment terms are specified in each project agreement or invoice</li>
        <li>An initial deposit (typically 40-50%) is required before project commencement</li>
        <li>Final payment is due upon project completion and delivery</li>
        <li>Late payments may incur additional charges as specified in the project agreement</li>
        <li>All prices are in the currency stated on the invoice</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-copyright text-amber-400"></i> Intellectual Property</h2>
    <ul>
        <li>Upon full payment, clients receive full ownership of custom code and designs created specifically for their project</li>
        <li>We retain the right to use project screenshots in portfolios unless otherwise agreed</li>
        <li>Third-party components (libraries, frameworks, assets) remain under their respective licenses</li>
        <li>Pre-existing tools, frameworks, and templates remain our property</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-user-shield text-accent-400"></i> Client Responsibilities</h2>
    <ul>
        <li>Provide accurate and timely information, content, and feedback</li>
        <li>Ensure all provided content does not infringe third-party rights</li>
        <li>Maintain confidentiality of login credentials and access details</li>
        <li>Respond to review requests within agreed timelines</li>
        <li>Provide a secure and authorized environment for deployments</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-tools text-primary-400"></i> Warranty &amp; Support</h2>
    <ul>
        <li>We provide a 30-day warranty period after project delivery for bug fixes</li>
        <li>Ongoing maintenance and support are available under separate agreements</li>
        <li>We do not guarantee uninterrupted or error-free service for hosted solutions</li>
        <li>Scope changes after project approval may incur additional costs</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-ban text-red-400"></i> Limitation of Liability</h2>
    <p>We shall not be liable for any indirect, incidental, special, or consequential damages arising from the use of our services. Our total liability shall not exceed the total amount paid by the client for the specific project in question.</p>
</div>
HTML;
    }

    private function cookiesContent(): string
    {
        return <<<'HTML'
<div class="legal-section">
    <h2><i class="fas fa-cookie-bite text-amber-400"></i> What Are Cookies?</h2>
    <p>Cookies are small text files stored on your device when you visit our website. They help us provide a better experience by remembering your preferences, understanding how you use our site, and enabling certain features.</p>
</div>

<div class="legal-section">
    <h2><i class="fas fa-cog text-primary-400"></i> Essential Cookies</h2>
    <p>These cookies are necessary for the website to function properly:</p>
    <table class="cookie-table">
        <thead>
            <tr>
                <th>Cookie</th>
                <th>Purpose</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>XSRF-TOKEN</code></td>
                <td>Cross-site request forgery protection</td>
                <td>2 hours</td>
            </tr>
            <tr>
                <td><code>icodedev_session</code></td>
                <td>Session management and authentication</td>
                <td>2 hours</td>
            </tr>
            <tr>
                <td><code>remember_web_*</code></td>
                <td>Remember me functionality</td>
                <td>5 years</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="legal-section">
    <h2><i class="fas fa-chart-bar text-secondary-400"></i> Analytics Cookies</h2>
    <p>We use analytics cookies to understand how visitors interact with our website:</p>
    <ul>
        <li>Page views and navigation patterns</li>
        <li>Traffic sources and referral data</li>
        <li>Device and browser information</li>
        <li>Geographic location (country level)</li>
    </ul>
    <p>This data is aggregated and anonymized. We do not use it to identify individual visitors.</p>
</div>

<div class="legal-section">
    <h2><i class="fas fa-sliders-h text-emerald-400"></i> Preference Cookies</h2>
    <p>These cookies remember your preferences and choices:</p>
    <ul>
        <li>Language and region settings</li>
        <li>Theme preferences (dark/light mode)</li>
        <li>Cookie consent choices</li>
        <li>Dashboard layout preferences</li>
    </ul>
</div>

<div class="legal-section">
    <h2><i class="fas fa-toggle-on text-accent-400"></i> Managing Cookies</h2>
    <p>You can control cookies through your browser settings:</p>
    <ul>
        <li><strong>Chrome:</strong> Settings → Privacy and Security → Cookies</li>
        <li><strong>Firefox:</strong> Settings → Privacy &amp; Security → Cookies</li>
        <li><strong>Safari:</strong> Preferences → Privacy → Cookies</li>
        <li><strong>Edge:</strong> Settings → Cookies and Site Permissions</li>
    </ul>
    <p>Please note that disabling essential cookies may affect website functionality.</p>
</div>
HTML;
    }
}
