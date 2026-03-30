@extends('layouts.dashboard')
@section('title', 'Referrals')
@section('page-title', 'Referral Program')

@section('sidebar')
    @include('client.partials.sidebar', ['active' => 'referrals'])
@endsection

@section('content')
<div class="mb-8">
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-8 bg-linear-to-r from-primary-600 to-secondary-600 text-white">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Invite Friends & Earn Rewards</h2>
                <p class="text-white/80">Share your referral link and earn a 10% discount for every successful referral!</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold">10%</div>
                <div class="text-sm text-white/70">Reward per referral</div>
            </div>
        </div>
    </div>
</div>

{{-- Referral Link --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-8">
    <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5"><i class="fas fa-link mr-2 text-primary-400"></i>Your Referral Link</h3>
    <div class="flex items-center gap-3">
        <input type="text" id="referral-link" value="{{ route('referral.landing', $referral->code) }}" class="input-field flex-1" readonly>
        <button onclick="copyReferralLink()" class="btn-primary whitespace-nowrap">
            <i class="fas fa-copy mr-2"></i>Copy Link
        </button>
    </div>
    <div class="grid grid-cols-3 gap-4 mt-6">
        <div class="text-center p-4 bg-white/4 rounded-2xl">
            <div class="text-2xl font-bold text-primary-400">{{ $referral->clicks }}</div>
            <div class="text-sm text-white/50">Link Clicks</div>
        </div>
        <div class="text-center p-4 bg-white/4 rounded-2xl">
            <div class="text-2xl font-bold text-emerald-400">{{ $referral->conversions->count() ?? 0 }}</div>
            <div class="text-sm text-white/50">Conversions</div>
        </div>
        <div class="text-center p-4 bg-white/4 rounded-2xl">
            <div class="text-2xl font-bold text-accent-400">{{ $cs }}{{ number_format($referral->conversions->where('status', 'paid')->sum('commission')) }}</div>
            <div class="text-sm text-white/50">Earned</div>
        </div>
    </div>
</div>

{{-- Share Buttons --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-8">
    <h3 class="text-sm font-bold text-white/40 uppercase tracking-wider mb-5"><i class="fas fa-share-alt mr-2 text-primary-400"></i>Share Via</h3>
    @php $shareUrl = urlencode(route('referral.landing', $referral->code)); $shareText = urlencode('Check out ICodeDev for professional software development! Use my referral link:'); @endphp
    <div class="flex flex-wrap gap-3">
        <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"><i class="fab fa-whatsapp"></i>WhatsApp</a>
        <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition"><i class="fab fa-twitter"></i>Twitter</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"><i class="fab fa-facebook"></i>Facebook</a>
        <a href="mailto:?subject={{ urlencode('Try ICodeDev') }}&body={{ $shareText }}%20{{ $shareUrl }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition"><i class="fas fa-envelope"></i>Email</a>
    </div>
</div>

{{-- Conversion History --}}
<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <div class="px-6 py-4 border-b border-white/6">
        <h3 class="font-bold text-white">Referral History</h3>
    </div>
    @if($referral->conversions->count())
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead class="bg-white/4">
                <tr>
                    <th class="table-header">#</th>
                    <th class="table-header">Referred User</th>
                    <th class="table-header">Status</th>
                    <th class="table-header">Commission</th>
                    <th class="table-header">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/6">
                @foreach($referral->conversions as $i => $conversion)
                <tr>
                    <td class="table-cell">{{ $i + 1 }}</td>
                    <td class="table-cell">{{ $conversion->referred->name ?? 'Pending' }}</td>
                    <td class="table-cell">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ match($conversion->status) {
                            'paid' => 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20',
                            'converted' => 'bg-blue-500/15 text-blue-400 ring-1 ring-blue-500/20',
                            'registered' => 'bg-amber-500/15 text-amber-400 ring-1 ring-amber-500/20',
                            default => 'bg-white/6 text-white/50 ring-1 ring-white/8'
                        } }}">{{ ucfirst($conversion->status) }}</span>
                    </td>
                    <td class="table-cell font-medium">{{ $cs }}{{ number_format($conversion->commission_amount ?? 0) }}</td>
                    <td class="table-cell text-white/50">{{ $conversion->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-12 text-center text-white/30">
        <i class="fas fa-users text-4xl mb-4 text-white/30"></i>
        <p>No referrals yet. Share your link to get started!</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
function copyReferralLink() {
    const input = document.getElementById('referral-link');
    navigator.clipboard.writeText(input.value).then(() => {
        const btn = input.nextElementSibling;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
        setTimeout(() => btn.innerHTML = '<i class="fas fa-copy mr-2"></i>Copy Link', 2000);
    });
}
</script>
@endpush
@endsection
