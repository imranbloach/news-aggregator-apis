<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $articles = $this->articleService->getAllArticles($request->all());
        return response()->json($articles);
    }

    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        return response()->json($article);
    }
}

