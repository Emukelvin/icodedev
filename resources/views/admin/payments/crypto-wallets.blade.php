@extends('layouts.dashboard')
@section('title', 'Crypto Wallets')
@section('sidebar')@include('admin.partials.sidebar')@endsection
@section('page-title', 'Crypto Wallets')
@section('page-subtitle', 'Manage cryptocurrency wallet addresses for client payments')

@section('content')
<div class="p-6 max-w-5xl">
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.cms.settings') }}" class="text-white/40 hover:text-white text-sm"><i class="fas fa-arrow-left mr-2"></i>Back to Settings</a>
        @if(auth()->user()->isAdmin())
        <button onclick="document.getElementById('add-wallet-modal').classList.remove('hidden')" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Wallet</button>
        @endif
    </div>

    {{-- Wallets Grid --}}
    @forelse($wallets as $wallet)
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-4">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 ring-1 ring-amber-500/20 flex items-center justify-center shrink-0">
                    <i class="{{ $wallet->icon ?? 'fab fa-bitcoin' }} text-amber-400 text-lg"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-white font-bold">{{ $wallet->name }}</h3>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase bg-white/5 text-white/50 ring-1 ring-white/8">{{ $wallet->symbol }}</span>
                        @if($wallet->network)
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-primary-500/10 text-primary-400 ring-1 ring-primary-500/20">{{ $wallet->network }}</span>
                        @endif
                        @if($wallet->is_active)
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20">Active</span>
                        @else
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-500/10 text-red-400 ring-1 ring-red-500/20">Inactive</span>
                        @endif
                    </div>
                    <p class="text-white/50 text-sm font-mono break-all">{{ $wallet->wallet_address }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode($wallet->wallet_address) }}&bgcolor=1a1a2e&color=ffffff" alt="QR" class="w-16 h-16 rounded-lg border border-white/10">
                        <p class="text-xs text-white/30">QR Code Preview</p>
                    </div>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="flex items-center gap-2 shrink-0">
                <button onclick="editWallet({{ $wallet->id }}, '{{ e($wallet->name) }}', '{{ e($wallet->symbol) }}', '{{ e($wallet->network) }}', '{{ e($wallet->wallet_address) }}', '{{ e($wallet->icon) }}', {{ $wallet->is_active ? 'true' : 'false' }}, {{ $wallet->sort_order }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white/5 text-white/50 ring-1 ring-white/8 hover:bg-white/10 hover:text-white transition-all"><i class="fas fa-edit"></i></button>
                <form action="{{ route('admin.crypto-wallets.destroy', $wallet) }}" method="POST" onsubmit="return confirm('Delete this wallet?')">@csrf @method('DELETE')
                    <button class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-400 hover:bg-red-500/15 ring-1 ring-red-500/20 transition-all"><i class="fas fa-trash"></i></button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-12 text-center">
        <i class="fab fa-bitcoin text-white/10 text-5xl mb-4 block"></i>
        <p class="text-white/40 mb-2">No crypto wallets configured</p>
        <p class="text-white/25 text-sm">Add wallet addresses so clients can pay with cryptocurrency</p>
    </div>
    @endforelse
</div>

{{-- Add Wallet Modal --}}
<div id="add-wallet-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="bg-surface-800 rounded-2xl border border-white/6 p-6 w-full max-w-lg shadow-2xl mx-4">
        <h3 class="text-lg font-bold text-white mb-6">Add Crypto Wallet</h3>
        <form action="{{ route('admin.crypto-wallets.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="label">Coin Name <span class="text-red-400">*</span></label><input type="text" name="name" class="input-field" required placeholder="e.g. Bitcoin"></div>
                <div><label class="label">Symbol <span class="text-red-400">*</span></label><input type="text" name="symbol" class="input-field" required placeholder="e.g. BTC" maxlength="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="label">Network</label><input type="text" name="network" class="input-field" placeholder="e.g. ERC-20, TRC-20, BEP-20"></div>
                <div><label class="label">Icon (Font Awesome)</label><input type="text" name="icon" class="input-field" placeholder="e.g. fab fa-bitcoin" value="fab fa-bitcoin"></div>
            </div>
            <div class="mb-4"><label class="label">Wallet Address <span class="text-red-400">*</span></label><input type="text" name="wallet_address" class="input-field font-mono" required placeholder="Paste your wallet address"></div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div><label class="label">Sort Order</label><input type="number" name="sort_order" class="input-field" value="0" min="0"></div>
                <div class="flex items-end">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked class="w-5 h-5 rounded bg-white/10 border-white/20 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm text-white/70">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-plus mr-2"></i>Add Wallet</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Wallet Modal --}}
<div id="edit-wallet-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="bg-surface-800 rounded-2xl border border-white/6 p-6 w-full max-w-lg shadow-2xl mx-4">
        <h3 class="text-lg font-bold text-white mb-6">Edit Crypto Wallet</h3>
        <form id="edit-wallet-form" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="label">Coin Name <span class="text-red-400">*</span></label><input type="text" name="name" id="edit-name" class="input-field" required></div>
                <div><label class="label">Symbol <span class="text-red-400">*</span></label><input type="text" name="symbol" id="edit-symbol" class="input-field" required maxlength="10"></div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div><label class="label">Network</label><input type="text" name="network" id="edit-network" class="input-field"></div>
                <div><label class="label">Icon (Font Awesome)</label><input type="text" name="icon" id="edit-icon" class="input-field"></div>
            </div>
            <div class="mb-4"><label class="label">Wallet Address <span class="text-red-400">*</span></label><input type="text" name="wallet_address" id="edit-address" class="input-field font-mono" required></div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div><label class="label">Sort Order</label><input type="number" name="sort_order" id="edit-sort" class="input-field" min="0"></div>
                <div class="flex items-end">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" id="edit-active" class="w-5 h-5 rounded bg-white/10 border-white/20 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm text-white/70">Active</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="btn-secondary">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function editWallet(id, name, symbol, network, address, icon, active, sort) {
    document.getElementById('edit-wallet-form').action = `/admin/crypto-wallets/${id}`;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-symbol').value = symbol;
    document.getElementById('edit-network').value = network;
    document.getElementById('edit-address').value = address;
    document.getElementById('edit-icon').value = icon;
    document.getElementById('edit-active').checked = active;
    document.getElementById('edit-sort').value = sort;
    document.getElementById('edit-wallet-modal').classList.remove('hidden');
}
</script>
@endsection
