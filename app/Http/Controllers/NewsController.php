<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\News\NewsApiService;
use App\Services\News\GuardianService;
use App\Services\News\NytService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected $newsApiService;
    protected $guardianService;
    protected $nytService;

    public function __construct(
        NewsApiService $newsApiService,
        GuardianService $guardianService,
        NytService $nytService
    ) {
        $this->newsApiService = $newsApiService;
        $this->guardianService = $guardianService;
        $this->nytService = $nytService;
    }


    /*  we can also use below method to make an api request to fetch articles 
        manually using any query parameter. but now its being used to fetch 
        articles data by runing command automatically according to requirement
     */
    public function fetchAndSaveArticles($query)
    {
        $newsApiArticles = $this->newsApiService->getArticles($query);
        $guardianArticles = $this->guardianService->getArticles($query);
        $nytArticles = $this->nytService->getArticles($query);

        $savedCount = 0;

        // Process NewsAPI Articles
        if ($newsApiArticles && isset($newsApiArticles['articles'])) {
            foreach ($newsApiArticles['articles'] as $newsItem) {
                $saved = Article::updateOrCreate(
                    ['url' => $newsItem['url']],
                    [
                        'title' => $newsItem['title'] ?? '',
                        'content' => $newsItem['description'] ?? '',
                        'published_at' => isset($newsItem['publishedAt']) ? Carbon::parse($newsItem['publishedAt'])->format('Y-m-d H:i:s') : null,
                        'source' => 'NewsAPI',
                        'category' => $query,
                    ]
                );
                $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
            }
        }

        // Process The Guardian Articles
        if ($guardianArticles && isset($guardianArticles['response']['results'])) {
            foreach ($guardianArticles['response']['results'] as $newsItem) {
                $saved = Article::updateOrCreate(
                    ['url' => $newsItem['webUrl']],
                    [
                        'title' => $newsItem['webTitle'] ?? '',
                        'content' => $newsItem['fields']['bodyText'] ?? '',
                        'published_at' => isset($newsItem['webPublicationDate']) ? Carbon::parse($newsItem['webPublicationDate'])->format('Y-m-d H:i:s') : null,
                        'source' => 'The Guardian',
                        'category' => $newsItem['sectionName'] ?? $query,
                    ]
                );
                $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
            }
        }

        // Process The New York Times Articles
        if ($nytArticles && isset($nytArticles['response']['docs'])) {
            foreach ($nytArticles['response']['docs'] as $newsItem) {
                $saved = Article::updateOrCreate(
                    ['url' => $newsItem['web_url']],
                    [
                        'title' => $newsItem['headline']['main'] ?? '',
                        'content' => $newsItem['abstract'] ?? '',
                        'published_at' => isset($newsItem['pub_date']) ? Carbon::parse($newsItem['pub_date'])->format('Y-m-d H:i:s') : null,
                        'source' => 'New York Times',
                        'category' => $newsItem['section_name'] ?? $query,
                    ]
                );
                $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
            }
        }

        Log::info('Articles saved successfully', ['saved_count' => $savedCount]);

        return response()->json([
            'message' => 'Articles saved successfully',
            'saved_count' => $savedCount,
        ]);
    }
}
