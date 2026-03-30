<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // last_login_at/ip is updated in AuthController@login only

        return $response;
    }
}
