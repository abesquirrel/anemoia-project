<?php

namespace App\Services;

class GumletService
{
    protected string $sourceUrl;
    protected bool $useProxy;

    public function __construct()
    {
        $this->sourceUrl = rtrim(config('services.gumlet.source_url', env('GUMLET_SOURCE_URL', '')), '/');
        $this->useProxy = config('services.gumlet.use_proxy', env('GUMLET_USE_PROXY', true));
    }

    /**
     * Generate a Gumlet URL for a given path.
     */
    public function getUrl(string $path, array $params = []): string
    {
        // If Gumlet is not configured, fall back to Laravel's Storage URL
        if (empty($this->sourceUrl)) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }

        // Clean the path
        $path = ltrim($path, '/');

        // Build query string
        $queryString = '';
        if (!empty($params)) {
            $queryString = '?' . http_build_query($params);
        }

        return $this->sourceUrl . '/' . $path . $queryString;
    }
}
