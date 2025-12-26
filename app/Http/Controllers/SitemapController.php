<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)->orderBy('created_at', 'desc')->get();
        // Assuming Galleries also have a 'slug' or we just link to them via anchor on home page
        // For now, we'll list the main pages and blog posts.
        // If galleries have own pages, add them here. 

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // 1. Static Pages
        $xml .= $this->urlItem(route('home'), '1.0', 'weekly');
        $xml .= $this->urlItem(route('blog.index'), '0.8', 'daily');

        // 2. Blog Posts
        foreach ($posts as $post) {
            $xml .= $this->urlItem(route('blog.show', $post->slug), '0.6', 'monthly', $post->updated_at->toAtomString());
        }

        $xml .= '</urlset>';

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }

    private function urlItem($loc, $priority, $changefreq, $lastmod = null)
    {
        $lastmod = $lastmod ?? now()->toAtomString();
        return "
        <url>
            <loc>{$loc}</loc>
            <lastmod>{$lastmod}</lastmod>
            <changefreq>{$changefreq}</changefreq>
            <priority>{$priority}</priority>
        </url>";
    }
}
