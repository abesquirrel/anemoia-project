<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'gallery_id',
        'cover_photo_id',
        'title',
        'slug',
        'body',
        'featured_image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the user (author) that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gallery that owns the post.
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get the photo that owns the post.
     */
    public function coverPhoto()
    {
        return $this->belongsTo(Photo::class, 'cover_photo_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'last_edited_by');
    }
}
