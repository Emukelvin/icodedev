<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Managers cannot see admin accounts
        if (!auth()->user()->isAdmin()) {
            $query->where('role', '!=', 'admin');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"));
        }

        $users = $query->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User;
        return view('admin.users.form', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'role' => 'required|in:admin,manager,developer,client',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        ActivityLog::log('user_created', "User '{$user->name}' created", $user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        // Managers cannot view admin accounts
        if (!auth()->user()->isAdmin() && $user->role === 'admin') {
            abort(403);
        }

        $user->load([
            'clientProjects',
            'payments' => fn($q) => $q->latest(),
            'invoices' => fn($q) => $q->latest(),
            'activityLogs' => fn($q) => $q->latest()->take(20),
            'tasks' => fn($q) => $q->latest()->take(10),
        ]);

        $totalPaid = $user->payments->where('status', 'successful')->sum('amount');
        $totalInvoiced = $user->invoices->sum('total');

        return view('admin.users.show', compact('user', 'totalPaid', 'totalInvoiced'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin() && $user->role === 'admin') {
            abort(403);
        }
        // Managers can only edit their own manager account, not other managers
        if (!auth()->user()->isAdmin() && $user->role === 'manager' && $user->id !== auth()->id()) {
            abort(403);
        }
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin() && $user->role === 'admin') {
            abort(403);
        }
        // Managers can only update their own manager account
        if (!auth()->user()->isAdmin() && $user->role === 'manager' && $user->id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'role' => 'required|in:admin,manager,developer,client',
            'is_active' => 'boolean',
        ]);

        $user->update($validated);
        ActivityLog::log('user_updated', "User '{$user->name}' updated", $user);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if (!auth()->user()->isAdmin() && $user->role === 'admin') {
            abort(403);
        }

        // Managers cannot delete other managers
        if (!auth()->user()->isAdmin() && $user->role === 'manager') {
            abort(403);
        }

        ActivityLog::log('user_deleted', "User '{$user->name}' deleted", $user);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$status} successfully.");
    }
}
