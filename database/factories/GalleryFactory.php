<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        $title = $this->faker->words(3, true);
        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'camera' => $this->faker->randomElement(['Leica M3', 'Hasselblad 500C', 'Nikon F3', 'Canon AE-1', 'Pentax K1000']),
            'lens' => $this->faker->randomElement(['Summicron 35mm f/2', 'Planar 80mm f/2.8', 'Nikkor 50mm f/1.4', 'FD 50mm f/1.8', 'SMC 50mm f/1.7']),
            'film' => $this->faker->randomElement(['Kodak Portra 400', 'Fujifilm Superia 400', 'Kodak Tri-X 400', 'Ilford HP5 Plus', 'Agfa Vista 200']),
            'is_visible' => true,
            'featured_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 year', 'now'),
            'show_exif' => true,
            'show_exif_on_first_only' => $this->faker->boolean(),
            'exif_fields' => ['camera', 'lens', 'film'],
        ];
    }
}
