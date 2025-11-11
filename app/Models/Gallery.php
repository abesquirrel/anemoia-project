<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    // Allow mass assignment of all attributes in the admin panel
    protected $fillable = [
        'title',
        'slug',
        'description',
        'camera',
        'lens',
        'film',
        'is_visible',
        'featured_at',
    ];

    // This tells Laravel to treat 'featured_at' as a date object
    protected $casts = [
        'featured_at' => 'datetime',
    ];

    /*
     * A Gallery has many photos
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /*
     * With this "Accessor" we can get the cover photo URL
     * with: $gallery->cover_photo_url
     */
    protected function coverPhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // First, tries to find a photo marked as the cover
                $cover = $this->photos()->where('is_cover_photo', true)->first();

                // If no cover photo is found, returns the first photo
                if (!$cover) {
                    $cover = $this->photos()->first();
                }

                // If a cover photo is found, return its public URL.
                // Otherwise, return a default placeholder image.
                if ($cover) {
                    // With Storage::url() we can get the public URL of a file
                    return Storage::url($cover->filename);
                }

                return asset('assets/img/bg-masthead.jpg');
            },
        );
    }
}
