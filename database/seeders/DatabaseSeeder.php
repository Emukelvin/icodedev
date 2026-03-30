<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Task;
use App\Models\TeamMember;
use App\Models\Setting;
use App\Models\ContactSubmission;
use App\Models\QuoteRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── ADMIN USER ─────────────────────────────────────────
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@icodedev.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+234 800 000 0001',
            'company' => 'ICodeDev',
            'bio' => 'Platform administrator with full system access.',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // ─── MANAGER USER ──────────────────────────────────────
        $manager = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'manager@icodedev.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+234 800 000 0002',
            'company' => 'ICodeDev',
            'bio' => 'Project manager overseeing client deliverables.',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // ─── DEVELOPERS ────────────────────────────────────────
        $devNames = ['James Okonkwo', 'Ada Nwankwo', 'Emeka Eze'];
        $developers = [];
        foreach ($devNames as $i => $name) {
            $developers[] = User::create([
                'name' => $name,
                'email' => 'dev' . ($i + 1) . '@icodedev.com',
                'password' => Hash::make('password'),
                'role' => 'developer',
                'phone' => '+234 800 000 ' . str_pad($i + 3, 4, '0', STR_PAD_LEFT),
                'bio' => 'Full-stack developer specializing in modern web technologies.',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // ─── CLIENTS ───────────────────────────────────────────
        $clientData = [
            ['name' => 'Michael Chen', 'email' => 'client@icodedev.com', 'company' => 'TechVentures Inc'],
            ['name' => 'Amara Obi', 'email' => 'amara@example.com', 'company' => 'StartupHub Nigeria'],
            ['name' => 'David Williams', 'email' => 'david@example.com', 'company' => 'Global Retail Co'],
        ];
        $clients = [];
        foreach ($clientData as $cd) {
            $clients[] = User::create([
                'name' => $cd['name'],
                'email' => $cd['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
                'company' => $cd['company'],
                'phone' => '+234 900 ' . rand(100, 999) . ' ' . rand(1000, 9999),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // ─── SERVICES ──────────────────────────────────────────
        $servicesData = [
            ['title' => 'Web Development', 'slug' => 'web-development', 'short_description' => 'Custom websites and web applications built with modern technologies.', 'description' => 'We build fast, scalable, and secure web applications using Laravel, React, Vue.js, and more. From simple landing pages to complex enterprise systems, we deliver solutions that drive results.', 'icon' => 'fas fa-code', 'technologies' => ['Laravel', 'React', 'Vue.js', 'Tailwind CSS', 'MySQL'], 'features' => ['Responsive Design', 'SEO Optimization', 'Performance Tuning', 'Security Best Practices', 'API Integration'], 'sort_order' => 1],
            ['title' => 'Mobile App Development', 'slug' => 'mobile-app-development', 'short_description' => 'Native and cross-platform mobile applications for iOS and Android.', 'description' => 'Create powerful mobile experiences with React Native and Flutter. We build apps that your users will love, with smooth animations and offline capabilities.', 'icon' => 'fas fa-mobile-alt', 'technologies' => ['React Native', 'Flutter', 'Firebase', 'Swift', 'Kotlin'], 'features' => ['Cross-Platform', 'Push Notifications', 'Offline Support', 'App Store Submission', 'Analytics Integration'], 'sort_order' => 2],
            ['title' => 'UI/UX Design', 'slug' => 'ui-ux-design', 'short_description' => 'Beautiful, intuitive interfaces that users love to interact with.', 'description' => 'Our design team crafts user-centered interfaces that balance aesthetics with usability. From wireframes to pixel-perfect mockups, we create designs that convert.', 'icon' => 'fas fa-paint-brush', 'technologies' => ['Figma', 'Adobe XD', 'Sketch', 'InVision', 'Tailwind CSS'], 'features' => ['User Research', 'Wireframing', 'Prototyping', 'Design Systems', 'Usability Testing'], 'sort_order' => 3],
            ['title' => 'Desktop Software', 'slug' => 'desktop-software', 'short_description' => 'Powerful desktop applications for Windows, macOS, and Linux.', 'description' => 'We develop high-performance desktop applications using Electron, C#, Java, and Python. From business management tools to creative software, we build solutions that run natively on your computer with full hardware access and offline capabilities.', 'icon' => 'fas fa-desktop', 'technologies' => ['Electron', 'C#/.NET', 'Java', 'Python', 'SQLite'], 'features' => ['Cross-Platform Support', 'Native Performance', 'Offline Capability', 'Auto Updates', 'System Integration', 'Hardware Access'], 'sort_order' => 4],
            ['title' => 'API Development', 'slug' => 'api-development', 'short_description' => 'RESTful and GraphQL APIs for seamless system integration.', 'description' => 'Build robust APIs that power your applications and connect your systems. We follow best practices for authentication, rate limiting, and documentation.', 'icon' => 'fas fa-plug', 'technologies' => ['Laravel', 'Node.js', 'GraphQL', 'PostgreSQL', 'Redis'], 'features' => ['RESTful Design', 'OAuth Authentication', 'Rate Limiting', 'Auto Documentation', 'Versioning'], 'sort_order' => 5],
            ['title' => 'Cloud & DevOps', 'slug' => 'cloud-devops', 'short_description' => 'Cloud infrastructure setup, CI/CD pipelines, and server management.', 'description' => 'Deploy and scale your applications with confidence. We set up cloud infrastructure on AWS, DigitalOcean, or Azure with automated deployment pipelines.', 'icon' => 'fas fa-cloud', 'technologies' => ['AWS', 'Docker', 'GitHub Actions', 'Nginx', 'Linux'], 'features' => ['Server Setup', 'CI/CD Pipelines', 'SSL Certificates', 'Monitoring & Alerts', 'Auto Scaling'], 'sort_order' => 6],
        ];

        $services = [];
        foreach ($servicesData as $sd) {
            $services[] = Service::create($sd);
        }

        // ─── PRICING PACKAGES ───────────────────────────────────
        $packages = [
            ['service_id' => $services[0]->id, 'name' => 'Basic', 'slug' => 'web-basic', 'description' => 'Perfect for small businesses and landing pages', 'price' => 150000, 'billing_cycle' => 'one-time', 'features' => ['Up to 5 Pages', 'Responsive Design', 'Contact Form', 'Basic SEO Setup', 'Social Media Integration', '1 Month Support'], 'sort_order' => 1],
            ['service_id' => $services[0]->id, 'name' => 'Standard', 'slug' => 'web-standard', 'description' => 'Great for growing businesses with custom needs', 'price' => 400000, 'billing_cycle' => 'one-time', 'features' => ['Up to 15 Pages', 'Custom Design', 'CMS Integration', 'Payment Integration', 'Email Notifications', 'Analytics Dashboard', 'API Integration', '3 Months Support'], 'is_popular' => true, 'sort_order' => 2],
            ['service_id' => $services[0]->id, 'name' => 'Premium', 'slug' => 'web-premium', 'description' => 'Full-scale enterprise solutions', 'price' => 800000, 'billing_cycle' => 'one-time', 'features' => ['Unlimited Pages', 'Custom Application', 'Advanced Security', 'Admin Dashboard', 'Real-time Features', 'Performance Optimization', 'API Development', '6 Months Support', 'Priority Support'], 'sort_order' => 3],
        ];
        foreach ($packages as $p) {
            PricingPackage::create($p);
        }

        // ─── PROJECTS ──────────────────────────────────────────
        $projectsData = [
            ['title' => 'E-Commerce Platform', 'slug' => 'ecommerce-platform-' . Str::random(6), 'client_id' => $clients[0]->id, 'service_id' => $services[3]->id, 'manager_id' => $manager->id, 'description' => 'A full-featured e-commerce platform with Paystack integration, inventory management, and admin dashboard.', 'status' => 'in_progress', 'priority' => 'high', 'budget' => 8000, 'total_paid' => 4000, 'progress' => 65, 'start_date' => now()->subDays(30), 'deadline' => now()->addDays(30), 'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Paystack']],
            ['title' => 'Corporate Website Redesign', 'slug' => 'corporate-website-' . Str::random(6), 'client_id' => $clients[1]->id, 'service_id' => $services[0]->id, 'manager_id' => $manager->id, 'description' => 'Complete redesign of corporate website with modern UI and improved performance.', 'status' => 'completed', 'priority' => 'medium', 'budget' => 3500, 'total_paid' => 3500, 'progress' => 100, 'start_date' => now()->subDays(60), 'deadline' => now()->subDays(10), 'completed_at' => now()->subDays(12), 'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js']],
            ['title' => 'Inventory Management App', 'slug' => 'inventory-app-' . Str::random(6), 'client_id' => $clients[2]->id, 'service_id' => $services[1]->id, 'manager_id' => $manager->id, 'description' => 'Cross-platform mobile app for real-time inventory tracking and barcode scanning.', 'status' => 'in_progress', 'priority' => 'urgent', 'budget' => 12000, 'total_paid' => 6000, 'progress' => 40, 'start_date' => now()->subDays(15), 'deadline' => now()->addDays(45), 'technologies' => ['React Native', 'Firebase', 'Node.js']],
            ['title' => 'Healthcare API Integration', 'slug' => 'healthcare-api-' . Str::random(6), 'client_id' => $clients[0]->id, 'service_id' => $services[4]->id, 'description' => 'REST API for connecting healthcare systems with patient management.', 'status' => 'pending', 'priority' => 'medium', 'budget' => 6000, 'total_paid' => 0, 'progress' => 0, 'technologies' => ['Laravel', 'PostgreSQL', 'Redis']],
        ];

        $projects = [];
        foreach ($projectsData as $pd) {
            $projects[] = Project::create($pd);
        }

        // Attach developers to projects
        $projects[0]->developers()->attach([$developers[0]->id, $developers[1]->id]);
        $projects[1]->developers()->attach([$developers[2]->id]);
        $projects[2]->developers()->attach([$developers[0]->id, $developers[2]->id]);

        // ─── TASKS ──────────────────────────────────────────────
        $tasksData = [
            ['project_id' => $projects[0]->id, 'assigned_to' => $developers[0]->id, 'created_by' => $manager->id, 'title' => 'Setup payment gateway integration', 'description' => 'Integrate Paystack and Flutterwave payment gateways.', 'status' => 'in_progress', 'priority' => 'high', 'due_date' => now()->addDays(5)],
            ['project_id' => $projects[0]->id, 'assigned_to' => $developers[1]->id, 'created_by' => $manager->id, 'title' => 'Build product catalog', 'description' => 'Create product listing, categories, and search functionality.', 'status' => 'done', 'priority' => 'high', 'due_date' => now()->subDays(5), 'completed_at' => now()->subDays(3)],
            ['project_id' => $projects[0]->id, 'assigned_to' => $developers[0]->id, 'created_by' => $manager->id, 'title' => 'Shopping cart and checkout', 'status' => 'todo', 'priority' => 'medium', 'due_date' => now()->addDays(10)],
            ['project_id' => $projects[2]->id, 'assigned_to' => $developers[0]->id, 'created_by' => $manager->id, 'title' => 'Barcode scanner integration', 'description' => 'Implement camera-based barcode scanning for inventory items.', 'status' => 'in_progress', 'priority' => 'urgent', 'due_date' => now()->addDays(7)],
            ['project_id' => $projects[2]->id, 'assigned_to' => $developers[2]->id, 'created_by' => $manager->id, 'title' => 'Real-time sync dashboard', 'status' => 'todo', 'priority' => 'medium', 'due_date' => now()->addDays(14)],
            ['project_id' => $projects[2]->id, 'assigned_to' => $developers[2]->id, 'created_by' => $manager->id, 'title' => 'Push notification system', 'status' => 'todo', 'priority' => 'low', 'due_date' => now()->addDays(20)],
        ];
        foreach ($tasksData as $td) {
            Task::create($td);
        }

        // ─── PAYMENTS ──────────────────────────────────────────
        $paymentsData = [
            ['user_id' => $clients[0]->id, 'project_id' => $projects[0]->id, 'amount' => 4000, 'currency' => 'USD', 'status' => 'successful', 'gateway' => 'paystack', 'reference' => 'PAY-' . Str::random(12), 'created_at' => now()->subDays(25)],
            ['user_id' => $clients[1]->id, 'project_id' => $projects[1]->id, 'amount' => 1750, 'currency' => 'USD', 'status' => 'successful', 'gateway' => 'flutterwave', 'reference' => 'PAY-' . Str::random(12), 'created_at' => now()->subDays(55)],
            ['user_id' => $clients[1]->id, 'project_id' => $projects[1]->id, 'amount' => 1750, 'currency' => 'USD', 'status' => 'successful', 'gateway' => 'paystack', 'reference' => 'PAY-' . Str::random(12), 'created_at' => now()->subDays(15)],
            ['user_id' => $clients[2]->id, 'project_id' => $projects[2]->id, 'amount' => 6000, 'currency' => 'USD', 'status' => 'successful', 'gateway' => 'paystack', 'reference' => 'PAY-' . Str::random(12), 'created_at' => now()->subDays(10)],
        ];
        foreach ($paymentsData as $pd) {
            Payment::create($pd);
        }

        // ─── INVOICES ──────────────────────────────────────────
        $invoice1 = Invoice::create([
            'invoice_number' => 'INV-000001',
            'user_id' => $clients[0]->id,
            'project_id' => $projects[0]->id,
            'subtotal' => 4000,
            'tax' => 0,
            'discount' => 0,
            'total' => 4000,
            'status' => 'paid',
            'due_date' => now()->subDays(20),
            'paid_date' => now()->subDays(25),
        ]);
        InvoiceItem::create(['invoice_id' => $invoice1->id, 'description' => 'E-Commerce Platform - Phase 1', 'quantity' => 1, 'unit_price' => 4000, 'total' => 4000]);

        $invoice2 = Invoice::create([
            'invoice_number' => 'INV-000002',
            'user_id' => $clients[0]->id,
            'project_id' => $projects[0]->id,
            'subtotal' => 4000,
            'tax' => 0,
            'discount' => 0,
            'total' => 4000,
            'status' => 'sent',
            'due_date' => now()->addDays(15),
        ]);
        InvoiceItem::create(['invoice_id' => $invoice2->id, 'description' => 'E-Commerce Platform - Phase 2', 'quantity' => 1, 'unit_price' => 4000, 'total' => 4000]);

        $invoice3 = Invoice::create([
            'invoice_number' => 'INV-000003',
            'user_id' => $clients[2]->id,
            'project_id' => $projects[2]->id,
            'subtotal' => 6000,
            'tax' => 0,
            'discount' => 0,
            'total' => 6000,
            'status' => 'paid',
            'due_date' => now()->subDays(5),
            'paid_date' => now()->subDays(10),
        ]);
        InvoiceItem::create(['invoice_id' => $invoice3->id, 'description' => 'Inventory Management App - Initial Payment', 'quantity' => 1, 'unit_price' => 6000, 'total' => 6000]);

        // ─── PORTFOLIO ─────────────────────────────────────────
        $portfolioData = [
            ['title' => 'FinTech Dashboard', 'slug' => 'fintech-dashboard-' . Str::random(4), 'short_description' => 'Real-time financial analytics dashboard for a leading fintech startup.', 'description' => 'Built a comprehensive financial analytics dashboard featuring real-time data visualization, automated reporting, and secure multi-user access. The platform processes millions of transactions daily.', 'category' => 'Web Application', 'client_name' => 'FinFlow Inc', 'technologies' => ['Laravel', 'Vue.js', 'D3.js', 'PostgreSQL'], 'is_featured' => true, 'is_active' => true, 'client_feedback' => 'ICodeDev delivered an exceptional dashboard that transformed how we analyze financial data.', 'client_rating' => 5, 'completion_date' => now()->subMonths(2), 'sort_order' => 1],
            ['title' => 'FoodDelivery Mobile App', 'slug' => 'food-delivery-app-' . Str::random(4), 'short_description' => 'Cross-platform food delivery app with real-time tracking.', 'description' => 'Developed a feature-rich food delivery application with real-time order tracking, in-app payments via Paystack, restaurant management portal, and driver assignment system.', 'category' => 'Mobile App', 'client_name' => 'QuickBite Nigeria', 'technologies' => ['React Native', 'Node.js', 'MongoDB', 'Paystack'], 'is_featured' => true, 'is_active' => true, 'client_feedback' => 'The app exceeded our expectations. Downloads grew 300% in the first month.', 'client_rating' => 5, 'completion_date' => now()->subMonths(4), 'sort_order' => 2],
            ['title' => 'Corporate Website', 'slug' => 'corporate-website-' . Str::random(4), 'short_description' => 'Modern responsive website for a multinational consulting firm.', 'description' => 'Designed and developed a pixel-perfect corporate website with multilingual support, blog system, and career portal.', 'category' => 'Web Design', 'client_name' => 'Apex Consulting', 'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js'], 'is_featured' => false, 'is_active' => true, 'client_feedback' => 'Professional work, delivered on time and on budget.', 'client_rating' => 4, 'completion_date' => now()->subMonths(6), 'sort_order' => 3],
            ['title' => 'E-Learning Platform', 'slug' => 'elearning-platform-' . Str::random(4), 'short_description' => 'Interactive online learning platform with video courses and quizzes.', 'description' => 'Built a comprehensive e-learning platform with video streaming, progress tracking, certificate generation, and payment integration.', 'category' => 'Web Application', 'client_name' => 'EduConnect', 'technologies' => ['Laravel', 'React', 'AWS S3', 'Flutterwave'], 'is_featured' => true, 'is_active' => true, 'client_rating' => 5, 'completion_date' => now()->subMonths(1), 'sort_order' => 4],
        ];
        foreach ($portfolioData as $pd) {
            Portfolio::create($pd);
        }

        // ─── TESTIMONIALS ──────────────────────────────────────
        $testimonials = [
            ['client_name' => 'Michael Chen', 'client_position' => 'CEO', 'client_company' => 'TechVentures Inc', 'content' => 'ICodeDev transformed our digital presence completely. Their team delivered a robust e-commerce platform that increased our online sales by 200%. Highly recommended!', 'rating' => 5, 'is_active' => true, 'sort_order' => 1],
            ['client_name' => 'Amara Obi', 'client_position' => 'Founder', 'client_company' => 'StartupHub Nigeria', 'content' => 'Working with ICodeDev was a game-changer for our startup. They understood our vision and built a product that our users absolutely love.', 'rating' => 5, 'is_active' => true, 'sort_order' => 2],
            ['client_name' => 'David Williams', 'client_position' => 'CTO', 'client_company' => 'Global Retail Co', 'content' => 'The inventory management app they built saves us hours every day. Their technical expertise and attention to detail is outstanding.', 'rating' => 4, 'is_active' => true, 'sort_order' => 3],
        ];
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // ─── TEAM MEMBERS ──────────────────────────────────────
        $team = [
            ['name' => 'Emmanuel Adeyemi', 'position' => 'CEO & Lead Developer', 'bio' => 'Full-stack developer with 10+ years of experience building scalable web applications.', 'email' => 'emmanuel@icodedev.com', 'social_links' => ['github' => '#', 'linkedin' => '#', 'twitter' => '#'], 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Sarah Johnson', 'position' => 'Project Manager', 'bio' => 'Experienced project manager ensuring timely delivery and client satisfaction.', 'email' => 'sarah@icodedev.com', 'social_links' => ['linkedin' => '#'], 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Ada Nwankwo', 'position' => 'UI/UX Designer', 'bio' => 'Creative designer passionate about building beautiful and intuitive user experiences.', 'email' => 'ada@icodedev.com', 'social_links' => ['dribbble' => '#', 'linkedin' => '#'], 'is_active' => true, 'sort_order' => 3],
            ['name' => 'James Okonkwo', 'position' => 'Senior Developer', 'bio' => 'Backend specialist focused on building secure and performant APIs.', 'email' => 'james@icodedev.com', 'social_links' => ['github' => '#'], 'is_active' => true, 'sort_order' => 4],
        ];
        foreach ($team as $t) {
            TeamMember::create($t);
        }

        // ─── BLOG CATEGORIES & TAGS ────────────────────────────
        $categories = [];
        $catData = [
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Articles about web development technologies and best practices.'],
            ['name' => 'Mobile Development', 'slug' => 'mobile-development', 'description' => 'Tips and tutorials for mobile app development.'],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'UI/UX design trends, tools, and techniques.'],
            ['name' => 'Tech News', 'slug' => 'tech-news', 'description' => 'Latest technology news and industry updates.'],
        ];
        foreach ($catData as $c) {
            $categories[] = BlogCategory::create($c);
        }

        $tags = [];
        foreach (['Laravel', 'React', 'Vue.js', 'PHP', 'JavaScript', 'Tailwind CSS', 'API', 'Security', 'Performance', 'DevOps'] as $tagName) {
            $tags[] = BlogTag::create(['name' => $tagName, 'slug' => Str::slug($tagName)]);
        }

        // ─── BLOG POSTS ────────────────────────────────────────
        $posts = [
            ['user_id' => $admin->id, 'category_id' => $categories[0]->id, 'title' => 'Building Scalable Laravel Applications in 2025', 'slug' => 'building-scalable-laravel-apps-2025', 'excerpt' => 'Learn the best practices for building Laravel applications that can handle millions of users.', 'body' => "<p>Laravel continues to be one of the most popular PHP frameworks for building web applications. In this article, we'll explore the key strategies for building scalable Laravel applications.</p>\n\n<h2>1. Database Optimization</h2>\n<p>Proper database indexing and query optimization are crucial. Use Laravel's query builder efficiently and avoid N+1 queries with eager loading.</p>\n\n<h2>2. Caching Strategies</h2>\n<p>Implement Redis or Memcached for caching frequently accessed data. Use Laravel's built-in cache system for route, config, and view caching.</p>\n\n<h2>3. Queue Processing</h2>\n<p>Offload heavy tasks to queues using Laravel's queue system. This keeps your response times fast while handling background processing efficiently.</p>", 'status' => 'published', 'published_at' => now()->subDays(5), 'views_count' => 1250],
            ['user_id' => $admin->id, 'category_id' => $categories[1]->id, 'title' => 'React Native vs Flutter: Which to Choose in 2025', 'slug' => 'react-native-vs-flutter-2025', 'excerpt' => 'A comprehensive comparison of the two most popular cross-platform mobile development frameworks.', 'body' => "<p>Choosing between React Native and Flutter can be challenging. Both frameworks have matured significantly, and each has its strengths.</p>\n\n<h2>React Native</h2>\n<p>React Native leverages JavaScript and React, making it a natural choice for teams already familiar with web development. Its large ecosystem and community support are major advantages.</p>\n\n<h2>Flutter</h2>\n<p>Flutter uses Dart and offers excellent performance with its compiled approach. Its widget system provides beautiful, consistent UIs across platforms.</p>\n\n<h2>Our Recommendation</h2>\n<p>Choose React Native if your team knows JavaScript. Choose Flutter for the best visual consistency and performance.</p>", 'status' => 'published', 'published_at' => now()->subDays(12), 'views_count' => 890],
            ['user_id' => $admin->id, 'category_id' => $categories[2]->id, 'title' => 'UI Design Trends That Will Dominate 2025', 'slug' => 'ui-design-trends-2025', 'excerpt' => 'Stay ahead of the curve with these emerging UI design trends for the coming year.', 'body' => "<p>The design world evolves rapidly. Here are the trends we expect to dominate in 2025.</p>\n\n<h2>1. Glassmorphism 2.0</h2>\n<p>The glass effect continues to evolve with more subtle applications and better accessibility considerations.</p>\n\n<h2>2. Micro-Interactions</h2>\n<p>Thoughtful micro-interactions that provide visual feedback and delight users are becoming essential.</p>\n\n<h2>3. AI-Assisted Design</h2>\n<p>AI tools are now helping designers generate layouts, color schemes, and even complete design systems.</p>", 'status' => 'published', 'published_at' => now()->subDays(3), 'views_count' => 650],
        ];
        foreach ($posts as $i => $p) {
            $post = BlogPost::create($p);
            $post->tags()->attach(array_slice(array_map(fn($t) => $t->id, $tags), $i * 2, 3));
        }

        // ─── CONTACT SUBMISSIONS ────────────────────────────────
        ContactSubmission::create(['name' => 'John Smith', 'email' => 'john@example.com', 'phone' => '+1 555 0100', 'subject' => 'Website Development Inquiry', 'message' => 'Hi, I am interested in getting a website developed for my small business. Could you provide a quote?', 'status' => 'new']);
        ContactSubmission::create(['name' => 'Lisa Taylor', 'email' => 'lisa@example.com', 'subject' => 'Partnership Opportunity', 'message' => 'We are looking for a development partner for our upcoming SaaS product. Would love to discuss.', 'status' => 'read']);

        // ─── QUOTE REQUESTS ─────────────────────────────────────
        QuoteRequest::create(['name' => 'Robert Johnson', 'email' => 'robert@example.com', 'phone' => '+234 800 555 1234', 'company' => 'JR Industries', 'service_type' => 'E-Commerce Solutions', 'estimated_budget' => 7500, 'timeline' => '2-3 months', 'project_description' => 'We need an e-commerce website with product catalog, shopping cart, and Paystack payment integration.', 'status' => 'new']);

        // ─── SETTINGS ───────────────────────────────────────────
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'ICodeDev', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Building Digital Excellence', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Professional Web, Mobile & Desktop Software Development Company.', 'group' => 'general'],
            ['key' => 'logo_url', 'value' => '', 'group' => 'general'],
            ['key' => 'favicon_url', 'value' => '', 'group' => 'general'],
            ['key' => 'copyright_text', 'value' => 'ICodeDev. All rights reserved.', 'group' => 'general'],
            ['key' => 'currency_symbol', 'value' => '₦', 'group' => 'general'],
            ['key' => 'currency_code', 'value' => 'NGN', 'group' => 'general'],

            // Contact
            ['key' => 'contact_email', 'value' => 'hello@icodedev.com', 'group' => 'contact'],
            ['key' => 'support_email', 'value' => 'support@icodedev.com', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+234 703 802 4207', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Lagos, Nigeria', 'group' => 'contact'],
            ['key' => 'whatsapp_number', 'value' => '+2347038024207', 'group' => 'contact'],
            ['key' => 'map_embed_url', 'value' => '', 'group' => 'contact'],
            ['key' => 'business_hours', 'value' => 'Mon-Fri: 9AM - 6PM WAT', 'group' => 'contact'],

            // Social
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/icodedev', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/icodedev', 'group' => 'social'],
            ['key' => 'social_github', 'value' => 'https://github.com/icodedev', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social_tiktok', 'value' => '', 'group' => 'social'],
            ['key' => 'social_discord', 'value' => '', 'group' => 'social'],

            // SEO
            ['key' => 'meta_description', 'value' => 'ICodeDev - Professional Web, Mobile & Desktop Software Development. Build your dream application with our expert team.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'web development, mobile app, desktop software, Laravel, Flutter, React, ICodeDev', 'group' => 'seo'],
            ['key' => 'og_image', 'value' => '', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'gtm_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'head_scripts', 'value' => '', 'group' => 'seo'],
            ['key' => 'footer_scripts', 'value' => '', 'group' => 'seo'],

            // Feature Toggles
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

            // Content
            ['key' => 'hero_title', 'value' => '', 'group' => 'content'],
            ['key' => 'hero_subtitle', 'value' => '', 'group' => 'content'],
            ['key' => 'cta_button_text', 'value' => 'Start Your Project', 'group' => 'content'],
            ['key' => 'cta_button_url', 'value' => '/contact', 'group' => 'content'],
            ['key' => 'footer_description', 'value' => 'Building world-class websites, mobile apps, and enterprise software. Your vision, our code.', 'group' => 'content'],
            ['key' => 'enable_announcement', 'value' => '0', 'group' => 'content'],
            ['key' => 'announcement_text', 'value' => '', 'group' => 'content'],

            // Payment
            ['key' => 'paystack_public_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'paystack_secret_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'flutterwave_public_key', 'value' => '', 'group' => 'payment'],
            ['key' => 'flutterwave_secret_key', 'value' => '', 'group' => 'payment'],

            // Maintenance
            ['key' => 'maintenance_mode', 'value' => '0', 'group' => 'maintenance'],
            ['key' => 'maintenance_title', 'value' => "We'll Be Back Soon", 'group' => 'maintenance'],
            ['key' => 'maintenance_message', 'value' => "We're performing scheduled maintenance. Please check back shortly.", 'group' => 'maintenance'],
        ];
        foreach ($settings as $s) {
            Setting::create($s);
        }

        echo "Database seeded successfully!\n";
        echo "Admin: admin@icodedev.com / password\n";
        echo "Manager: manager@icodedev.com / password\n";
        echo "Developer: dev1@icodedev.com / password\n";
        echo "Client: client@icodedev.com / password\n";
    }
}
