<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NytService
{
    protected $baseUrl = 'https://api.nytimes.com/svc/search/v2';

    public function getArticles($query)
    {
        $response = Http::get("{$this->baseUrl}/articlesearch.json", [
            'q' => $query,
            'api-key' => env('NYT_API_KEY'),
            'page' => 0,
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            Log::error('NYT API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }
    }
}
