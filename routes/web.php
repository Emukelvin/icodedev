<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\DashboardController as ClientDashboard;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\Client\PaymentController as ClientPaymentController;
use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Developer\DashboardController as DevDashboard;
use App\Http\Controllers\Developer\TaskController as DevTaskController;
use App\Http\Controllers\Developer\MessageController as DevMessageController;

// ─── PUBLIC PAGES ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/services/{service}', [HomeController::class, 'serviceDetail'])->name('services.show');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{portfolio}', [HomeController::class, 'portfolioDetail'])->name('portfolio.show');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/team/{teamMember}', [HomeController::class, 'teamMemberProfile'])->name('team.show');
Route::post('/quote', [HomeController::class, 'submitQuote'])->name('quote.submit');
Route::post('/newsletter', [HomeController::class, 'submitNewsletter'])->name('newsletter.submit');
Route::get('/project-estimator', [HomeController::class, 'estimator'])->name('project.estimator');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('terms');
Route::get('/cookies-policy', [HomeController::class, 'cookies'])->name('cookies');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/referral/{code}', [HomeController::class, 'referralLanding'])->name('referral.landing');

// ─── SETUP (remove after deployment) ─────────────────────────────
Route::get('/setup/storage-link', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link created successfully!';
    }
    abort(403);
})->middleware('auth')->name('setup.storage-link');

Route::get('/setup/optimize', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('route:cache');
        \Illuminate\Support\Facades\Artisan::call('view:cache');
        return 'Application optimized successfully!';
    }
    abort(403);
})->middleware('auth')->name('setup.optimize');

// ─── BLOG ────────────────────────────────────────────────────────
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post}/comments', [BlogController::class, 'storeComment'])->name('blog.comment');

// ─── AUTH ────────────────────────────────────────────────────────
Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/2fa/challenge', [AuthController::class, 'show2FAChallenge'])->middleware('auth')->name('2fa.challenge');

// ─── AUTHENTICATED USER ROUTES ──────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read-all');
    Route::post('/notifications/{id}/read', function (string $id) {
        auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();
        return back();
    })->name('notifications.read');
    Route::post('/2fa/enable', [ClientProfileController::class, 'enable2FA'])->name('2fa.enable');
    Route::post('/2fa/disable', [ClientProfileController::class, 'disable2FA'])->name('2fa.disable');
    Route::post('/2fa/verify', [AuthController::class, 'verify2FA'])->name('2fa.verify');

    // Badge counts API for real-time polling
    Route::get('/badges/counts', function () {
        $user = auth()->user();
        \App\Http\ViewComposers\SidebarBadgeComposer::clearCache($user->id);
        return response()->json(\App\Http\ViewComposers\SidebarBadgeComposer::getBadges($user));
    })->name('badges.counts');
});

// ─── PAYMENT CALLBACKS (redirect-based, require auth) ────────────
Route::middleware('auth')->group(function () {
    Route::get('/payment/paystack/callback', [ClientPaymentController::class, 'paystackCallback'])->name('payment.paystack.callback');
    Route::get('/payment/flutterwave/callback', [ClientPaymentController::class, 'flutterwaveCallback'])->name('payment.flutterwave.callback');
});

// ─── PAYMENT WEBHOOKS (server-to-server, no auth/CSRF) ──────────
Route::post('/webhooks/paystack', [ClientPaymentController::class, 'paystackWebhook'])->name('webhooks.paystack')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/webhooks/flutterwave', [ClientPaymentController::class, 'flutterwaveWebhook'])->name('webhooks.flutterwave')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// ─── CLIENT DASHBOARD ───────────────────────────────────────────
Route::middleware(['auth', '2fa', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');

    // Projects
    Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ClientProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ClientProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ClientProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{project}/files', [ClientProjectController::class, 'uploadFile'])->name('projects.files.store');
    Route::post('/projects/{project}/comments', [ClientProjectController::class, 'addComment'])->name('projects.comments.store');

    // Payments
    Route::get('/payments', [ClientPaymentController::class, 'index'])->name('payments.index');
    Route::get('/invoices', [ClientPaymentController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/{invoice}', [ClientPaymentController::class, 'showInvoice'])->name('invoices.show');
    Route::post('/payments/initiate', [ClientPaymentController::class, 'initiate'])->name('payments.initiate');

    // Testimonials / Reviews
    Route::get('/testimonials', [ClientProfileController::class, 'testimonials'])->name('testimonials');
    Route::post('/testimonials', [ClientProfileController::class, 'storeTestimonial'])->name('testimonials.store');

    // Messages
    Route::get('/messages', [ClientMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [ClientMessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/start', [ClientMessageController::class, 'startConversation'])->name('messages.start');
    Route::get('/messages/{conversation}', [ClientMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [ClientMessageController::class, 'store'])->name('messages.store');

    // Profile
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ClientProfileController::class, 'updatePassword'])->name('profile.password');

    // Referrals
    Route::get('/referrals', [ClientProfileController::class, 'referrals'])->name('referrals');

    // Downloads
    Route::get('/downloads', [ClientProjectController::class, 'downloads'])->name('downloads');
});

// ─── DEVELOPER DASHBOARD ────────────────────────────────────────
Route::middleware(['auth', '2fa', 'role:developer'])->prefix('developer')->name('developer.')->group(function () {
    Route::get('/dashboard', [DevDashboard::class, 'index'])->name('dashboard');

    // Tasks
    Route::get('/tasks', [DevTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/kanban', [DevTaskController::class, 'kanban'])->name('tasks.kanban');
    Route::get('/tasks/{task}', [DevTaskController::class, 'show'])->name('tasks.show');
    Route::patch('/tasks/{task}/status', [DevTaskController::class, 'updateStatus'])->name('tasks.status');
    Route::post('/tasks/{task}/comments', [DevTaskController::class, 'addComment'])->name('tasks.comments.store');
    Route::post('/tasks/{task}/attachments', [DevTaskController::class, 'uploadAttachment'])->name('tasks.attachments.store');

    // Projects
    Route::get('/projects', [DevTaskController::class, 'projects'])->name('projects');
    Route::get('/projects/{project}', [DevTaskController::class, 'projectShow'])->name('projects.show');
    Route::post('/projects/{project}/files', [DevTaskController::class, 'uploadProjectFile'])->name('projects.files.store');

    // Messages
    Route::get('/messages', [DevMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [DevMessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/start', [DevMessageController::class, 'startConversation'])->name('messages.start');
    Route::get('/messages/{conversation}', [DevMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [DevMessageController::class, 'store'])->name('messages.store');
});

// ─── ADMIN PANEL ────────────────────────────────────────────────
Route::middleware(['auth', '2fa', 'role:admin,manager'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Projects
    Route::resource('projects', AdminProjectController::class);
    Route::post('/projects/{project}/updates', [AdminProjectController::class, 'addUpdate'])->name('projects.updates.store');
    Route::post('/projects/{project}/files', [AdminProjectController::class, 'uploadFile'])->name('projects.files.store');

    // Services
    Route::resource('services', ServiceController::class)->except('show');

    // Tasks
    Route::get('/tasks', [AdminTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [AdminTaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task}/edit', [AdminTaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/tasks', [AdminTaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [AdminTaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminTaskController::class, 'destroy'])->name('tasks.destroy');

    // Invoices (view, create, edit, send)
    Route::get('/invoices', [AdminPaymentController::class, 'invoices'])->name('invoices.index');
    Route::get('/invoices/create', [AdminPaymentController::class, 'createInvoice'])->name('invoices.create');
    Route::post('/invoices', [AdminPaymentController::class, 'storeInvoice'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [AdminPaymentController::class, 'editInvoice'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [AdminPaymentController::class, 'updateInvoice'])->name('invoices.update');
    Route::patch('/invoices/{invoice}/send', [AdminPaymentController::class, 'sendInvoice'])->name('invoices.send');
    Route::get('/clients/{user}/projects', [AdminPaymentController::class, 'clientProjects'])->name('clients.projects');

    // Blog
    Route::get('/blog', [AdminBlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [AdminBlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [AdminBlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [AdminBlogController::class, 'destroy'])->name('blog.destroy');
    Route::get('/blog/categories', [AdminBlogController::class, 'categories'])->name('blog.categories');
    Route::post('/blog/categories', [AdminBlogController::class, 'storeCategory'])->name('blog.categories.store');
    Route::delete('/blog/categories/{category}', [AdminBlogController::class, 'deleteCategory'])->name('blog.categories.destroy');

    // Blog Comments Moderation
    Route::get('/blog/comments', [AdminBlogController::class, 'comments'])->name('blog.comments');
    Route::patch('/blog/comments/{comment}/approve', [AdminBlogController::class, 'approveComment'])->name('blog.comments.approve');
    Route::patch('/blog/comments/{comment}/reject', [AdminBlogController::class, 'rejectComment'])->name('blog.comments.reject');
    Route::delete('/blog/comments/{comment}', [AdminBlogController::class, 'deleteComment'])->name('blog.comments.destroy');

    // CMS
    Route::get('/portfolios', [CmsController::class, 'portfolios'])->name('cms.portfolios');
    Route::get('/portfolios/create', [CmsController::class, 'createPortfolio'])->name('cms.portfolios.create');
    Route::post('/portfolios', [CmsController::class, 'storePortfolio'])->name('cms.portfolios.store');
    Route::get('/portfolios/{portfolio}/edit', [CmsController::class, 'editPortfolio'])->name('cms.portfolios.edit');
    Route::put('/portfolios/{portfolio}', [CmsController::class, 'updatePortfolio'])->name('cms.portfolios.update');
    Route::delete('/portfolios/{portfolio}', [CmsController::class, 'deletePortfolio'])->name('cms.portfolios.destroy');

    Route::get('/testimonials', [CmsController::class, 'testimonials'])->name('cms.testimonials');
    Route::post('/testimonials', [CmsController::class, 'storeTestimonial'])->name('cms.testimonials.store');
    Route::get('/testimonials/{testimonial}/edit', [CmsController::class, 'editTestimonial'])->name('cms.testimonials.edit');
    Route::put('/testimonials/{testimonial}', [CmsController::class, 'updateTestimonial'])->name('cms.testimonials.update');
    Route::delete('/testimonials/{testimonial}', [CmsController::class, 'deleteTestimonial'])->name('cms.testimonials.destroy');
    Route::patch('/testimonials/{testimonial}/approve', [CmsController::class, 'approveTestimonial'])->name('cms.testimonials.approve');
    Route::patch('/testimonials/{testimonial}/reject', [CmsController::class, 'rejectTestimonial'])->name('cms.testimonials.reject');

    Route::get('/team-members', [CmsController::class, 'teamMembers'])->name('cms.team-members');
    Route::post('/team-members', [CmsController::class, 'storeTeamMember'])->name('cms.team-members.store');
    Route::get('/team-members/{teamMember}/edit', [CmsController::class, 'editTeamMember'])->name('cms.team-members.edit');
    Route::put('/team-members/{teamMember}', [CmsController::class, 'updateTeamMember'])->name('cms.team-members.update');
    Route::delete('/team-members/{teamMember}', [CmsController::class, 'deleteTeamMember'])->name('cms.team-members.destroy');

    Route::get('/contacts', [CmsController::class, 'contacts'])->name('cms.contacts');
    Route::get('/contacts/{contact}', [CmsController::class, 'showContact'])->name('cms.contacts.show');
    Route::patch('/contacts/{contact}/status', [CmsController::class, 'updateContactStatus'])->name('cms.contacts.status');
    Route::delete('/contacts/{contact}', [CmsController::class, 'deleteContact'])->name('cms.contacts.destroy');

    Route::get('/quotes', [CmsController::class, 'quotes'])->name('cms.quotes');
    Route::get('/quotes/{quote}', [CmsController::class, 'showQuote'])->name('cms.quotes.show');
    Route::put('/quotes/{quote}', [CmsController::class, 'updateQuote'])->name('cms.quotes.update');
    Route::delete('/quotes/{quote}', [CmsController::class, 'deleteQuote'])->name('cms.quotes.destroy');

    // CMS Pages
    Route::get('/pages', [CmsController::class, 'pages'])->name('cms.pages');
    Route::get('/pages/create', [CmsController::class, 'createPage'])->name('cms.pages.create');
    Route::post('/pages', [CmsController::class, 'storePage'])->name('cms.pages.store');
    Route::get('/pages/{page}/edit', [CmsController::class, 'editPage'])->name('cms.pages.edit');
    Route::put('/pages/{page}', [CmsController::class, 'updatePage'])->name('cms.pages.update');
    Route::delete('/pages/{page}', [CmsController::class, 'deletePage'])->name('cms.pages.destroy');

    // Media Manager
    Route::get('/media', [CmsController::class, 'media'])->name('cms.media');
    Route::post('/media', [CmsController::class, 'storeMedia'])->name('cms.media.store');
    Route::delete('/media/{media}', [CmsController::class, 'deleteMedia'])->name('cms.media.destroy');

    // Client Logos
    Route::get('/client-logos', [CmsController::class, 'clientLogos'])->name('cms.client-logos');
    Route::post('/client-logos', [CmsController::class, 'storeClientLogo'])->name('cms.client-logos.store');
    Route::delete('/client-logos/{clientLogo}', [CmsController::class, 'deleteClientLogo'])->name('cms.client-logos.destroy');

    // Messages
    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [AdminMessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/start', [AdminMessageController::class, 'startConversation'])->name('messages.start');
    Route::get('/messages/{conversation}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [AdminMessageController::class, 'store'])->name('messages.store');

    // Newsletters (view only for managers)
    Route::get('/newsletters', [CmsController::class, 'newsletters'])->name('cms.newsletters');

    // User Management (admin + manager)
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Payments (admin + manager can view)
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'showPayment'])->name('payments.show');

    // Crypto Wallets (admin + manager can view)
    Route::get('/crypto-wallets', [AdminPaymentController::class, 'cryptoWallets'])->name('crypto-wallets.index');

    // Invoice viewing
    Route::get('/invoices/{invoice}', [AdminPaymentController::class, 'showInvoice'])->name('invoices.show');
});

// ─── ADMIN ONLY ─────────────────────────────────────────────────
Route::middleware(['auth', '2fa', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Site Settings (admin only)
    Route::get('/settings', [CmsController::class, 'settings'])->name('cms.settings');
    Route::put('/settings', [CmsController::class, 'updateSettings'])->name('cms.settings.update');

    // Activity Logs (admin only)
    Route::get('/activity-logs', [CmsController::class, 'activityLogs'])->name('cms.activity-logs');

    // Payment management actions (admin only)
    Route::delete('/invoices/{invoice}', [AdminPaymentController::class, 'destroyInvoice'])->name('invoices.destroy');
    Route::patch('/payments/{payment}/approve', [AdminPaymentController::class, 'approvePayment'])->name('payments.approve');
    Route::patch('/payments/{payment}/reject', [AdminPaymentController::class, 'rejectPayment'])->name('payments.reject');

    // Crypto Wallets management (admin only)
    Route::post('/crypto-wallets', [AdminPaymentController::class, 'storeCryptoWallet'])->name('crypto-wallets.store');
    Route::put('/crypto-wallets/{wallet}', [AdminPaymentController::class, 'updateCryptoWallet'])->name('crypto-wallets.update');
    Route::delete('/crypto-wallets/{wallet}', [AdminPaymentController::class, 'destroyCryptoWallet'])->name('crypto-wallets.destroy');

    // Newsletter sending & subscriber deletion (admin only)
    Route::delete('/newsletters/{newsletter}', [CmsController::class, 'deleteSubscriber'])->name('cms.newsletters.destroy');
    Route::post('/newsletters/send', [CmsController::class, 'sendNewsletter'])->name('cms.newsletters.send');
});
