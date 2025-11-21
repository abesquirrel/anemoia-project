<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
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
        $galleries = \App\Models\Gallery::all(); // Fetch all galleries
        return view('admin.posts.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'gallery_id' => 'nullable|exists:galleries,id', // <-- Validation
            'cover_photo_id' => $request->input('cover_photo_id'),
            'body' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $path = null;
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'gallery_id' => $validated['gallery_id'] ?? null,
            'cover_photo_id' => $request->input('cover_photo_id') ?: null,
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
    public function edit(Post $post)
    {
        $galleries = Gallery::all();
        return view('admin.posts.edit', compact('post','galleries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'gallery_id' => 'nullable|exists:galleries,id',
            'cover_photo_id' => 'nullable|exists:photos,id', // Validate the photo selection
            'body' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $path = $post->featured_image;

        // 1. Check if "Remove" was clicked
        if ($request->has('remove_featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = null;
        }

        // 2. Check if a NEW file was uploaded (overrides everything)
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $path = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'gallery_id' => $validated['gallery_id'] ?? null,
            'cover_photo_id' => $request->input('cover_photo_id') ?? null, // Ensure this is saved
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

    /**
     * Retrieve a list of visible photos for the specified gallery.
     *
     * @param Gallery $gallery The gallery model instance.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the visible photos in the gallery.
     */
    public function getGalleryPhotos(Gallery $gallery)
    {
        // We map the results to send both ID and the Full URL
        $photos = $gallery->photos()
            ->where('is_visible', true)
            ->get()
            ->map(function($photo) {
                return [
                    'id' => $photo->id,
                    'url' => $photo->url, // Uses the accessor we created earlier
                ];
            });

        return response()->json($photos);
    }
}
