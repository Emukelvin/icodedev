@extends('layouts.dashboard')
@section('title', 'Newsletter Subscribers')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-black text-white">Newsletter Subscribers</h1>
        <p class="text-white/50 mt-1">{{ $subscribers->total() }} total subscribers</p>
    </div>
    <button onclick="document.getElementById('send-newsletter').classList.toggle('hidden')" class="btn-primary"><i class="fas fa-paper-plane mr-2"></i>Send Newsletter</button>
</div>

{{-- Send Newsletter Form --}}
<div id="send-newsletter" class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 p-6 mb-8 hidden">
    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-5">Compose Newsletter</h3>
    <form action="{{ route('admin.cms.newsletters.send') }}" method="POST" onsubmit="return confirm('Send to all {{ $subscribers->total() }} subscribers?')">
        @csrf
        <div class="space-y-4">
            <div><label class="label">Subject *</label><input type="text" name="subject" class="input-field" required placeholder="Newsletter subject line..."></div>
            <div><label class="label">Body *</label><textarea name="body" rows="8" class="input-field" required placeholder="Write your newsletter content..."></textarea></div>
            <div class="flex justify-end"><button type="submit" class="btn-primary"><i class="fas fa-paper-plane mr-2"></i>Send to All Subscribers</button></div>
        </div>
    </form>
</div>

<div class="bg-surface-800/60 backdrop-blur-sm rounded-2xl border border-white/6 overflow-hidden">
    <table class="data-table w-full">
        <thead><tr>
            <th class="table-header">#</th>
            <th class="table-header">Email</th>
            <th class="table-header">Subscribed At</th>
            <th class="table-header">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-white/6">
        @forelse($subscribers as $sub)
        <tr>
            <td class="table-cell">{{ $loop->iteration + ($subscribers->currentPage() - 1) * $subscribers->perPage() }}</td>
            <td class="table-cell font-medium">{{ $sub->email }}</td>
            <td class="table-cell">{{ $sub->created_at->format('M d, Y') }}</td>
            <td class="table-cell">
                <form action="{{ route('admin.cms.newsletters.destroy', $sub) }}" method="POST" onsubmit="return confirm('Remove this subscriber?')">
                    @csrf @method('DELETE')
                    <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="table-cell text-center py-12 text-white/50">No subscribers yet</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $subscribers->links() }}</div>
@endsection
