<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    public function definition(): array
    {
        $stockImages = [
            'seed/village.png',
            'seed/portrait.png',
            'seed/cafe.png',
        ];

        return [
            'filename' => $this->faker->randomElement($stockImages),
            'hash' => $this->faker->sha256(),
            'exif_metadata' => json_encode([
                'Make' => 'Leica',
                'Model' => 'M3',
                'ExposureTime' => '1/125',
                'FNumber' => '2.0',
                'ISO' => '400',
            ]),
            'is_cover_photo' => false,
            'is_visible' => true,
        ];
    }
}
