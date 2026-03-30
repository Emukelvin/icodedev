@extends('layouts.dashboard')
@section('title', $user->name . ' - User Detail - ICodeDev')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
{{-- Header --}}
<div class="flex flex-col md:flex-row md:items-center gap-4 mb-8">
    <a href="{{ route('admin.users.index') }}" class="text-white/30 hover:text-white transition-colors self-start"><i class="fas fa-arrow-left"></i></a>
    <div class="flex-1">
        <h1 class="text-2xl font-black text-white">{{ $user->name }}</h1>
        <p class="text-white/50 text-sm">{{ $user->email }} &middot; Member since {{ $user->created_at->format('M Y') }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary text-sm"><i class="fas fa-edit mr-2"></i>Edit</a>
        @if(auth()->user()->isAdmin())
        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="{{ $user->is_active ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20 hover:bg-red-500/25' : 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20 hover:bg-emerald-500/25' }} px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }} mr-2"></i>{{ $user->is_active ? 'Deactivate' : 'Activate' }}
            </button>
        </form>
        @endif
    </div>
</div>

{{-- Quick Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-primary-500/15 flex items-center justify-center"><i class="fas fa-project-diagram text-primary-400"></i></div>
            <div>
                <p class="text-2xl font-black text-white">{{ $user->clientProjects?->count() ?? 0 }}</p>
                <p class="text-xs text-white/40">Projects</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-dollar-sign text-emerald-400"></i></div>
            <div>
                <p class="text-2xl font-black text-white">{{ $cs }}{{ number_format($totalPaid, 0) }}</p>
                <p class="text-xs text-white/40">Total Paid</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center"><i class="fas fa-file-invoice text-amber-400"></i></div>
            <div>
                <p class="text-2xl font-black text-white">{{ $cs }}{{ number_format($totalInvoiced, 0) }}</p>
                <p class="text-xs text-white/40">Invoiced</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-blue-500/15 flex items-center justify-center"><i class="fas fa-tasks text-blue-400"></i></div>
            <div>
                <p class="text-2xl font-black text-white">{{ $user->tasks?->count() ?? 0 }}</p>
                <p class="text-xs text-white/40">Tasks</p>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Left Column - Profile Card --}}
    <div class="space-y-6">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <div class="text-center mb-6">
                <div class="w-24 h-24 rounded-2xl bg-primary-500/15 flex items-center justify-center mx-auto mb-4 ring-2 ring-primary-500/20 overflow-hidden">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-24 h-24 object-cover" alt="{{ $user->name }}">
                    @else
                        <span class="text-3xl font-bold gradient-text">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->role === 'admin' ? 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' : ($user->role === 'developer' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($user->role === 'client' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-purple-500/15 text-purple-400 ring-1 ring-purple-500/20')) }}">{{ ucfirst($user->role) }}</span>
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $user->is_active ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                @if($user->bio)
                <p class="text-white/50 text-sm mt-4 leading-relaxed">{{ $user->bio }}</p>
                @endif
            </div>

            <div class="border-t border-white/6 pt-5 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-envelope text-white/30 text-sm"></i></div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/40">Email</p>
                        <a href="mailto:{{ $user->email }}" class="text-sm text-primary-400 hover:text-primary-300 truncate block">{{ $user->email }}</a>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-phone text-white/30 text-sm"></i></div>
                    <div>
                        <p class="text-xs text-white/40">Phone</p>
                        <p class="text-sm font-medium text-white/80">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-building text-white/30 text-sm"></i></div>
                    <div>
                        <p class="text-xs text-white/40">Company</p>
                        <p class="text-sm font-medium text-white/80">{{ $user->company ?? 'Not provided' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-clock text-white/30 text-sm"></i></div>
                    <div>
                        <p class="text-xs text-white/40">Last Login</p>
                        <p class="text-sm font-medium text-white/80">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-calendar text-white/30 text-sm"></i></div>
                    <div>
                        <p class="text-xs text-white/40">Joined</p>
                        <p class="text-sm font-medium text-white/80">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center shrink-0"><i class="fas fa-shield-alt text-white/30 text-sm"></i></div>
                    <div>
                        <p class="text-xs text-white/40">2FA</p>
                        <p class="text-sm font-medium {{ $user->two_factor_enabled ? 'text-emerald-400' : 'text-white/50' }}">{{ $user->two_factor_enabled ? 'Enabled' : 'Disabled' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column - Details --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Projects --}}
        @if($user->role === 'client')
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2"><i class="fas fa-project-diagram text-primary-400"></i> Projects ({{ $user->clientProjects->count() }})</h3>
            </div>
            <div class="space-y-3">
                @forelse($user->clientProjects as $project)
                <a href="{{ route('admin.projects.show', $project) }}" class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 hover:bg-white/5 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-500/15 flex items-center justify-center shrink-0"><i class="fas fa-folder text-primary-400 text-sm"></i></div>
                        <div>
                            <h4 class="font-semibold text-white/90 group-hover:text-primary-400 transition-colors">{{ $project->title }}</h4>
                            <p class="text-xs text-white/40">{{ $project->service?->title ?? 'No service' }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $project->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20' : ($project->status === 'completed' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-white/6 text-white/50 ring-1 ring-white/8') }}">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                </a>
                @empty
                <div class="text-center py-8"><i class="fas fa-folder-open text-white/15 text-3xl mb-3 block"></i><p class="text-white/30 text-sm">No projects yet</p></div>
                @endforelse
            </div>
        </div>
        @endif

        {{-- Invoices --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2"><i class="fas fa-file-invoice-dollar text-amber-400"></i> Invoices ({{ $user->invoices->count() }})</h3>
            </div>
            <div class="space-y-3">
                @forelse($user->invoices->take(10) as $invoice)
                <a href="{{ route('admin.invoices.show', $invoice) }}" class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 hover:bg-white/5 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/15 flex items-center justify-center shrink-0"><i class="fas fa-file-invoice text-amber-400 text-sm"></i></div>
                        <div>
                            <h4 class="font-semibold text-white/90 group-hover:text-amber-400 transition-colors">{{ $invoice->invoice_number }}</h4>
                            <p class="text-xs text-white/40">Due {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-white">{{ $cs }}{{ number_format($invoice->total, 2) }}</p>
                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $invoice->status === 'paid' ? 'bg-emerald-500/15 text-emerald-400' : ($invoice->status === 'overdue' ? 'bg-red-500/15 text-red-400' : ($invoice->status === 'sent' ? 'bg-blue-500/15 text-blue-400' : 'bg-yellow-500/15 text-yellow-400')) }}">{{ ucfirst($invoice->status) }}</span>
                    </div>
                </a>
                @empty
                <div class="text-center py-8"><i class="fas fa-file-invoice text-white/15 text-3xl mb-3 block"></i><p class="text-white/30 text-sm">No invoices yet</p></div>
                @endforelse
            </div>
        </div>

        {{-- Payments --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2"><i class="fas fa-credit-card text-emerald-400"></i> Payments ({{ $user->payments->count() }})</h3>
            </div>
            <div class="space-y-3">
                @forelse($user->payments->take(10) as $payment)
                <a href="{{ route('admin.payments.show', $payment) }}" class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 hover:bg-white/5 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/15 flex items-center justify-center shrink-0"><i class="fas fa-receipt text-emerald-400 text-sm"></i></div>
                        <div>
                            <h4 class="font-semibold text-white/90 group-hover:text-emerald-400 transition-colors">{{ $cs }}{{ number_format($payment->amount, 2) }}</h4>
                            <p class="text-xs text-white/40">{{ $payment->reference }} &middot; {{ $payment->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $payment->status === 'successful' ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20' : ($payment->status === 'pending' ? 'bg-yellow-500/15 text-yellow-400 ring-1 ring-yellow-500/20' : 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20') }}">{{ ucfirst($payment->status) }}</span>
                </a>
                @empty
                <div class="text-center py-8"><i class="fas fa-credit-card text-white/15 text-3xl mb-3 block"></i><p class="text-white/30 text-sm">No payments yet</p></div>
                @endforelse
            </div>
        </div>

        {{-- Tasks (for developers) --}}
        @if(in_array($user->role, ['developer', 'manager']))
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2"><i class="fas fa-tasks text-blue-400"></i> Assigned Tasks ({{ $user->tasks->count() }})</h3>
            </div>
            <div class="space-y-3">
                @forelse($user->tasks->take(10) as $task)
                <a href="{{ route('admin.tasks.edit', $task) }}" class="flex items-center justify-between p-4 rounded-xl bg-white/3 border border-white/5 hover:border-white/10 hover:bg-white/5 transition-all group">
                    <div>
                        <h4 class="font-semibold text-white/90 group-hover:text-blue-400 transition-colors">{{ $task->title }}</h4>
                        <p class="text-xs text-white/40">{{ $task->project?->title ?? 'No project' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $task->priority === 'urgent' ? 'bg-red-500/15 text-red-400' : ($task->priority === 'high' ? 'bg-orange-500/15 text-orange-400' : 'bg-white/6 text-white/50') }}">{{ ucfirst($task->priority) }}</span>
                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $task->status === 'done' ? 'bg-emerald-500/15 text-emerald-400' : ($task->status === 'in_progress' ? 'bg-blue-500/15 text-blue-400' : 'bg-white/6 text-white/50') }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                    </div>
                </a>
                @empty
                <div class="text-center py-8"><i class="fas fa-tasks text-white/15 text-3xl mb-3 block"></i><p class="text-white/30 text-sm">No tasks assigned</p></div>
                @endforelse
            </div>
        </div>
        @endif

        {{-- Activity Log --}}
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2 mb-5"><i class="fas fa-history text-white/30"></i> Recent Activity</h3>
            <div class="space-y-1">
                @forelse($user->activityLogs as $log)
                <div class="flex gap-3 p-3 rounded-xl hover:bg-white/4 transition-all">
                    <div class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center shrink-0"><i class="fas fa-circle text-primary-400/50 text-[6px]"></i></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-white/70 truncate">{{ $log->description }}</p>
                        <p class="text-xs text-white/30">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8"><i class="fas fa-history text-white/15 text-3xl mb-3 block"></i><p class="text-white/30 text-sm">No activity recorded</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
