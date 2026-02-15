<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialPlatform>
 */
class SocialPlatformFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => strtolower($name),
            'base_share_url' => 'https://' . strtolower($name) . '.com/share?u=',
            'icon_class' => 'fab fa-' . strtolower($name),
            'color' => $this->faker->hexColor,
            'is_active' => true,
            'sort_order' => 10,
        ];
    }
}
