<nav class="space-y-6">
    {{-- Main --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Main</p>
        <div class="space-y-0.5">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large w-5 text-center"></i> Dashboard</a>
            <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"><i class="fas fa-project-diagram w-5 text-center"></i> Projects</a>
            <a href="{{ route('admin.tasks.index') }}" class="sidebar-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}"><i class="fas fa-tasks w-5 text-center"></i> Tasks
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-blue-500/20 text-blue-400" data-badge="tasks" style="{{ ($badges['tasks'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['tasks'] ?? 0 }}</span>
            </a>
            @if(auth()->user()->isManager())
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users w-5 text-center"></i> Users</a>
            @endif
            <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="fas fa-comment-dots w-5 text-center"></i> Messages
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-primary-500/20 text-primary-400" data-badge="messages" style="{{ ($badges['messages'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['messages'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    {{-- Business --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Business</p>
        <div class="space-y-0.5">
            <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><i class="fas fa-cogs w-5 text-center"></i> Services</a>
            @if(auth()->user()->isManager())
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="fas fa-credit-card w-5 text-center"></i> Payments
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/20 text-amber-400" data-badge="payments" style="{{ ($badges['payments'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['payments'] ?? 0 }}</span>
            </a>
            @endif
            <a href="{{ route('admin.invoices.index') }}" class="sidebar-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar w-5 text-center"></i> Invoices
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-red-500/20 text-red-400" data-badge="invoices" style="{{ ($badges['invoices'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['invoices'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    {{-- Content --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Content</p>
        <div class="space-y-0.5">
            <a href="{{ route('admin.blog.index') }}" class="sidebar-link {{ request()->routeIs('admin.blog.*') && !request()->routeIs('admin.blog.comments*') ? 'active' : '' }}"><i class="fas fa-pen-nib w-5 text-center"></i> Blog Posts</a>
            <a href="{{ route('admin.blog.comments') }}" class="sidebar-link {{ request()->routeIs('admin.blog.comments*') ? 'active' : '' }}"><i class="fas fa-comments w-5 text-center"></i> Comments
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/20 text-amber-400" data-badge="comments" style="{{ ($badges['comments'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['comments'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.cms.portfolios') }}" class="sidebar-link {{ request()->routeIs('admin.cms.portfolios*') ? 'active' : '' }}"><i class="fas fa-images w-5 text-center"></i> Portfolios</a>
            <a href="{{ route('admin.cms.testimonials') }}" class="sidebar-link {{ request()->routeIs('admin.cms.testimonials*') ? 'active' : '' }}"><i class="fas fa-star w-5 text-center"></i> Testimonials
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/20 text-amber-400" data-badge="testimonials" style="{{ ($badges['testimonials'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['testimonials'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.cms.team-members') }}" class="sidebar-link {{ request()->routeIs('admin.cms.team*') ? 'active' : '' }}"><i class="fas fa-user-friends w-5 text-center"></i> Team Members</a>
            <a href="{{ route('admin.cms.pages') }}" class="sidebar-link {{ request()->routeIs('admin.cms.pages*') ? 'active' : '' }}"><i class="fas fa-file-alt w-5 text-center"></i> Pages</a>
            <a href="{{ route('admin.cms.media') }}" class="sidebar-link {{ request()->routeIs('admin.cms.media*') ? 'active' : '' }}"><i class="fas fa-photo-video w-5 text-center"></i> Media Library</a>
        </div>
    </div>

    {{-- CRM --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">CRM</p>
        <div class="space-y-0.5">
            <a href="{{ route('admin.cms.contacts') }}" class="sidebar-link {{ request()->routeIs('admin.cms.contacts*') ? 'active' : '' }}"><i class="fas fa-address-book w-5 text-center"></i> Contacts
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-400" data-badge="contacts" style="{{ ($badges['contacts'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['contacts'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.cms.quotes') }}" class="sidebar-link {{ request()->routeIs('admin.cms.quotes*') ? 'active' : '' }}"><i class="fas fa-file-signature w-5 text-center"></i> Quotes
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/20 text-emerald-400" data-badge="quotes" style="{{ ($badges['quotes'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['quotes'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.cms.newsletters') }}" class="sidebar-link {{ request()->routeIs('admin.cms.newsletters*') ? 'active' : '' }}"><i class="fas fa-paper-plane w-5 text-center"></i> Newsletter</a>
            <a href="{{ route('admin.cms.client-logos') }}" class="sidebar-link {{ request()->routeIs('admin.cms.client-logos*') ? 'active' : '' }}"><i class="fas fa-handshake w-5 text-center"></i> Client Logos</a>
        </div>
    </div>

    {{-- System --}}
    @if(auth()->user()->isAdmin())
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">System</p>
        <div class="space-y-0.5">
            <a href="{{ route('admin.cms.settings') }}" class="sidebar-link {{ request()->routeIs('admin.cms.settings*') ? 'active' : '' }}"><i class="fas fa-sliders-h w-5 text-center"></i> Settings</a>
            <a href="{{ route('admin.cms.activity-logs') }}" class="sidebar-link {{ request()->routeIs('admin.cms.activity*') ? 'active' : '' }}"><i class="fas fa-history w-5 text-center"></i> Activity Log</a>
        </div>
    </div>
    @endif
</nav>
