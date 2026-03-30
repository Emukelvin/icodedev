@extends('layouts.dashboard')
@section('title', ($invoice->exists ? 'Edit' : 'Create') . ' Invoice - ICodeDev Admin')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.invoices.index') }}" class="text-white/30 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
    <div><h1 class="text-2xl font-black text-white">{{ $invoice->exists ? 'Edit' : 'Create' }} Invoice</h1><p class="text-sm text-white/50 mt-1">{{ $invoice->exists ? 'Update invoice details and items' : 'Create a new invoice for a client' }}</p></div>
</div>

<form action="{{ $invoice->exists ? route('admin.invoices.update', $invoice) : route('admin.invoices.store') }}" method="POST"
      class="max-w-4xl space-y-6" id="invoice-form"
      x-data="invoiceForm()" x-init="init()">
    @csrf
    @if($invoice->exists) @method('PUT') @endif

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-exclamation-circle text-red-400"></i>
            <h3 class="text-sm font-bold text-red-400">Please fix the following errors:</h3>
        </div>
        <ul class="list-disc list-inside text-sm text-red-300/80 space-y-1 ml-7">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Client & Project Selection --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-primary-500/15 flex items-center justify-center"><i class="fas fa-user text-primary-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Client & Project</h2>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid md:grid-cols-2 gap-5">
                {{-- Client Select --}}
                <div>
                    <label class="label">Client <span class="text-red-400">*</span></label>
                    <select name="user_id" class="input-field" required x-model="selectedClient" @change="onClientChange()">
                        <option value="">Select Client</option>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('user_id', $invoice->user_id) == $client->id ? 'selected' : '' }}>{{ $client->name }} ({{ $client->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="label">Status</label>
                    <select name="status" class="input-field">
                        @foreach(['draft','sent','pending','paid','overdue','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $invoice->status ?? 'draft') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Project Select (dynamic) --}}
            <div>
                <label class="label">Project</label>

                {{-- Loading state --}}
                <div x-show="loading" class="input-field flex items-center gap-2 text-white/30">
                    <i class="fas fa-spinner fa-spin text-xs"></i> Loading projects...
                </div>

                {{-- No client selected --}}
                <div x-show="!selectedClient && !loading" class="input-field text-white/30 cursor-not-allowed">
                    <i class="fas fa-info-circle mr-2 text-xs"></i> Select a client first
                </div>

                {{-- Project dropdown --}}
                <div x-show="selectedClient && !loading" x-cloak>
                    <select name="project_id" class="input-field" x-ref="projectSelect"
                            x-effect="$refs.projectSelect && ($refs.projectSelect.innerHTML = projectOptionsHtml); $nextTick(() => { if($refs.projectSelect) $refs.projectSelect.value = selectedProject; })"
                            @change="selectedProject = $event.target.value; onProjectChange()"></select>
                </div>

                {{-- No projects message --}}
                <div x-show="selectedClient && !loading && projects.length === 0" x-cloak class="mt-2 text-xs text-white/40">
                    <i class="fas fa-info-circle mr-1"></i> This client has no projects yet.
                </div>
            </div>

            {{-- Project Info Card --}}
            <div x-show="selectedProjectData" x-cloak
                 class="bg-surface-900/60 rounded-xl border border-white/5 p-5 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                         :class="selectedProjectData?.is_paid ? 'bg-emerald-500/15' : 'bg-amber-500/15'">
                        <i class="text-xs" :class="selectedProjectData?.is_paid ? 'fas fa-check-circle text-emerald-400' : 'fas fa-clock text-amber-400'"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white" x-text="selectedProjectData?.title"></h4>
                        <p class="text-[11px] text-white/40">
                            Status: <span class="capitalize" x-text="selectedProjectData?.status?.replace('_', ' ')"></span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-3 rounded-lg bg-white/5">
                        <div class="text-xs text-white/40 mb-1">Budget</div>
                        <div class="text-sm font-bold text-white">{{ $cs }}<span x-text="formatNumber(selectedProjectData?.budget || 0)"></span></div>
                    </div>
                    <div class="text-center p-3 rounded-lg bg-white/5">
                        <div class="text-xs text-white/40 mb-1">Paid</div>
                        <div class="text-sm font-bold text-emerald-400">{{ $cs }}<span x-text="formatNumber(selectedProjectData?.total_paid || 0)"></span></div>
                    </div>
                    <div class="text-center p-3 rounded-lg" :class="selectedProjectData?.balance > 0 ? 'bg-amber-500/10' : 'bg-emerald-500/10'">
                        <div class="text-xs text-white/40 mb-1">Balance</div>
                        <div class="text-sm font-bold" :class="selectedProjectData?.balance > 0 ? 'text-amber-400' : 'text-emerald-400'">{{ $cs }}<span x-text="formatNumber(selectedProjectData?.balance || 0)"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dates --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-secondary-500/15 flex items-center justify-center"><i class="fas fa-calendar-alt text-secondary-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Dates</h2>
        </div>
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Due Date <span class="text-red-400">*</span></label>
                    <input type="date" name="due_date" class="input-field" value="{{ old('due_date', $invoice->due_date?->format('Y-m-d')) }}" required>
                    @error('due_date')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Line Items --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500/15 flex items-center justify-center"><i class="fas fa-list text-amber-400 text-sm"></i></div>
                <h2 class="text-sm font-bold text-white">Invoice Items</h2>
            </div>
            <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary-500/15 text-primary-400 ring-1 ring-primary-500/20 hover:bg-primary-500/25 transition-all" id="add-invoice-item"><i class="fas fa-plus mr-1.5"></i>Add Item</button>
        </div>
        <div class="p-6">
            {{-- Header --}}
            <div class="grid grid-cols-12 gap-2 mb-3 px-1 hidden md:grid">
                <div class="col-span-6 text-[10px] font-bold text-white/30 uppercase tracking-wider">Description</div>
                <div class="col-span-2 text-[10px] font-bold text-white/30 uppercase tracking-wider">Qty</div>
                <div class="col-span-3 text-[10px] font-bold text-white/30 uppercase tracking-wider">Unit Price</div>
                <div class="col-span-1"></div>
            </div>
            <div id="invoice-items-container" class="space-y-3 mb-4">
                @foreach(old('items', $invoice->items?->toArray() ?: [['description' => '', 'quantity' => 1, 'unit_price' => '']]) as $i => $item)
                <div class="grid grid-cols-12 gap-2 items-end invoice-item">
                    <div class="col-span-6"><input type="text" name="items[{{ $i }}][description]" class="input-field" placeholder="Description" value="{{ $item['description'] ?? '' }}" required></div>
                    <div class="col-span-2"><input type="number" name="items[{{ $i }}][quantity]" class="input-field" placeholder="Qty" value="{{ $item['quantity'] ?? 1 }}" min="1" required></div>
                    <div class="col-span-3"><input type="number" name="items[{{ $i }}][unit_price]" class="input-field" placeholder="Price" value="{{ $item['unit_price'] ?? '' }}" step="0.01" required></div>
                    <div class="col-span-1 flex justify-center"><button type="button" class="text-red-400 hover:text-red-300 p-2 transition-colors" onclick="this.closest('.invoice-item').remove()"><i class="fas fa-times"></i></button></div>
                </div>
                @endforeach
            </div>
            <template id="invoice-item-template">
                <div class="grid grid-cols-12 gap-2 items-end invoice-item">
                    <div class="col-span-6"><input type="text" name="items[__INDEX__][description]" class="input-field" placeholder="Description" required></div>
                    <div class="col-span-2"><input type="number" name="items[__INDEX__][quantity]" class="input-field" placeholder="Qty" value="1" min="1" required></div>
                    <div class="col-span-3"><input type="number" name="items[__INDEX__][unit_price]" class="input-field" placeholder="Price" step="0.01" required></div>
                    <div class="col-span-1 flex justify-center"><button type="button" class="text-red-400 hover:text-red-300 p-2 transition-colors" onclick="this.closest('.invoice-item').remove()"><i class="fas fa-times"></i></button></div>
                </div>
            </template>
        </div>
    </div>

    {{-- Tax, Discount & Notes --}}
    <div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
        <div class="p-5 border-b border-white/5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-500/15 flex items-center justify-center"><i class="fas fa-receipt text-emerald-400 text-sm"></i></div>
            <h2 class="text-sm font-bold text-white">Additional Details</h2>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="label">Tax ({{ $cs }})</label><input type="number" name="tax" step="0.01" class="input-field" value="{{ old('tax', $invoice->tax ?? 0) }}"></div>
                <div><label class="label">Discount ({{ $cs }})</label><input type="number" name="discount" step="0.01" class="input-field" value="{{ old('discount', $invoice->discount ?? 0) }}"></div>
            </div>
            <div><label class="label">Notes</label><textarea name="notes" rows="3" class="input-field" placeholder="Additional notes for the client...">{{ old('notes', $invoice->notes) }}</textarea></div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.invoices.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>{{ $invoice->exists ? 'Update' : 'Create' }} Invoice</button>
    </div>
</form>

@push('scripts')
<script>
function invoiceForm() {
    return {
        selectedClient: '{{ old('user_id', $invoice->user_id) }}',
        selectedProject: '{{ old('project_id', $invoice->project_id) }}',
        projects: [],
        selectedProjectData: null,
        loading: false,

        init() {
            if (this.selectedClient) {
                this.fetchProjects(this.selectedClient);
            }
        },

        onClientChange() {
            this.selectedProject = '';
            this.selectedProjectData = null;
            this.projects = [];
            if (this.selectedClient) {
                this.fetchProjects(this.selectedClient);
            }
        },

        onProjectChange() {
            if (this.selectedProject) {
                this.selectedProjectData = this.projects.find(p => p.id == this.selectedProject) || null;
            } else {
                this.selectedProjectData = null;
            }
        },

        async fetchProjects(clientId) {
            this.loading = true;
            try {
                const response = await fetch(`/admin/clients/${clientId}/projects`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!response.ok) throw new Error('Failed to fetch');
                this.projects = await response.json();

                // Auto-select the project if editing
                if (this.selectedProject) {
                    this.selectedProjectData = this.projects.find(p => p.id == this.selectedProject) || null;
                }
            } catch (e) {
                this.projects = [];
            }
            this.loading = false;
        },

        get unpaidProjects() {
            return this.projects.filter(p => !p.is_paid);
        },

        get paidProjects() {
            return this.projects.filter(p => p.is_paid);
        },

        get projectOptionsHtml() {
            let html = '<option value="">No project (general invoice)</option>';
            const unpaid = this.unpaidProjects;
            const paid = this.paidProjects;
            if (unpaid.length) {
                html += '<optgroup label="Outstanding Balance">';
                unpaid.forEach(p => {
                    const sel = this.selectedProject == p.id ? ' selected' : '';
                    html += `<option value="${p.id}"${sel}>${this.escHtml(p.title)} — Balance: {{ $cs }}${this.formatNumber(p.balance)}</option>`;
                });
                html += '</optgroup>';
            }
            if (paid.length) {
                html += '<optgroup label="Fully Paid">';
                paid.forEach(p => {
                    const sel = this.selectedProject == p.id ? ' selected' : '';
                    html += `<option value="${p.id}"${sel}>${this.escHtml(p.title)} (Paid)</option>`;
                });
                html += '</optgroup>';
            }
            return html;
        },

        escHtml(str) {
            const d = document.createElement('div');
            d.textContent = str;
            return d.innerHTML;
        },

        formatNumber(num) {
            return Number(num || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    };
}
</script>
@endpush
@endsection
