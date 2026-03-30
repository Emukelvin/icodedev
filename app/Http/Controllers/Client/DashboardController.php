<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->clientProjects()->with('service')->latest()->take(5)->get();
        $activeProjects = $user->clientProjects()->whereNotIn('status', ['completed', 'cancelled'])->count();
        $completedProjects = $user->clientProjects()->where('status', 'completed')->count();
        $totalSpent = $user->payments()->successful()->sum('amount');
        $pendingInvoices = $user->invoices()->whereIn('status', ['sent', 'pending'])->count();
        $recentPayments = $user->payments()->with('project')->latest()->take(5)->get();
        $invoices = $user->invoices()->with('project')->latest()->take(5)->get();

        return view('client.dashboard', compact(
            'projects', 'activeProjects', 'completedProjects',
            'totalSpent', 'pendingInvoices', 'recentPayments', 'invoices'
        ));
    }
}
