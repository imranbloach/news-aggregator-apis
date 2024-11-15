<?php
namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function getAllArticles($filters)
    {
        return $this->articleRepo->fetchArticlesWithFilters($filters);
    }

    public function getArticleById($id)
    {
        return $this->articleRepo->findArticleById($id);
    }
}
