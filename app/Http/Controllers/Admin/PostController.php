<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image; // Import the Image facade

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galleries = Gallery::all();
        return view('admin.posts.create', compact('galleries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'gallery_id' => 'nullable|exists:galleries,id',
            'cover_photo_id' => 'nullable|exists:photos,id',
            'body' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // Allow larger upload size initially
            'published_at' => 'nullable|date',
        ]);

        $path = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = Str::random(40) . '.jpg';
            $path = 'posts/' . $filename;

            // Optimize the Image
            $image = Image::read($file)
                ->scaleDown(width: 1920, height: 1920)
                ->toJpeg(quality: 80);

            // Save to Storage
            Storage::disk('public')->put($path, (string) $image);
        }

        Post::create([
            'user_id' => Auth::id(),
            'gallery_id' => $validated['gallery_id'] ?? null,
            'cover_photo_id' => $request->input('cover_photo_id') ?: null,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'featured_image' => $path,
            'published_at' => $validated['published_at'] ?? now()
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
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
            'cover_photo_id' => 'nullable|exists:photos,id',
            'body' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
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
            // Delete old image first
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $file = $request->file('featured_image');
            $filename = Str::random(40) . '.jpg';
            $path = 'posts/' . $filename;

            // Optimize the Image
            $image = Image::read($file)
                ->scaleDown(width: 1920, height: 1920)
                ->toJpeg(quality: 80);

            // Save to Storage
            Storage::disk('public')->put($path, (string) $image);
        }

        $post->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'gallery_id' => $validated['gallery_id'] ?? null,
            'cover_photo_id' => $request->input('cover_photo_id') ?: null,
            'body' => $validated['body'],
            'featured_image' => $path,
            'published_at' => $validated['published_at'],
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post) // Corrected type hint to Post model
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
     */
    public function getGalleryPhotos(Gallery $gallery)
    {
        $photos = $gallery->photos()
            ->where('is_visible', true)
            ->get()
            ->map(function($photo) {
                return [
                    'id' => $photo->id,
                    'url' => $photo->url,
                ];
            });

        return response()->json($photos);
    }
}
