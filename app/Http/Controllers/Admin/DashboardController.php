<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Photo;
use App\Models\User;
use App\Models\EventLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        // Fetch Counts
        $galleryCount = Gallery::count();
        $galleryVisible = Gallery::where('is_visible', true)->count();
        $galleryHidden = $galleryCount - $galleryVisible;

        $postCount = Post::count();
        $postPublished = Post::whereNotNull('published_at')->where('published_at', '<=', now())->count();
        $postDraft = $postCount - $postPublished;

        $photoCount = Photo::count();
        $userCount = User::count();

        // Fetch Recent Activity
        $recentLogs = EventLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'galleryCount', 'galleryVisible', 'galleryHidden',
            'postCount', 'postPublished', 'postDraft',
            'photoCount',
            'userCount',
            'recentLogs'
        ));
    }
}
