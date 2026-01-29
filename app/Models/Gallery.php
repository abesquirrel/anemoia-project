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
        'show_exif',
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
                // 1. Try to find a marked cover photo that is ALSO visible
                $cover = $this->photos()
                    ->where('is_cover_photo', true)
                    ->where('is_visible', true) // <-- Added this check
                    ->first();

                // 2. If none, get the first visible photo
                if (!$cover) {
                    $cover = $this->photos()
                        ->where('is_visible', true) // <-- Added this check
                        ->first();
                }

                // 3. Return URL or Fallback
                if ($cover) {
                    return app(\App\Services\GumletService::class)->getUrl($cover->filename);
                }

                return asset('assets/img/bg-masthead.webp');
            },
        );
    }
}
