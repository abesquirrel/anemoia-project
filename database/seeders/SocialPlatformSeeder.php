<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Facebook',
                'slug' => 'facebook',
                'base_share_url' => 'https://www.facebook.com/sharer/sharer.php?u=',
                'icon_class' => 'fab fa-facebook-f',
                'color' => '#1877F2',
                'sort_order' => 10,
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'base_share_url' => 'https://www.instagram.com/',
                'icon_class' => 'fab fa-instagram',
                'color' => '#C13584',
                'sort_order' => 15,
            ],
            [
                'name' => 'X (Twitter)',
                'slug' => 'twitter',
                'base_share_url' => 'https://twitter.com/intent/tweet?url=',
                'icon_class' => 'fab fa-twitter', // or fa-x-twitter if available
                'color' => '#000000',
                'sort_order' => 20,
            ],
            [
                'name' => 'LinkedIn',
                'slug' => 'linkedin',
                'base_share_url' => 'https://www.linkedin.com/sharing/share-offsite/?url=',
                'icon_class' => 'fab fa-linkedin-in',
                'color' => '#0077B5',
                'sort_order' => 30,
            ],
            [
                'name' => 'Pinterest',
                'slug' => 'pinterest',
                'base_share_url' => 'https://pinterest.com/pin/create/button/?url=',
                'icon_class' => 'fab fa-pinterest-p',
                'color' => '#E60023',
                'sort_order' => 40,
            ],
            [
                'name' => 'WhatsApp',
                'slug' => 'whatsapp',
                'base_share_url' => 'https://api.whatsapp.com/send?text=',
                'icon_class' => 'fab fa-whatsapp',
                'color' => '#25D366',
                'sort_order' => 50,
            ],
            [
                'name' => 'Telegram',
                'slug' => 'telegram',
                'base_share_url' => 'https://t.me/share/url?url=',
                'icon_class' => 'fab fa-telegram-plane',
                'color' => '#0088cc',
                'sort_order' => 60,
            ],
            [
                'name' => 'Reddit',
                'slug' => 'reddit',
                'base_share_url' => 'https://www.reddit.com/submit?url=',
                'icon_class' => 'fab fa-reddit-alien',
                'color' => '#FF4500',
                'sort_order' => 70,
            ],
            [
                'name' => 'Email',
                'slug' => 'email',
                'base_share_url' => 'mailto:?body=',
                'icon_class' => 'fas fa-envelope',
                'color' => '#888888',
                'sort_order' => 80,
            ],
        ];

        foreach ($platforms as $platform) {
            \App\Models\SocialPlatform::updateOrCreate(
                ['slug' => $platform['slug']],
                $platform
            );
        }
    }
}
