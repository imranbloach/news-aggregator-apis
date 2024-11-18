<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function getAllArticles($filters)
    {
        return Cache::remember('articles', 3600, function () use ($filters) {
            return $this->articleRepo->fetchArticlesWithFilters($filters);
        });
    }

    public function getArticleById($id)
    {
        return Cache::remember("article_{$id}", 3600, function () use ($id) {
            return $this->articleRepo->findArticleById($id);
        });
    }
}

