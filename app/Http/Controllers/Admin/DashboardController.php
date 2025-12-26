<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Photo;
use App\Models\User;
use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Import File facade

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
        $photoCount = Photo::count();
        $userCount = User::count();

        // Extended Metrics
        // Use featured_at timestamp to determine if featured
        $featuredGalleryCount = Gallery::whereNotNull('featured_at')->count();

        // Calculate Storage Usage (Public Disk)
        $storagePath = public_path('storage');
        $totalSize = 0;
        if (File::exists($storagePath)) {
            foreach (File::allFiles($storagePath) as $file) {
                $totalSize += $file->getSize();
            }
        }
        $diskUsage = round($totalSize / 1024 / 1024, 2); // MB
        $diskUsageUnit = 'MB';
        if ($diskUsage > 1024) {
            $diskUsage = round($diskUsage / 1024, 2);
            $diskUsageUnit = 'GB';
        }

        // Fetch Recent Activity
        $recentLogs = EventLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'galleryCount',
            'galleryVisible',
            'galleryHidden',
            'postCount',
            'postPublished',
            'postDraft',
            'photoCount',
            'userCount',
            'featuredGalleryCount',
            'diskUsage',
            'diskUsageUnit',
            'recentLogs'
        ));
    }
}
