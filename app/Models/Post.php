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
        'title',
        'slug',
        'body',
        'featured_image',
        'published_at',
    ];

    /**
     * Get the user (author) that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
