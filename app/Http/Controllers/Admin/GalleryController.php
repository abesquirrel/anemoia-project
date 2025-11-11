<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the galleries.
     */
    public function index()
    {
        $galleries = Gallery::withCount('photos')->latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created gallery in storage.
     */
    public function store(Request $request)
    {
        $validated =$request->validate([
           'title' => 'required|string|max:255',
           'description' => 'nullable|string',
           'camera' => 'nullable|string|max:255',
           'lens' => 'nullable|string|max:255',
           'film' => 'nullable|string|max:255',
           'is_visible' => 'nullable|boolean',
        ]);

        $gallery = new Gallery();
        $gallery->title = $validated['title'];
        $gallery->slug = Str::slug($validated['title']);
        $gallery->description = $validated['description'];
        $gallery->camera = $validated['camera'];
        $gallery->lens = $validated['lens'];
        $gallery->film = $validated['film'];
        $gallery->is_visible = $request->has('is_visible');
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery created successfully.');
    }

    /**
     * Display the specified gallery (we redirect to edit).
     */
    public function show(Gallery $gallery)
    {
        // No one needs to 'show' a gallery in the admin,
        // redirect to the 'edit' page instead.
        return redirect()->route('admin.galleries.edit', $gallery);
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated =$request->validate([
           'title' => 'required|string|max:255',
           'description' => 'nullable|string',
            'camera' => 'nullable|string|max:255',
            'lens' => 'nullable|string|max:255',
            'film' => 'nullable|string|max:255',
            'is_visible' => 'nullable|boolean'
        ]);

        $gallery->title = $validated['title'];
        $gallery->slug = Str::slug($validated['title']);
        $gallery->description = $validated['description'];
        $gallery->camera = $validated['camera'];
        $gallery->lens = $validated['lens'];
        $gallery->film = $validated['film'];
        $gallery->is_visible = $request->has('is_visible');
        $gallery->save();
        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully.');
    }

    /**
     * Remove the specified gallery from storage.
     */
    public function destroy(string $id)
    {
        // Note: Photos will be auto-deleted when the gallery is deleted.
        // But the photo files will not. These must be deleted manually.
        // TODO: add file deletion logic here for production

        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted successfully.');

    }
}
