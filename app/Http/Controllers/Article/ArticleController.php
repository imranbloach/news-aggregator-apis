<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @OA\Get(
     *     path="/articles",
     *     tags={"Articles"},
     *     summary="Get list of articles",
     *     security={{"sanctum": {}}},
     *     description="Returns a list of articles with optional filters",
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         required=false,
     *         description="Category ID to filter articles",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         required=false,
     *         description="Keyword to search in article titles",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="source",
     *         in="query",
     *         required=false,
     *         description="Source ID to filter articles",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of articles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Article")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

     public function index(Request $request)
     {
        $articles = $this->articleService->getAllArticles($request->all());
        return ArticleResource::collection($articles);
     }

    /**
     * @OA\Get(
     *     path="/articles/{id}",
     *     tags={"Articles"},
     *     summary="Get a specific article",
     *     security={{"sanctum": {}}},
     *     description="Returns a specific article by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article details",
     *         @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        return new ArticleResource($article);
    }
}
