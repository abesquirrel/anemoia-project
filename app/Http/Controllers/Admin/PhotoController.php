<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Show the page to manage photos for a specific gallery.
     */
    public function index(Gallery $gallery)
    {
        // Load the gallery's photos
        $gallery->load('photos');
        return view('admin.photos.index', compact('gallery'));
    }

    /**
     * Store new photos uploaded to a gallery.
     */
    public function store(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'exif_metadata' => 'nullable|string|max:255'
        ]);

        foreach ($request->file('photos') as $file) {
            // Store the file in 'public/photos/gallery-1', etc.
            $path = $file->store('photos/gallery-' . $gallery->id, 'public');

            // Create the Photo record in the database
            $gallery->photos()->create([
                'filename' => $path,
                'exif_metadata' => $validated['exif_metadata'],
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully');
    }

    /**
     * Delete a photo.
     */
    public function destroy(Photo $photo)
    {
        // 1. Delete the actual file from storage
        Storage::disk('public')->delete($photo->filename);

        // 2. Delete the photo record from the database
        $photo->delete();

        return back()->with('success', 'Photo deleted successfully');
    }
}
