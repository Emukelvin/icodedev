<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = Setting::getAllCached();
        $enabled = ($settings['enable_email_verification'] ?? '0') === '1';

        if ($enabled
            && $request->user()
            && !$request->user()->isAdmin()
            && !$request->user()->hasVerifiedEmail()
        ) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
