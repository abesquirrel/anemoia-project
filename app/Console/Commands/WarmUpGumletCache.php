<?php

namespace App\Console\Commands;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WarmUpGumletCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:warm-up-gumlet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up the Gumlet cache by requesting all photos and post images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Gumlet cache warm-up...');

        // 1. Collect all image URLs
        $photos = Photo::all()->pluck('url');
        $posts = Post::whereNotNull('featured_image')->get()->map(fn($post) => $post->featured_image_url);

        $urls = $photos->concat($posts)->filter()->unique();
        $count = $urls->count();

        if ($count === 0) {
            $this->warn('No images found to warm up.');
            return;
        }

        $this->info("Found {$count} unique image URLs to process.");
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($urls as $url) {
            try {
                // We use HEAD request to trigger the fetch without downloading the whole body
                Http::head($url);
            } catch (\Exception $e) {
                $this->error("\nFailed to warm up: {$url} - " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();
        $this->line("");
        $this->info('Gumlet cache warm-up completed!');
    }
}
