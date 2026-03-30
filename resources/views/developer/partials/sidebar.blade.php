<nav class="space-y-6">
    {{-- Workspace --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Workspace</p>
        <div class="space-y-0.5">
            <a href="{{ route('developer.dashboard') }}" class="sidebar-link {{ request()->routeIs('developer.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large w-5 text-center"></i> Dashboard</a>
            <a href="{{ route('developer.tasks.index') }}" class="sidebar-link {{ request()->routeIs('developer.tasks.index') || request()->routeIs('developer.tasks.show') ? 'active' : '' }}"><i class="fas fa-check-circle w-5 text-center"></i> My Tasks</a>
            <a href="{{ route('developer.tasks.kanban') }}" class="sidebar-link {{ request()->routeIs('developer.tasks.kanban') ? 'active' : '' }}"><i class="fas fa-columns w-5 text-center"></i> Kanban Board</a>
            <a href="{{ route('developer.projects') }}" class="sidebar-link {{ request()->routeIs('developer.projects*') ? 'active' : '' }}"><i class="fas fa-rocket w-5 text-center"></i> Projects</a>
        </div>
    </div>

    {{-- Communication --}}
    <div>
        <p class="px-4 text-[10px] font-bold text-white/30 uppercase tracking-[0.2em] mb-3">Communication</p>
        <div class="space-y-0.5">
            <a href="{{ route('developer.messages.index') }}" class="sidebar-link {{ request()->routeIs('developer.messages.*') ? 'active' : '' }}"><i class="fas fa-comment-dots w-5 text-center"></i> Messages
                <span class="ml-auto px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-primary-500/20 text-primary-400" data-badge="messages" style="{{ ($badges['messages'] ?? 0) > 0 ? '' : 'display:none' }}">{{ $badges['messages'] ?? 0 }}</span>
            </a>
        </div>
    </div>
</nav>
