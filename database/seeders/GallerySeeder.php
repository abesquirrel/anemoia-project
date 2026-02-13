<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Photo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run()
    {
        // Define some thematic galleries
        $themes = [
            [
                'title' => 'Echos of Sibiu',
                'description' => 'A walk through the old town of Sibiu, capturing the quiet moments in the squares and alleys where time seems to stand still.',
                'camera' => 'Leica M3',
                'film' => 'Kodak Tri-X 400',
            ],
            [
                'title' => 'Transylvanian Morning',
                'description' => 'Early morning mist over the Carpathian mountains and the rural paths that connect small villages.',
                'camera' => 'Hasselblad 500C',
                'film' => 'Kodak Portra 400',
            ],
            [
                'title' => 'The Forgotten Cafe',
                'description' => 'Capturing the atmosphere of old European cafes, where the smell of coffee and the rustle of newspapers are the only company.',
                'camera' => 'Canon AE-1',
                'film' => 'Ilford HP5 Plus',
            ],
        ];

        foreach ($themes as $theme) {
            $slug = Str::slug($theme['title']);

            // Generate default attributes from factory
            $attributes = Gallery::factory()->make($theme)->toArray();
            $attributes['slug'] = $slug;

            // Use updateOrCreate to survive repeated runs
            $gallery = Gallery::updateOrCreate(['slug' => $slug], $attributes);

            // Only add photos if the gallery was just created or has no photos
            if ($gallery->photos()->count() === 0) {
                Photo::factory()->count(rand(5, 8))->create([
                    'gallery_id' => $gallery->id,
                ]);

                // Ensure the first photo is the cover photo
                $gallery->photos()->first()?->update(['is_cover_photo' => true]);
            }
        }
    }
}
