<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\ClientLogo;
use App\Models\TeamMember;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Media;
use App\Models\Setting;
use App\Models\ContactSubmission;
use App\Models\QuoteRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    // Portfolio
    public function portfolios()
    {
        $portfolios = Portfolio::orderBy('sort_order')->paginate(20);
        return view('admin.cms.portfolios', compact('portfolios'));
    }

    public function createPortfolio()
    {
        $portfolio = new Portfolio;
        return view('admin.cms.portfolio-form', compact('portfolio'));
    }

    public function storePortfolio(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'technologies' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'live_url' => 'nullable|url|max:255',
            'client_feedback' => 'nullable|string|max:2000',
            'client_rating' => 'nullable|integer|min:1|max:5',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('portfolios', 'public');
        }

        Portfolio::create($validated);

        return redirect()->route('admin.cms.portfolios')
            ->with('success', 'Portfolio item created.');
    }

    public function editPortfolio(Portfolio $portfolio)
    {
        return view('admin.cms.portfolio-form', compact('portfolio'));
    }

    public function updatePortfolio(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'technologies' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'live_url' => 'nullable|url|max:255',
            'client_feedback' => 'nullable|string|max:2000',
            'client_rating' => 'nullable|integer|min:1|max:5',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies']));
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('portfolios', 'public');
        }

        $portfolio->update($validated);

        return redirect()->route('admin.cms.portfolios')
            ->with('success', 'Portfolio updated.');
    }

    public function deletePortfolio(Portfolio $portfolio)
    {
        $portfolio->delete();
        return back()->with('success', 'Portfolio deleted.');
    }

    // Testimonials
    public function testimonials(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $query = Testimonial::orderBy('sort_order');

        if (in_array($filter, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $filter);
        }

        $testimonials = $query->get();
        $counts = [
            'all' => Testimonial::count(),
            'pending' => Testimonial::where('status', 'pending')->count(),
            'approved' => Testimonial::where('status', 'approved')->count(),
            'rejected' => Testimonial::where('status', 'rejected')->count(),
        ];

        return view('admin.cms.testimonials', compact('testimonials', 'filter', 'counts'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'client_avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['client_name', 'client_position', 'client_company', 'content', 'rating']);
        if ($request->hasFile('client_avatar')) {
            $data['client_avatar'] = $request->file('client_avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);
        return back()->with('success', 'Testimonial added.');
    }

    public function deleteTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    public function approveTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'approved']);
        return back()->with('success', 'Testimonial approved and now visible on the website.');
    }

    public function rejectTestimonial(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'rejected']);
        return back()->with('success', 'Testimonial rejected.');
    }

    // Team Members
    public function teamMembers()
    {
        $members = TeamMember::orderBy('sort_order')->get();
        return view('admin.cms.team', compact('members'));
    }

    public function storeTeamMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'email' => 'nullable|email|max:255',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['name', 'position', 'bio', 'email']);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('team', 'public');
        }
        $socials = array_filter($request->only(['github', 'linkedin', 'twitter', 'website']));
        if (!empty($socials)) {
            $data['social_links'] = $socials;
        }

        TeamMember::create($data);
        return back()->with('success', 'Team member added.');
    }

    public function deleteTeamMember(TeamMember $teamMember)
    {
        $teamMember->delete();
        return back()->with('success', 'Team member removed.');
    }

    // Contact Submissions
    public function contacts()
    {
        $contacts = ContactSubmission::latest()->paginate(20);
        return view('admin.cms.contacts', compact('contacts'));
    }

    public function showContact(ContactSubmission $contact)
    {
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }
        return view('admin.cms.contact-detail', compact('contact'));
    }

    public function updateContactStatus(Request $request, ContactSubmission $contact)
    {
        $contact->update(['status' => $request->status]);
        return back()->with('success', 'Status updated.');
    }

    public function deleteContact(ContactSubmission $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact submission deleted.');
    }

    // Quote Requests
    public function quotes()
    {
        $quotes = QuoteRequest::latest()->paginate(20);
        return view('admin.cms.quotes', compact('quotes'));
    }

    public function showQuote(QuoteRequest $quote)
    {
        return view('admin.cms.quote-detail', compact('quote'));
    }

    public function updateQuote(Request $request, QuoteRequest $quote)
    {
        $request->validate([
            'status' => 'required|in:new,reviewed,quoted,accepted,rejected',
            'quoted_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $quote->update($request->only(['status', 'quoted_price', 'admin_notes']));
        return back()->with('success', 'Quote updated.');
    }

    public function deleteQuote(QuoteRequest $quote)
    {
        $quote->delete();
        return redirect()->route('admin.cms.quotes')->with('success', 'Quote request deleted.');
    }

    // Settings
    public function settings()
    {
        $settings = Setting::getAllCached();
        return view('admin.cms.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        // Handle file uploads for logo, favicon, og_image
        foreach (['logo_url' => 'logo_file', 'favicon_url' => 'favicon_file', 'og_image' => 'og_image_file', 'invoice_logo' => 'invoice_logo_file', 'email_logo' => 'email_logo_file'] as $settingKey => $fileKey) {
            if ($request->hasFile($fileKey)) {
                $request->validate([$fileKey => 'image|max:2048']);
                $path = $request->file($fileKey)->store('settings', 'public');
                Setting::updateOrCreate(['key' => $settingKey], ['value' => '/storage/' . $path]);
            }
        }

        foreach ($request->settings ?? [] as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Setting::clearCache();

        return back()->with('success', 'Settings updated successfully.');
    }

    // Activity Logs
    public function activityLogs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(50);
        return view('admin.cms.activity', compact('logs'));
    }

    // Newsletters
    public function newsletters()
    {
        $subscribers = Newsletter::latest()->paginate(30);
        return view('admin.cms.newsletters', compact('subscribers'));
    }

    public function deleteSubscriber(Newsletter $newsletter)
    {
        $newsletter->delete();
        return back()->with('success', 'Subscriber removed.');
    }

    // Client Logos
    public function clientLogos()
    {
        $logos = ClientLogo::orderBy('sort_order')->get();
        return view('admin.cms.client-logos', compact('logos'));
    }

    public function storeClientLogo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|max:1024',
            'website_url' => 'nullable|url|max:255',
        ]);

        $path = $request->file('logo')->store('client-logos', 'public');

        ClientLogo::create([
            'name' => $request->name,
            'logo_path' => $path,
            'website_url' => $request->website_url,
            'sort_order' => ClientLogo::max('sort_order') + 1,
            'is_active' => true,
        ]);

        return back()->with('success', 'Client logo added.');
    }

    public function deleteClientLogo(ClientLogo $clientLogo)
    {
        $clientLogo->delete();
        return back()->with('success', 'Client logo removed.');
    }

    // ─── CMS PAGES ──────────────────────────────────────────────
    public function pages()
    {
        $pages = Page::latest()->paginate(20);
        return view('admin.cms.pages', compact('pages'));
    }

    public function createPage()
    {
        $page = new Page;
        return view('admin.cms.page-form', compact('page'));
    }

    public function storePage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        Page::create($validated);

        return redirect()->route('admin.cms.pages')->with('success', 'Page created.');
    }

    public function editPage(Page $page)
    {
        return view('admin.cms.page-form', compact('page'));
    }

    public function updatePage(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $page->update($validated);
        return redirect()->route('admin.cms.pages')->with('success', 'Page updated.');
    }

    public function deletePage(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted.');
    }

    // ─── MEDIA MANAGER ──────────────────────────────────────────
    public function media()
    {
        $media = Media::latest()->paginate(30);
        return view('admin.cms.media', compact('media'));
    }

    public function storeMedia(Request $request)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:10240',
        ]);

        foreach ($request->file('files') as $file) {
            $path = $file->store('media', 'public');
            Media::create([
                'user_id' => auth()->id(),
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return back()->with('success', count($request->file('files')) . ' file(s) uploaded.');
    }

    public function deleteMedia(Media $media)
    {
        \Storage::disk('public')->delete($media->file_path);
        $media->delete();
        return back()->with('success', 'File deleted.');
    }

    // ─── NEWSLETTER BROADCAST ───────────────────────────────────
    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $subscribers = Newsletter::all();
        $count = 0;

        foreach ($subscribers as $subscriber) {
            \Mail::raw($request->body, function ($msg) use ($subscriber, $request) {
                $msg->to($subscriber->email)
                    ->subject($request->subject);
            });
            $count++;
        }

        return back()->with('success', "Newsletter sent to {$count} subscribers.");
    }

    // ─── TESTIMONIAL EDIT ───────────────────────────────────────
    public function editTestimonial(Testimonial $testimonial)
    {
        return view('admin.cms.testimonial-edit', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
            'client_avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['client_name', 'client_position', 'client_company', 'content', 'rating']);
        if ($request->hasFile('client_avatar')) {
            $data['client_avatar'] = $request->file('client_avatar')->store('testimonials', 'public');
        }

        $testimonial->update($data);
        return redirect()->route('admin.cms.testimonials')->with('success', 'Testimonial updated.');
    }

    // ─── TEAM MEMBER EDIT ───────────────────────────────────────
    public function editTeamMember(TeamMember $teamMember)
    {
        return view('admin.cms.team-edit', compact('teamMember'));
    }

    public function updateTeamMember(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'email' => 'nullable|email|max:255',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['name', 'position', 'bio', 'email']);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('team', 'public');
        }
        $socials = array_filter($request->only(['github', 'linkedin', 'twitter', 'website']));
        $data['social_links'] = !empty($socials) ? $socials : null;

        $teamMember->update($data);
        return redirect()->route('admin.cms.team-members')->with('success', 'Team member updated.');
    }
}
