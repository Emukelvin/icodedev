<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\ClientLogo;
use App\Models\PricingPackage;
use App\Models\BlogPost;
use App\Models\TeamMember;
use App\Models\Page;
use App\Notifications\ContactFormReceived;
use App\Notifications\QuoteRequestReceived;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->take(6)->get();
        $portfolios = Portfolio::where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->take(6)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $clientLogos = ClientLogo::where('is_active', true)->orderBy('sort_order')->get();
        $packages = PricingPackage::with('service')->where('is_active', true)->orderBy('sort_order')->take(3)->get();
        $posts = BlogPost::with('author', 'category')->published()->latest('published_at')->take(3)->get();
        $teamMembers = TeamMember::where('is_active', true)->orderBy('sort_order')->take(4)->get();

        $stats = [
            'projects' => \App\Models\Project::where('status', 'completed')->count() ?: 150,
            'clients' => \App\Models\User::where('role', 'client')->count() ?: 80,
            'team' => TeamMember::where('is_active', true)->count() ?: 25,
            'years' => max(1, now()->year - 2023),
        ];

        return view('pages.home', compact('services', 'portfolios', 'testimonials', 'clientLogos', 'packages', 'posts', 'teamMembers', 'stats'));
    }

    public function about()
    {
        $teamMembers = TeamMember::where('is_active', true)->orderBy('sort_order')->get();

        $stats = [
            'projects' => \App\Models\Project::where('status', 'completed')->count() ?: 150,
            'clients' => \App\Models\User::where('role', 'client')->count() ?: 80,
            'team' => TeamMember::where('is_active', true)->count() ?: 25,
            'years' => max(1, now()->year - 2023),
        ];

        return view('pages.about', compact('teamMembers', 'stats'));
    }

    public function teamMemberProfile(TeamMember $teamMember)
    {
        abort_unless($teamMember->is_active, 404);

        $otherMembers = TeamMember::where('is_active', true)
            ->where('id', '!=', $teamMember->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('pages.team-show', compact('teamMember', 'otherMembers'));
    }

    public function services()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.services', compact('services'));
    }

    public function serviceDetail(Service $service)
    {
        $packages = $service->pricingPackages()->where('is_active', true)->orderBy('sort_order')->get();
        $relatedPortfolios = Portfolio::where('category', 'like', '%' . $service->title . '%')
            ->where('is_active', true)->take(3)->get();
        return view('pages.service-detail', compact('service', 'packages', 'relatedPortfolios'));
    }

    public function portfolio()
    {
        $portfolios = Portfolio::where('is_active', true)->orderBy('sort_order')->paginate(12);
        $categories = Portfolio::where('is_active', true)->distinct()->pluck('category');
        return view('pages.portfolio', compact('portfolios', 'categories'));
    }

    public function portfolioDetail(Portfolio $portfolio)
    {
        $related = Portfolio::where('category', $portfolio->category)
            ->where('id', '!=', $portfolio->id)
            ->where('is_active', true)->take(3)->get();
        return view('pages.portfolio-detail', compact('portfolio', 'related'));
    }

    public function pricing()
    {
        $packages = PricingPackage::with('service')->where('is_active', true)->orderBy('sort_order')->get();
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();
        return view('pages.pricing', compact('packages', 'services'));
    }

    public function contact()
    {
        $services = Service::where('is_active', true)->get();
        return view('pages.contact', compact('services'));
    }

    public function submitContact(Request $request)
    {
        // Honeypot anti-spam check
        if ($request->filled('website_url')) {
            return back()->with('success', 'Thank you for contacting us!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'project_type' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'g-recaptcha-response' => [new Recaptcha],
        ]);

        $contact = \App\Models\ContactSubmission::create($validated);

        Notification::route('mail', $validated['email'])->notify(new ContactFormReceived($contact));

        return back()->with('success', 'Thank you for contacting us! We\'ll get back to you within 24 hours.');
    }

    public function submitQuote(Request $request)
    {
        if ($request->filled('website_url')) {
            return back()->with('success', 'Your quote request has been submitted!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'service_type' => 'required|string|max:255',
            'project_description' => 'required|string|max:10000',
            'features' => 'nullable|array',
            'estimated_budget' => 'nullable|numeric|min:0',
            'timeline' => 'nullable|string|max:255',
            'g-recaptcha-response' => [new Recaptcha],
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        $quote = \App\Models\QuoteRequest::create($validated);

        Notification::route('mail', $validated['email'])->notify(new QuoteRequestReceived($quote));

        return back()->with('success', 'Your quote request has been submitted! We\'ll send you a detailed quote soon.');
    }

    public function submitNewsletter(Request $request)
    {
        if ($request->filled('website_url')) {
            return back()->with('success', 'Thank you for subscribing!');
        }

        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        \App\Models\Newsletter::create(['email' => $request->email]);

        Notification::route('mail', $request->email)->notify(new \App\Notifications\NewsletterSubscribed($request->email));

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    public function estimator()
    {
        return view('pages.estimator');
    }

    public function privacy()
    {
        $page = Page::where('slug', 'privacy-policy')->where('is_active', true)->firstOrFail();
        return view('pages.legal', compact('page'));
    }

    public function terms()
    {
        $page = Page::where('slug', 'terms-of-service')->where('is_active', true)->firstOrFail();
        return view('pages.legal', compact('page'));
    }

    public function cookies()
    {
        $page = Page::where('slug', 'cookies-policy')->where('is_active', true)->firstOrFail();
        return view('pages.legal', compact('page'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function referralLanding(string $code)
    {
        $referral = \App\Models\Referral::where('code', $code)->first();

        if ($referral) {
            $referral->increment('clicks');
            session(['referral_code' => $code]);
        }

        return redirect()->route('register');
    }
}
