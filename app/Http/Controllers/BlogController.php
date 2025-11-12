<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a paginated list of all published posts.
     */
    public function index()
    {
        $posts = Post::where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(10); // Show 10 posts per page

        return view('blog.index', compact('posts'));
    }

    /**
     * Display a single post by its slug.
     */
    public function show($slug)
    {
        // Find the post by its slug, but only if it's published
        $post = Post::where('slug', $slug)
            ->where('published_at', '<=', now())
            ->firstOrFail(); // Show 404 if not found or not published

        return view('blog.show', compact('post'));
    }
}
