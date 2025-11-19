<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

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
     * Store new photos with resizing and compression.
     */
    public function store(Request $request, Gallery $gallery)
    {
        $request->validate([
            'photos' => 'required|array',
            // We allow large files (up to 20MB) because we resize them immediately
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'exif_metadata' => 'nullable|string|max:255',
        ]);

        $count = 0;
        $skipped = 0;

        foreach ($request->file('photos') as $file) {

            // 1. Calculate Hash (to prevent duplicates)
            $hash = md5_file($file->getRealPath());

            // Check if this exact photo already exists in the database
            if (Photo::where('hash', $hash)->exists()) {
                $skipped++;
                continue;
            }

            // 2. Generate Filename
            $filename = Str::random(40) . '.jpg';
            $path = 'photos/gallery-' . $gallery->id . '/' . $filename;

            // 3. Optimize the Image (Resize & Compress)
            // We read the file, scale it to max 1920px, and compress to 80% quality.
            $image = Image::read($file)
                ->scaleDown(width: 1920, height: 1920)
                ->toJpeg(quality: 80);

            // 4. Save to Storage
            // We use (string) $image to get the file data stream.
            Storage::disk('public')->put($path, (string) $image);

            // 5. Create Database Record
            $gallery->photos()->create([
                'filename' => $path,
                'hash' => $hash,
                'exif_metadata' => $request->input('exif_metadata'),
                'is_visible' => true,
            ]);

            $count++;
        }

        $message = "$count photos uploaded and optimized.";
        if ($skipped > 0) {
            $message .= " ($skipped duplicates skipped)";
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

    /**
     * Toggle the visibility of a photo.
     */
    public function toggleVisibility(Photo $photo)
    {
        $photo->is_visible = !$photo->is_visible;
        $photo->save();

        $status = $photo->is_visible ? 'visible' : 'hidden';
        return back()->with('success', "Photo is now $status.");
    }
}
