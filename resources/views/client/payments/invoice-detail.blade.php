@extends('layouts.dashboard')
@section('title', 'Invoice ' . $invoice->invoice_number)

@section('sidebar')
@include('client.partials.sidebar')
@endsection

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- ═══ TOP BAR ═══ --}}
    <div class="flex flex-wrap items-center gap-4 mb-6">
        <a href="{{ route('client.invoices') }}" class="w-9 h-9 rounded-lg bg-white/5 ring-1 ring-white/8 flex items-center justify-center text-white/40 hover:text-white hover:bg-white/10 transition-all"><i class="fas fa-arrow-left text-sm"></i></a>
        <div class="flex-1 min-w-0">
            <h1 class="text-xl font-black text-white tracking-tight">{{ $invoice->invoice_number }}</h1>
            <p class="text-xs text-white/40 mt-0.5">{{ $invoice->project?->title ?? 'Invoice' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="printInvoice()" class="btn-secondary text-xs px-4 py-2"><i class="fas fa-download mr-1.5"></i>PDF</button>
            @php
                $statusColors = [
                    'paid' => 'bg-emerald-500/15 text-emerald-400 ring-emerald-500/25',
                    'overdue' => 'bg-red-500/15 text-red-400 ring-red-500/25',
                    'sent' => 'bg-amber-500/15 text-amber-400 ring-amber-500/25',
                    'pending' => 'bg-purple-500/15 text-purple-400 ring-purple-500/25',
                    'draft' => 'bg-white/10 text-white/50 ring-white/15',
                ];
            @endphp
            <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide ring-1 {{ $statusColors[$invoice->status] ?? $statusColors['draft'] }}">{{ $invoice->status }}</span>
        </div>
    </div>

    {{-- ═══ INVOICE DOCUMENT ═══ --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden" id="invoice-content">

        @php $invoiceLogo = $settings['invoice_logo'] ?? $siteSettings['logo_url'] ?? ''; @endphp
        {{-- Letterhead --}}
        <div class="bg-gradient-to-r from-primary-600/10 to-primary-500/5 border-b border-white/6 print-header">
            <div class="p-8 flex flex-col md:flex-row justify-between gap-6">
                <div>
                    @if(!empty($invoiceLogo))
                    <img src="{{ asset($invoiceLogo) }}" alt="{{ $siteSettings['site_name'] ?? 'ICodeDev' }}" class="h-10 mb-2">
                    @else
                    <h2 class="text-2xl font-black gradient-text tracking-tight">{{ $siteSettings['site_name'] ?? 'ICodeDev' }}</h2>
                    @endif
                    <p class="text-xs text-white/40 mt-1">{{ $siteSettings['site_tagline'] ?? 'Technology Solutions' }}</p>
                    @if($siteSettings['contact_email'] ?? false)
                    <p class="text-xs text-white/30 mt-2"><i class="fas fa-envelope mr-1.5 text-white/15"></i>{{ $siteSettings['contact_email'] }}</p>
                    @endif
                    @if($siteSettings['contact_phone'] ?? false)
                    <p class="text-xs text-white/30 mt-0.5"><i class="fas fa-phone mr-1.5 text-white/15"></i>{{ $siteSettings['contact_phone'] }}</p>
                    @endif
                </div>
                <div class="text-left md:text-right">
                    <p class="text-[10px] text-white/25 uppercase tracking-widest font-bold mb-2">Invoice</p>
                    <p class="text-lg font-bold text-white">{{ $invoice->invoice_number }}</p>
                    <div class="mt-3 space-y-1">
                        <p class="text-xs text-white/40"><span class="text-white/25 mr-1">Issued:</span> {{ $invoice->issue_date?->format('M d, Y') ?? $invoice->created_at->format('M d, Y') }}</p>
                        <p class="text-xs {{ $invoice->status === 'overdue' ? 'text-red-400' : 'text-white/40' }}"><span class="text-white/25 mr-1">Due:</span> {{ $invoice->due_date?->format('M d, Y') ?? '—' }}</p>
                        @if($invoice->paid_date)
                        <p class="text-xs text-emerald-400"><span class="text-white/25 mr-1">Paid:</span> {{ $invoice->paid_date->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Bill To + Summary --}}
        <div class="p-8 grid md:grid-cols-2 gap-8 border-b border-white/6">
            <div>
                <p class="text-[10px] text-white/25 uppercase tracking-widest font-bold mb-3">Bill To</p>
                <p class="font-semibold text-white text-sm">{{ $invoice->user->name }}</p>
                <p class="text-xs text-white/40 mt-1">{{ $invoice->user->email }}</p>
                @if($invoice->user->company)
                <p class="text-xs text-white/40">{{ $invoice->user->company }}</p>
                @endif
                @if($invoice->user->phone)
                <p class="text-xs text-white/40">{{ $invoice->user->phone }}</p>
                @endif
            </div>
            <div>
                <p class="text-[10px] text-white/25 uppercase tracking-widest font-bold mb-3">Summary</p>
                <div class="space-y-2">
                    @if($invoice->project)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-folder text-primary-400/40 text-xs w-4"></i>
                        <span class="text-xs text-white/60">{{ $invoice->project->title }}</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <i class="fas fa-list text-primary-400/40 text-xs w-4"></i>
                        <span class="text-xs text-white/60">{{ $invoice->items->count() }} line {{ Str::plural('item', $invoice->items->count()) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-coins text-primary-400/40 text-xs w-4"></i>
                        <span class="text-xs text-white/60">{{ $settings['currency_code'] ?? 'NGN' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Line Items --}}
        <div class="p-8">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/8">
                        <th class="text-left pb-3 text-[10px] text-white/30 uppercase tracking-widest font-bold">Description</th>
                        <th class="text-center pb-3 text-[10px] text-white/30 uppercase tracking-widest font-bold w-20">Qty</th>
                        <th class="text-right pb-3 text-[10px] text-white/30 uppercase tracking-widest font-bold w-32">Rate</th>
                        <th class="text-right pb-3 text-[10px] text-white/30 uppercase tracking-widest font-bold w-36">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr class="border-b border-white/4">
                        <td class="py-4">
                            <p class="text-sm text-white font-medium">{{ $item->description }}</p>
                        </td>
                        <td class="py-4 text-center text-sm text-white/60">{{ $item->quantity }}</td>
                        <td class="py-4 text-right text-sm text-white/60">{{ $cs }}{{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-4 text-right text-sm text-white font-semibold">{{ $cs }}{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="flex justify-end mt-6">
                <div class="w-72 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Subtotal</span>
                        <span class="text-white/70">{{ $cs }}{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->tax > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Tax</span>
                        <span class="text-white/70">{{ $cs }}{{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    @endif
                    @if($invoice->discount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-white/40">Discount</span>
                        <span class="text-emerald-400">-{{ $cs }}{{ number_format($invoice->discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-3 mt-2 border-t border-white/8">
                        <span class="text-sm font-bold text-white">Total Due</span>
                        <span class="text-xl font-black text-white">{{ $cs }}{{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        @if($invoice->notes)
        <div class="px-8 pb-8">
            <div class="p-4 rounded-xl bg-white/3 border border-white/5">
                <p class="text-[10px] text-white/25 uppercase tracking-widest font-bold mb-2">Notes</p>
                <p class="text-xs text-white/50 leading-relaxed">{{ $invoice->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    {{-- ═══ PAYMENT SECTION ═══ --}}
    @if($invoice->status === 'pending')
    {{-- Payment Under Review --}}
    <div class="mt-8">
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-purple-500/20 overflow-hidden">
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-2xl bg-purple-500/15 ring-1 ring-purple-500/25 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-purple-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Payment Under Review</h3>
                <p class="text-sm text-white/50 max-w-md mx-auto">Your proof of payment has been submitted and is currently being reviewed. You will be notified once it is approved.</p>
            </div>
        </div>
    </div>
    @elseif(!in_array($invoice->status, ['paid', 'cancelled', 'draft']))
    <div class="mt-8" x-data="{ gateway: '{{ old('gateway', '') }}', selectedWallet: {{ old('crypto_wallet_id', 'null') }}, submitting: false }">
        {{-- Errors (show above the card so they're always visible) --}}
        @if(session('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20">
            <p class="text-sm text-red-400"><i class="fas fa-exclamation-circle mr-1.5"></i>{{ session('error') }}</p>
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20">
            @foreach($errors->all() as $error)
            <p class="text-sm text-red-400"><i class="fas fa-exclamation-circle mr-1.5"></i>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">

            {{-- Payment Header --}}
            <div class="p-6 border-b border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-500/15 ring-1 ring-primary-500/20 flex items-center justify-center">
                        <i class="fas fa-lock text-primary-400"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Make a Payment</h3>
                        <p class="text-xs text-white/40">Select your preferred method below</p>
                    </div>
                </div>
                <div class="bg-white/3 rounded-xl px-5 py-3 ring-1 ring-white/6 text-center sm:text-right">
                    <p class="text-[10px] text-white/30 uppercase tracking-widest font-bold">Amount Due</p>
                    <p class="text-xl font-black text-white mt-0.5">{{ $cs }}{{ number_format($invoice->total, 2) }}</p>
                </div>
            </div>

            <form action="{{ route('client.payments.initiate') }}" method="POST" enctype="multipart/form-data" @submit="submitting = true">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="amount" value="{{ $invoice->total }}">

                <div class="p-6 space-y-3">
                    <p class="text-[10px] text-white/25 uppercase tracking-widest font-bold mb-1">Payment Method</p>

                    {{-- ── Paystack ── --}}
                    @if(($settings['enable_paystack'] ?? '0') === '1')
                    <div class="rounded-xl border-2 transition-all duration-300 overflow-hidden"
                         :class="gateway === 'paystack' ? 'border-primary-500 bg-primary-500/5' : 'border-white/6 hover:border-white/12'">
                        <label class="flex items-center gap-4 p-4 cursor-pointer" @click="gateway = 'paystack'">
                            <input type="radio" name="gateway" value="paystack" class="hidden" x-model="gateway">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-green-500/20 to-teal-500/20 ring-1 ring-green-500/20 flex items-center justify-center shrink-0">
                                <i class="fas fa-credit-card text-green-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-white text-sm">Paystack</span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-green-500/10 text-green-400 ring-1 ring-green-500/20">Instant</span>
                                </div>
                                <p class="text-xs text-white/35 mt-0.5">Card, bank transfer, or USSD</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all"
                                 :class="gateway === 'paystack' ? 'border-primary-500 bg-primary-500' : 'border-white/15'">
                                <i class="fas fa-check text-[10px] text-white" x-show="gateway === 'paystack'" x-cloak></i>
                            </div>
                        </label>
                        <div x-show="gateway === 'paystack'" x-cloak x-collapse>
                            <div class="px-4 pb-4 border-t border-white/5">
                                <div class="bg-white/3 rounded-lg p-4 mt-3 flex items-start gap-3">
                                    <i class="fas fa-shield-alt text-green-400/50 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-white/50 leading-relaxed">You'll be redirected to Paystack's secure checkout to complete your payment. Your card details are never stored on our servers.</p>
                                        <div class="flex flex-wrap items-center gap-2 mt-3">
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">VISA</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">Mastercard</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">Verve</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">Bank</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">USSD</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ── Flutterwave ── --}}
                    @if(($settings['enable_flutterwave'] ?? '0') === '1')
                    <div class="rounded-xl border-2 transition-all duration-300 overflow-hidden"
                         :class="gateway === 'flutterwave' ? 'border-primary-500 bg-primary-500/5' : 'border-white/6 hover:border-white/12'">
                        <label class="flex items-center gap-4 p-4 cursor-pointer" @click="gateway = 'flutterwave'">
                            <input type="radio" name="gateway" value="flutterwave" class="hidden" x-model="gateway">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-orange-500/20 to-yellow-500/20 ring-1 ring-orange-500/20 flex items-center justify-center shrink-0">
                                <i class="fas fa-wallet text-orange-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-white text-sm">Flutterwave</span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20">Instant</span>
                                </div>
                                <p class="text-xs text-white/35 mt-0.5">Card, mobile money, or bank account</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all"
                                 :class="gateway === 'flutterwave' ? 'border-primary-500 bg-primary-500' : 'border-white/15'">
                                <i class="fas fa-check text-[10px] text-white" x-show="gateway === 'flutterwave'" x-cloak></i>
                            </div>
                        </label>
                        <div x-show="gateway === 'flutterwave'" x-cloak x-collapse>
                            <div class="px-4 pb-4 border-t border-white/5">
                                <div class="bg-white/3 rounded-lg p-4 mt-3 flex items-start gap-3">
                                    <i class="fas fa-shield-alt text-orange-400/50 mt-0.5"></i>
                                    <div>
                                        <p class="text-xs text-white/50 leading-relaxed">You'll be redirected to Flutterwave's secure checkout. Supports cards, mobile money, and direct bank payments across Africa.</p>
                                        <div class="flex flex-wrap items-center gap-2 mt-3">
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">VISA</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">Mastercard</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">M-Pesa</span>
                                            <span class="px-2 py-0.5 rounded bg-white/5 text-white/40 text-[10px] font-bold">Bank</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ── Bank Transfer ── --}}
                    @if(($settings['enable_bank_transfer'] ?? '0') === '1')
                    <div class="rounded-xl border-2 transition-all duration-300 overflow-hidden"
                         :class="gateway === 'bank_transfer' ? 'border-primary-500 bg-primary-500/5' : 'border-white/6 hover:border-white/12'">
                        <label class="flex items-center gap-4 p-4 cursor-pointer" @click="gateway = 'bank_transfer'">
                            <input type="radio" name="gateway" value="bank_transfer" class="hidden" x-model="gateway">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 ring-1 ring-blue-500/20 flex items-center justify-center shrink-0">
                                <i class="fas fa-university text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-white text-sm">Bank Transfer</span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20">Manual</span>
                                </div>
                                <p class="text-xs text-white/35 mt-0.5">Transfer directly to our bank account</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all"
                                 :class="gateway === 'bank_transfer' ? 'border-primary-500 bg-primary-500' : 'border-white/15'">
                                <i class="fas fa-check text-[10px] text-white" x-show="gateway === 'bank_transfer'" x-cloak></i>
                            </div>
                        </label>
                        <div x-show="gateway === 'bank_transfer'" x-cloak x-collapse>
                            <div class="px-4 pb-5 border-t border-white/5 space-y-4 pt-3">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="p-3 rounded-lg bg-white/3 border border-white/5">
                                        <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Bank Name</p>
                                        <p class="text-sm text-white font-semibold">{{ $settings['bank_name'] ?? 'Not configured' }}</p>
                                    </div>
                                    <div class="p-3 rounded-lg bg-white/3 border border-white/5">
                                        <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Account Name</p>
                                        <p class="text-sm text-white font-semibold">{{ $settings['bank_account_name'] ?? 'Not configured' }}</p>
                                    </div>
                                    <div class="p-3 rounded-lg bg-white/3 border border-white/5">
                                        <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Account Number</p>
                                        <p class="text-lg text-white font-mono font-bold select-all">{{ $settings['bank_account_number'] ?? 'Not configured' }}</p>
                                    </div>
                                    @if($settings['bank_sort_code'] ?? false)
                                    <div class="p-3 rounded-lg bg-white/3 border border-white/5">
                                        <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Sort Code / Routing</p>
                                        <p class="text-sm text-white font-semibold">{{ $settings['bank_sort_code'] }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="p-3 rounded-lg bg-primary-500/5 border border-primary-500/15">
                                    <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1">Transfer Exactly</p>
                                    <p class="text-lg text-white font-bold">{{ $cs }}{{ number_format($invoice->total, 2) }}</p>
                                    <p class="text-[10px] text-white/30 mt-0.5">Use <strong class="text-white/50">{{ $invoice->invoice_number }}</strong> as payment reference</p>
                                </div>
                                @if($settings['bank_instructions'] ?? false)
                                <div class="p-3 rounded-lg bg-amber-500/5 border border-amber-500/15">
                                    <p class="text-xs text-amber-400/80"><i class="fas fa-info-circle mr-1.5"></i>{{ $settings['bank_instructions'] }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="label">Proof of Payment <span class="text-red-400">*</span></label>
                                    <input type="file" name="proof_of_payment" accept=".jpg,.jpeg,.png,.pdf" :disabled="gateway !== 'bank_transfer'" class="input-field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25">
                                    <p class="text-xs text-white/25 mt-1">Upload receipt or screenshot (JPG, PNG, PDF — max 5MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ── Cryptocurrency ── --}}
                    @if(($settings['enable_crypto'] ?? '0') === '1')
                    <div class="rounded-xl border-2 transition-all duration-300 overflow-hidden"
                         :class="gateway === 'crypto' ? 'border-primary-500 bg-primary-500/5' : 'border-white/6 hover:border-white/12'">
                        <div class="flex items-center gap-4 p-4 cursor-pointer" @click="gateway = 'crypto'; $nextTick(() => { if(!document.querySelector('input[name=gateway][value=crypto]').checked) document.querySelector('input[name=gateway][value=crypto]').checked = true })">
                            <input type="radio" name="gateway" value="crypto" class="hidden" x-model="gateway">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500/20 to-orange-500/20 ring-1 ring-amber-500/20 flex items-center justify-center shrink-0">
                                <i class="fab fa-bitcoin text-amber-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-white text-sm">Cryptocurrency</span>
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20">Manual</span>
                                </div>
                                <p class="text-xs text-white/35 mt-0.5">Bitcoin, USDT, Ethereum, and more</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all"
                                 :class="gateway === 'crypto' ? 'border-primary-500 bg-primary-500' : 'border-white/15'">
                                <i class="fas fa-check text-[10px] text-white" x-show="gateway === 'crypto'" x-cloak></i>
                            </div>
                        </div>
                        <div x-show="gateway === 'crypto'" x-cloak x-collapse>
                            <div class="px-4 pb-5 border-t border-white/5 space-y-4 pt-3">
                                @if($cryptoWallets->count())
                                <p class="text-xs text-white/40">Select cryptocurrency:</p>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach($cryptoWallets as $wallet)
                                    <div class="cursor-pointer rounded-lg border-2 p-3 transition-all"
                                         :class="selectedWallet === {{ $wallet->id }} ? 'border-amber-500 bg-amber-500/5' : 'border-white/6 hover:border-white/15'"
                                         @click.stop="selectedWallet = {{ $wallet->id }}; document.getElementById('wallet-{{ $wallet->id }}').checked = true">
                                        <input type="radio" name="crypto_wallet_id" value="{{ $wallet->id }}" id="wallet-{{ $wallet->id }}" class="hidden" :disabled="gateway !== 'crypto'">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                                 :class="selectedWallet === {{ $wallet->id }} ? 'bg-amber-500/15 ring-1 ring-amber-500/30' : 'bg-white/5 ring-1 ring-white/8'">
                                                <i class="{{ $wallet->icon ?? 'fab fa-bitcoin' }} text-amber-400"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-white text-sm truncate">{{ $wallet->name }}</p>
                                                <p class="text-[10px] text-white/30">{{ $wallet->symbol }}@if($wallet->network) · {{ $wallet->network }}@endif</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                @foreach($cryptoWallets as $wallet)
                                <div x-show="selectedWallet === {{ $wallet->id }}" x-cloak x-transition class="rounded-xl bg-white/3 border border-white/6 p-5">
                                    <div class="flex flex-col md:flex-row items-center gap-5">
                                        <div class="bg-white rounded-xl p-2 shrink-0">
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($wallet->wallet_address) }}" alt="QR" class="w-28 h-28">
                                        </div>
                                        <div class="flex-1 min-w-0 text-center md:text-left">
                                            <p class="text-[10px] text-white/25 uppercase tracking-wide mb-1.5">Send {{ $wallet->symbol }} to:</p>
                                            <div class="bg-surface-900/60 rounded-lg p-3 relative group">
                                                <p class="text-xs font-mono text-white break-all select-all pr-8" id="addr-{{ $wallet->id }}">{{ $wallet->wallet_address }}</p>
                                                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('addr-{{ $wallet->id }}').textContent);this.innerHTML='<i class=\'fas fa-check text-emerald-400\'></i>';setTimeout(()=>this.innerHTML='<i class=\'fas fa-copy\'></i>',2000)" class="absolute top-2 right-2 w-7 h-7 rounded bg-white/5 hover:bg-white/10 flex items-center justify-center text-white/30 hover:text-white transition-all"><i class="fas fa-copy"></i></button>
                                            </div>
                                            @if($wallet->network)
                                            <p class="text-[11px] text-amber-400/70 mt-2"><i class="fas fa-exclamation-triangle mr-1"></i>Network: <strong>{{ $wallet->network }}</strong> — wrong network = lost funds</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="text-center py-6">
                                    <i class="fab fa-bitcoin text-white/10 text-3xl mb-2 block"></i>
                                    <p class="text-white/30 text-sm">No crypto wallets available.</p>
                                </div>
                                @endif

                                @if($cryptoWallets->count())
                                <div>
                                    <label class="label">Proof of Payment <span class="text-red-400">*</span></label>
                                    <input type="file" name="proof_of_payment" accept=".jpg,.jpeg,.png,.pdf" :disabled="gateway !== 'crypto'" class="input-field file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500/15 file:text-primary-400 hover:file:bg-primary-500/25">
                                    <p class="text-xs text-white/25 mt-1">Upload transaction screenshot (JPG, PNG, PDF — max 5MB)</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Submit --}}
                <div x-show="gateway" x-cloak x-transition class="p-6 border-t border-white/5 bg-white/2">
                    <button type="submit" :disabled="submitting" class="btn-primary w-full py-3.5 text-sm font-bold disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="submitting"><i class="fas fa-spinner fa-spin mr-2"></i>Processing...</span>
                        <span x-show="!submitting && (gateway === 'paystack' || gateway === 'flutterwave')"><i class="fas fa-lock mr-2"></i>Pay {{ $cs }}{{ number_format($invoice->total, 2) }} Securely</span>
                        <span x-show="!submitting && gateway === 'bank_transfer'"><i class="fas fa-upload mr-2"></i>Submit Bank Transfer Proof</span>
                        <span x-show="!submitting && gateway === 'crypto'"><i class="fas fa-upload mr-2"></i>Submit Crypto Payment Proof</span>
                    </button>
                    <p class="text-center text-[10px] text-white/20 mt-3"><i class="fas fa-lock mr-1"></i>All transactions are encrypted and secure</p>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>

{{-- Print/PDF Script --}}
<script>
function printInvoice() {
    const content = document.getElementById('invoice-content').innerHTML;
    const logoUrl = '{{ !empty($invoiceLogo) ? asset($invoiceLogo) : '' }}';
    const siteName = '{{ $siteSettings['site_name'] ?? 'ICodeDev' }}';
    const tagline = '{{ $siteSettings['site_tagline'] ?? 'Technology Solutions' }}';
    const brandHtml = logoUrl
        ? `<img src="${logoUrl}" alt="${siteName}" style="height:50px;margin-bottom:8px">`
        : `<div style="font-size:24px;font-weight:800;color:#4f46e5">${siteName}</div>`;

    const win = window.open('', '_blank');
    win.document.write(`<!DOCTYPE html><html><head><title>{{ $invoice->invoice_number }}</title><style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter','Segoe UI',Arial,sans-serif;padding:40px;color:#1f2937;font-size:14px;line-height:1.6}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:10px 0;font-size:10px;text-transform:uppercase;letter-spacing:1.5px;color:#9ca3af;font-weight:700;border-bottom:2px solid #e5e7eb}
        td{padding:12px 0;border-bottom:1px solid #f3f4f6;font-size:13px}
        .print-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;padding-bottom:24px;border-bottom:2px solid #e5e7eb}
        .brand-block img{height:50px}
        .tagline{color:#9ca3af;font-size:12px;margin-top:4px}
        .contact-line{color:#9ca3af;font-size:11px;margin-top:2px}
        .inv-label{font-size:10px;text-transform:uppercase;letter-spacing:2px;color:#9ca3af;font-weight:700;margin-bottom:4px}
        .inv-num{font-size:18px;font-weight:700;color:#1f2937}
        .meta{color:#6b7280;font-size:12px;margin-top:3px}
        .section-label{font-size:9px;text-transform:uppercase;letter-spacing:2px;color:#9ca3af;font-weight:700;margin-bottom:8px}
        .bill-grid{display:flex;gap:40px;margin:24px 0 32px}
        .bill-grid>div{flex:1}
        .bill-name{font-weight:600;font-size:14px;color:#1f2937}
        .bill-detail{font-size:12px;color:#6b7280;margin-top:2px}
        .summary-item{display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;margin-top:4px}
        .totals{margin-left:auto;width:260px;margin-top:16px}
        .totals .row{display:flex;justify-content:space-between;padding:4px 0;font-size:13px;color:#6b7280}
        .totals .total{border-top:2px solid #1f2937;padding-top:10px;margin-top:6px;font-size:18px;font-weight:800;color:#1f2937}
        .notes-box{margin-top:32px;padding:16px;background:#f9fafb;border-radius:8px;border:1px solid #e5e7eb}
        .notes-box .notes-label{font-size:9px;text-transform:uppercase;letter-spacing:2px;color:#9ca3af;font-weight:700;margin-bottom:6px}
        .notes-box p{font-size:12px;color:#6b7280}
        .hidden-print{display:none}
        @media print{body{padding:20px}}
    </style></head><body>
    <div class="print-header">
        <div class="brand-block">
            ${brandHtml}
            <div class="tagline">${tagline}</div>
            @if($siteSettings['contact_email'] ?? false)<div class="contact-line">{{ $siteSettings['contact_email'] }}</div>@endif
            @if($siteSettings['contact_phone'] ?? false)<div class="contact-line">{{ $siteSettings['contact_phone'] }}</div>@endif
            @if($siteSettings['contact_address'] ?? false)<div class="contact-line">{{ $siteSettings['contact_address'] }}</div>@endif
        </div>
        <div style="text-align:right">
            <div class="inv-label">Invoice</div>
            <div class="inv-num">{{ $invoice->invoice_number }}</div>
            <div class="meta">Issued: {{ $invoice->issue_date?->format('M d, Y') ?? $invoice->created_at->format('M d, Y') }}</div>
            <div class="meta">Due: {{ $invoice->due_date?->format('M d, Y') ?? '—' }}</div>
            @if($invoice->paid_date)<div class="meta" style="color:#059669">Paid: {{ $invoice->paid_date->format('M d, Y') }}</div>@endif
        </div>
    </div>
    <div class="bill-grid">
        <div>
            <div class="section-label">Bill To</div>
            <div class="bill-name">{{ $invoice->user->name }}</div>
            <div class="bill-detail">{{ $invoice->user->email }}</div>
            @if($invoice->user->company)<div class="bill-detail">{{ $invoice->user->company }}</div>@endif
            @if($invoice->user->phone)<div class="bill-detail">{{ $invoice->user->phone }}</div>@endif
        </div>
        <div>
            <div class="section-label">Details</div>
            @if($invoice->project)<div class="bill-detail">Project: {{ $invoice->project->title }}</div>@endif
            <div class="bill-detail">Status: {{ ucfirst($invoice->status) }}</div>
            <div class="bill-detail">Currency: {{ $settings['currency_code'] ?? 'NGN' }}</div>
        </div>
    </div>
    <table>
        <thead><tr><th style="width:50%">Description</th><th style="text-align:center;width:15%">Qty</th><th style="text-align:right;width:15%">Rate</th><th style="text-align:right;width:20%">Amount</th></tr></thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr><td>{{ $item->description }}</td><td style="text-align:center">{{ $item->quantity }}</td><td style="text-align:right">{{ $cs }}{{ number_format($item->unit_price, 2) }}</td><td style="text-align:right;font-weight:600">{{ $cs }}{{ number_format($item->total, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>
    <div class="totals">
        <div class="row"><span>Subtotal</span><span>{{ $cs }}{{ number_format($invoice->subtotal, 2) }}</span></div>
        @if($invoice->tax > 0)<div class="row"><span>Tax</span><span>{{ $cs }}{{ number_format($invoice->tax, 2) }}</span></div>@endif
        @if($invoice->discount > 0)<div class="row"><span>Discount</span><span style="color:#059669">-{{ $cs }}{{ number_format($invoice->discount, 2) }}</span></div>@endif
        <div class="row total"><span>Total Due</span><span>{{ $cs }}{{ number_format($invoice->total, 2) }}</span></div>
    </div>
    @if($invoice->notes)<div class="notes-box"><div class="notes-label">Notes</div><p>{{ $invoice->notes }}</p></div>@endif
    </body></html>`);
    win.document.close();
    win.focus();
    setTimeout(() => { win.print(); win.close(); }, 500);
}
</script>
@endsection
