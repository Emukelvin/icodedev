<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Portfolio;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $services = Service::where('is_active', true)->get();
        $portfolios = Portfolio::where('is_active', true)->get();
        $posts = BlogPost::published()->latest('published_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static pages
        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'freq' => 'daily'],
            ['url' => route('about'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => route('services'), 'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => route('portfolio'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('pricing'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('contact'), 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => route('blog'), 'priority' => '0.8', 'freq' => 'daily'],
            ['url' => route('project.estimator'), 'priority' => '0.7', 'freq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['url'], ENT_XML1) . '</loc>';
            $xml .= '<changefreq>' . $page['freq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        // Services
        foreach ($services as $service) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('services.show', $service), ENT_XML1) . '</loc>';
            $xml .= '<lastmod>' . $service->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        // Portfolio
        foreach ($portfolios as $portfolio) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('portfolio.show', $portfolio), ENT_XML1) . '</loc>';
            $xml .= '<lastmod>' . $portfolio->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        // Blog posts
        foreach ($posts as $post) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('blog.show', $post), ENT_XML1) . '</loc>';
            $xml .= '<lastmod>' . $post->updated_at->toW3cString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.6</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
