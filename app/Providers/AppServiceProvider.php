<?php

namespace App\Providers;

use App\Models\Setting;
use App\Http\ViewComposers\SidebarBadgeComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $siteSettings = Setting::getAllCached();
            View::share('siteSettings', $siteSettings);
            View::share('cs', $siteSettings['currency_symbol'] ?? '₦');
        } catch (\Exception $e) {
            View::share('siteSettings', []);
            View::share('cs', '₦');
        }

        View::composer([
            'admin.partials.sidebar',
            'client.partials.sidebar',
            'developer.partials.sidebar',
        ], SidebarBadgeComposer::class);
    }
}
