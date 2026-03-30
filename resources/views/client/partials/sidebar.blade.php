<nav class="space-y-6">
    {{-- Overview --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Overview</p>
        <div class="space-y-0.5">
            <a href="{{ route('client.dashboard') }}" class="sidebar-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}"><i class="fas fa-th-large w-5 text-center"></i> Dashboard</a>
            <a href="{{ route('client.projects.index') }}" class="sidebar-link {{ ($active ?? '') === 'projects' ? 'active' : '' }}"><i class="fas fa-project-diagram w-5 text-center"></i> My Projects</a>
            <a href="{{ route('client.messages.index') }}" class="sidebar-link {{ ($active ?? '') === 'messages' ? 'active' : '' }}"><i class="fas fa-comment-dots w-5 text-center"></i> Messages
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-primary-500/20 text-primary-400" data-badge="messages" style="{{ ($badges['messages'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['messages'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    {{-- Billing --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Billing</p>
        <div class="space-y-0.5">
            <a href="{{ route('client.payments.index') }}" class="sidebar-link {{ ($active ?? '') === 'payments' ? 'active' : '' }}"><i class="fas fa-credit-card w-5 text-center"></i> Payments
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-500/20 text-amber-400" data-badge="payments" style="{{ ($badges['payments'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['payments'] ?? 0 }}</span>
            </a>
            <a href="{{ route('client.invoices') }}" class="sidebar-link {{ ($active ?? '') === 'invoices' ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar w-5 text-center"></i> Invoices
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-red-500/20 text-red-400" data-badge="invoices" style="{{ ($badges['invoices'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['invoices'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    {{-- More --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">More</p>
        <div class="space-y-0.5">
            <a href="{{ route('client.testimonials') }}" class="sidebar-link {{ ($active ?? '') === 'testimonials' ? 'active' : '' }}"><i class="fas fa-star w-5 text-center"></i> My Reviews</a>
            <a href="{{ route('client.downloads') }}" class="sidebar-link {{ ($active ?? '') === 'downloads' ? 'active' : '' }}"><i class="fas fa-cloud-download-alt w-5 text-center"></i> Downloads</a>
            <a href="{{ route('client.referrals') }}" class="sidebar-link {{ ($active ?? '') === 'referrals' ? 'active' : '' }}"><i class="fas fa-gift w-5 text-center"></i> Referrals</a>
            <a href="{{ route('client.profile') }}" class="sidebar-link {{ ($active ?? '') === 'profile' ? 'active' : '' }}"><i class="fas fa-user-circle w-5 text-center"></i> My Profile</a>
        </div>
    </div>
</nav>
