<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiService
{
    protected $baseUrl = 'https://newsapi.org/v2';

    public function getArticles($query)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('NEWS_API_KEY'),
        ])->get("{$this->baseUrl}/everything", [
            'q' => $query,
            'language' => 'en',
            'pageSize' => 10,
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            Log::error('NewsAPI request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }
    }
}
