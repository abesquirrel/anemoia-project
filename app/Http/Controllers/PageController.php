<?php

    namespace App\Http\Controllers;

    use App\Models\Gallery;
    use Illuminate\Http\Request;
    use Illuminate\View\View; // Make sure this is imported

    class PageController extends Controller
    {
        /**
         * Displays the home view with featured galleries and a grid of visible galleries.
         *
         * @return View
         */
        public function home()
        {
            // 1. Get the 2 most recently featured galleries
            $featured_galleries = Gallery::with('photos')
                ->whereNotNull('featured_at')
                ->orderBy('featured_at', 'desc')
                ->take(2)
                ->get();

            // 2. Assign them to variables. get(0) and get(1) will return null if not found.
            $featured_gallery_a = $featured_galleries->get(0);
            $featured_gallery_b = $featured_galleries->get(1);

            // 3. Get the IDs of the featured galleries so we can exclude them from the main grid
            $featured_ids = $featured_galleries->pluck('id');

            // 4. Get all other galleries
            $grid_galleries = Gallery::with('photos')
                ->where('is_visible', true)
                ->whereNotIn('id', $featured_ids) // Exclude featured ones
                ->latest()
                ->get();

            // 5. Send the data to the view.
            // The view 'partials.gallery-section' already has @if($featured_gallery_a)
            // so it will safely handle null values if fewer than 2 are featured.
            return view('welcome', [
                'featured_gallery_a' => $featured_gallery_a,
                'featured_gallery_b' => $featured_gallery_b,
                'grid_galleries' => $grid_galleries,
            ]);
        }
    }
