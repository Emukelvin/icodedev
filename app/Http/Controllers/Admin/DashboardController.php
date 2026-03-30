<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\ContactSubmission;
use App\Models\QuoteRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_developers' => User::where('role', 'developer')->count(),
            'active_projects' => Project::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_projects' => Project::where('status', 'completed')->count(),
            'total_revenue' => Payment::successful()->sum('amount'),
            'monthly_revenue' => Payment::successful()->whereMonth('created_at', now()->month)->sum('amount'),
            'pending_invoices' => Invoice::whereIn('status', ['sent', 'pending'])->count(),
            'new_contacts' => ContactSubmission::where('status', 'new')->count(),
            'new_quotes' => QuoteRequest::where('status', 'new')->count(),
        ];

        $recentProjects = Project::with('client', 'service')->latest()->take(5)->get();
        $recentPayments = Payment::with('user', 'project')->latest()->take(5)->get();
        $recentContacts = ContactSubmission::latest()->take(5)->get();

        $monthlyRevenue = Payment::successful()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentPayments', 'recentContacts', 'monthlyRevenue'));
    }
}
