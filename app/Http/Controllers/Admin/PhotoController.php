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
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'exif_metadata' => 'nullable|string|max:255',
        ]);

        $uploadedCount = 0;
        $skippedCount = 0;

        foreach ($request->file('photos') as $file) {
            // 1. Calculate the hash of the file's content
            $hash = md5_file($file->getRealPath());

            // 2. Check if a photo with this hash already exists
            $exists = Photo::where('hash', $hash)->exists();

            if (!$exists) {
                // 3. If it does NOT exist, store it
                $path = $file->store('photos/gallery-' . $gallery->id, 'public');

                $gallery->photos()->create([
                    'filename' => $path,
                    'hash' => $hash, // <-- Save the hash
                    'exif_metadata' => $validated['exif_metadata'],
                ]);
                $uploadedCount++;
            } else {
                // 4. If it exists, skip it
                $skippedCount++;
            }
        }

        $message = "{$uploadedCount} photos uploaded successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} duplicates were skipped.";
        }

        return back()->with('success', $message);
    }

    /**
     * Set a photo as the cover photo for its gallery.
     * This logic is adapted from your old functions.php
     */
    public function setCover(Photo $photo)
    {
        // 1. Get the gallery ID from the photo
        $galleryId = $photo->gallery_id;

        // 2. Set all other photos in this gallery to NOT be the cover photo
        Photo::where('gallery_id', $galleryId)->update(['is_cover_photo' => false]);

        // 3. Set the selected photo AS the cover photo
        $photo->is_cover_photo = true;
        $photo->save();

        return back()->with('success', 'Cover photo updated!');
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
