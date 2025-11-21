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
        // FIXED: Added 'gallery' and 'coverPhoto' to the 'with()' array
        $allPosts = Post::with(['user', 'gallery', 'coverPhoto'])
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->get();

        $heroPost = $allPosts->first();
        $gridPosts = $allPosts->slice(1);

        return view('blog.index', compact('heroPost', 'gridPosts'));
    }

    /**
     * Display a single post by its slug.
     */
    public function show($slug)
    {
        // FIXED: Added 'gallery' and 'coverPhoto' here just like in index()
        $post = Post::with(['user', 'gallery', 'coverPhoto'])
            ->where('slug', $slug)
            ->where('published_at', '<=', now())
            ->firstOrFail(); // This returns 404 if post not found or not published

        return view('blog.show', compact('post'));
    }
}
