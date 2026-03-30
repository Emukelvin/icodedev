<?php

namespace App\Http\Middleware;

use App\Http\ViewComposers\SidebarBadgeComposer;
use App\Models\BadgeRead;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkBadgeRead
{
    private const ROUTE_BADGE_MAP = [
        // Admin routes
        'admin.tasks.index'      => 'tasks',
        'admin.tasks.show'       => 'tasks',
        'admin.cms.contacts'     => 'contacts',
        'admin.cms.contacts.show'=> 'contacts',
        'admin.cms.quotes'       => 'quotes',
        'admin.cms.quotes.show'  => 'quotes',
        'admin.payments.index'   => 'payments',
        'admin.payments.show'    => 'payments',
        'admin.invoices.index'   => 'invoices',
        'admin.invoices.show'    => 'invoices',
        'admin.blog.comments'    => 'comments',
        'admin.cms.testimonials' => 'testimonials',

        // Client routes
        'client.payments.index'  => 'payments',
        'client.invoices'        => 'invoices',
        'client.invoices.show'   => 'invoices',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && $request->route()) {
            $routeName = $request->route()->getName();
            $badgeType = self::ROUTE_BADGE_MAP[$routeName] ?? null;

            if ($badgeType) {
                BadgeRead::markRead($request->user()->id, $badgeType);
                SidebarBadgeComposer::clearCache($request->user()->id);
            }
        }

        return $response;
    }
}
