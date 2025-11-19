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
            // We use a closure function($query) to filter the 'photos' relationship
            $featured_galleries = Gallery::with(['photos' => function ($query) {
                $query->where('is_visible', true);
            }])
                ->whereNotNull('featured_at')
                ->orderBy('featured_at', 'desc')
                ->take(2)
                ->get();

            $featured_gallery_a = $featured_galleries->get(0);
            $featured_gallery_b = $featured_galleries->get(1);

            $featured_ids = $featured_galleries->pluck('id');

            // 2. Get all other galleries
            // Same filter here: only fetch photos where is_visible = true
            $grid_galleries = Gallery::with(['photos' => function ($query) {
                $query->where('is_visible', true);
            }])
                ->where('is_visible', true)
                ->whereNotIn('id', $featured_ids)
                ->latest()
                ->get();

            return view('welcome', [
                'featured_gallery_a' => $featured_gallery_a,
                'featured_gallery_b' => $featured_gallery_b,
                'grid_galleries' => $grid_galleries,
            ]);
        }
    }
