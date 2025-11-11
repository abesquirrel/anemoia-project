<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Photo extends Model
{
    use HasFactory;

// Allow mass-assignment of these fields
    protected $fillable = [
        'gallery_id',
        'filename',
        'exif_metadata',
        'is_cover_photo',
        'is_visible'
    ];

    /*
     * A Photo belongs to a Gallery
     */
    private mixed $filename;

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /*
     * With this accessor we can get a clean way to the phot's URL
     * By using: $photo->url
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->filename),
        );
    }
}
