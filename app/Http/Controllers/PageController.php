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
            // CHANGED: Use find() instead of findOrFail().
            // This will return 'null' if the gallery isn't found, instead of a 404 error.
            $featured_gallery_1 = Gallery::with('photos')->find(3);
            $featured_gallery_2 = Gallery::with('photos')->find(4);

            // This query is fine and will just return an empty list
            $grid_galleries = Gallery::with('photos')
                ->where('is_visible', true)
                ->whereNotIn('id', [3, 4])
                ->latest()
                ->get();

            // Send all this data to our main view
            return view('welcome', [
                'featured_gallery_1' => $featured_gallery_1,
                'featured_gallery_2' => $featured_gallery_2,
                'grid_galleries' => $grid_galleries,
            ]);
        }
    }
