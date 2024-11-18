<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\News\NewsApiService;
use App\Services\News\GuardianService;
use App\Services\News\NytService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected $newsApiService;
    protected $guardianService;
    protected $nytService;

    public function __construct(NewsApiService $newsApiService, GuardianService $guardianService, NytService $nytService)
    {
        $this->newsApiService = $newsApiService;
        $this->guardianService = $guardianService;
        $this->nytService = $nytService;
    }

    /**
     * @OA\Get(
     *     path="/news/{query}",
     *     tags={"News"},
     *     summary="Fetch and save combined news articles from multiple sources",
     *     description="Fetches and saves articles related to a specific query from NewsAPI.org, The Guardian, and The New York Times.",
     *     @OA\Parameter(
     *         name="query",
     *         in="path",
     *         description="Search query for news articles",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Articles fetched and saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Articles saved successfully"),
     *             @OA\Property(property="saved_count", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bad request due to invalid input")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function fetchAndSaveArticles($query)
    {
        $newsApiArticles = $this->newsApiService->getArticles($query);
        $guardianArticles = $this->guardianService->getArticles($query);
        $nytArticles = $this->nytService->getArticles($query);

        $savedCount = 0;

        // Process NewsAPI Articles
        foreach ($newsApiArticles['articles'] ?? [] as $newsItem) {
            $saved = Article::updateOrCreate(
                ['url' => $newsItem['url']],
                [
                    'title' => $newsItem['title'] ?? '',
                    'content' => $newsItem['description'] ?? '',
                    'published_at' => $newsItem['publishedAt'] ?? '',
                    'url' => $newsItem['url'] ?? '',
                    'source_name' => 'NewsAPI',
                    'section_name' => $query,
                ]
            );
            $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
        }

        // Process The Guardian Articles
        foreach ($guardianArticles['response']['results'] ?? [] as $newsItem) {
            $saved = Article::updateOrCreate(
                ['url' => $newsItem['webUrl']],
                [
                    'title' => $newsItem['webTitle'] ?? '',
                    'content' => null,
                    'published_at' => $newsItem['webPublicationDate'] ?? '',
                    'url' => $newsItem['webUrl'] ?? '',
                    'source_name' => 'The Guardian',
                    'section_name' => $newsItem['sectionName'] ?? $query,
                ]
            );
            $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
        }

        // Process The New York Times Articles
        foreach ($nytArticles['response']['docs'] ?? [] as $newsItem) {
            $saved = Article::updateOrCreate(
                ['url' => $newsItem['web_url']],
                [
                    'title' => $newsItem['headline']['main'] ?? '',
                    'content' => $newsItem['abstract'] ?? '',
                    'published_at' => $newsItem['pub_date'] ?? '',
                    'url' => $newsItem['web_url'] ?? '',
                    'source_name' => 'New York Times',
                    'section_name' => $newsItem['section_name'] ?? $query,
                ]
            );
            $savedCount += $saved->wasRecentlyCreated ? 1 : 0;
        }

        return response()->json([
            'message' => 'Articles saved successfully',
            'saved_count' => $savedCount
        ]);
        Log::info(json_encode([
            'message' => 'Articles saved successfully',
            'saved_count' => $savedCount
        ]));
    }
}
