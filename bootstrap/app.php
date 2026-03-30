<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\TrackActivity;
use App\Http\Middleware\Verify2FA;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\MarkBadgeRead;

use App\Http\Middleware\EnsureEmailIsVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            '2fa' => Verify2FA::class,
            'verified' => EnsureEmailIsVerified::class,
        ]);
        $middleware->append(TrackActivity::class);
        $middleware->append(MarkBadgeRead::class);
        $middleware->appendToGroup('web', CheckMaintenanceMode::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
