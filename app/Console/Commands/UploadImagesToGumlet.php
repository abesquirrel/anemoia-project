<?php

namespace App\Console\Commands;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UploadImagesToGumlet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:upload-to-gumlet {--api-key= : Your Gumlet API key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload all local images to Gumlet storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = $this->option('api-key') ?: env('GUMLET_API_KEY');

        if (empty($apiKey)) {
            $this->error('Gumlet API key is required. Use --api-key or set GUMLET_API_KEY in .env');
            return 1;
        }

        $this->info('Starting upload to Gumlet storage...');

        // Collect all image paths from database
        $photoPaths = Photo::all()->pluck('filename');
        $postPaths = Post::whereNotNull('featured_image')->pluck('featured_image');

        $allPaths = $photoPaths->concat($postPaths)->unique();
        $count = $allPaths->count();

        if ($count === 0) {
            $this->warn('No images found to upload.');
            return 0;
        }

        $this->info("Found {$count} unique images to upload.");
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        $uploaded = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($allPaths as $path) {
            try {
                // Check if file exists in local storage
                if (!Storage::disk('public')->exists($path)) {
                    $this->error("\nFile not found in storage: {$path}");
                    $failed++;
                    $bar->advance();
                    continue;
                }

                // Get the file content
                $fileContent = Storage::disk('public')->get($path);
                $mimeType = Storage::disk('public')->mimeType($path);

                // Upload to Gumlet
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])
                    ->attach('file', $fileContent, basename($path), ['Content-Type' => $mimeType])
                    ->post('https://api.gumlet.com/v1/sources/' . env('GUMLET_SOURCE_ID') . '/files', [
                        'path' => $path,
                    ]);

                if ($response->successful()) {
                    $uploaded++;
                } else {
                    $this->error("\nFailed to upload {$path}: " . $response->body());
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->error("\nError uploading {$path}: " . $e->getMessage());
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line("");
        $this->info("Upload complete!");
        $this->info("Uploaded: {$uploaded}");
        $this->info("Skipped: {$skipped}");
        $this->info("Failed: {$failed}");

        return 0;
    }
}
