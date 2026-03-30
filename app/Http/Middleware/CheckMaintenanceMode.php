<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Routes that are always accessible during maintenance mode.
     */
    protected array $except = [
        'login',
        'login/*',
        'logout',
        'password/*',
        'forgot-password',
        'reset-password/*',
        'two-factor*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (Setting::get('maintenance_mode', '0') !== '1') {
            return $next($request);
        }

        // Always allow excluded routes (login, logout, password reset)
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // Authenticated admin, manager, or developer can access everything
        if ($request->user() && in_array($request->user()->role, ['admin', 'manager', 'developer'])) {
            return $next($request);
        }

        // Authenticated clients can only access logout
        // Everyone else sees the maintenance page
        $settings = Setting::getAllCached();

        return response()->view('maintenance', [
            'siteSettings' => $settings,
        ], 503);
    }
}
