<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all post, newest first, with their author's name
        $posts = Post::with('user')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
           'title' => 'required|string|max:255',
           'body' => 'required|string',
           'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
           'published_at' => 'nullable|date',
        ]);

        $path = null;
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(), // Assing the post to the currently authenticated user
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'featured_image' => $path,
            'published_at' => $validated['published_at'] ?? now() // Published now if not specified
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Redirect to the edit page of the post
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $path = $post->featured_image; // Keep old image by default
        if ($request->hasFile('featured_image')) {
            // Delete old image if a new one is uploaded
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update([
           'title' => $validated['title'],
           'slug' => Str::slug($validated['title']),
           'body' => $validated['body'],
           'featured_image' => $path,
           'published_at' => $validated['published_at'],
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the featured image from storage if it exists
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        // Delete the post from the database
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
