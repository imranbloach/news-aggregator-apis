<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GuardianService
{
    protected $baseUrl = 'https://content.guardianapis.com';

    public function getArticles($query)
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'api-key' => env('GUARDIAN_API_KEY'),
            'q' => $query,
            'page-size' => 10,
            'show-fields' => 'all',
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            Log::error('Guardian API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }
    }
}
