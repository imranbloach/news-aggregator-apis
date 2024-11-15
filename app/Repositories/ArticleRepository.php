<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function fetchArticlesWithFilters($filters)
    {
        $query = Article::query();

        if (isset($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (isset($filters['source'])) {
            $query->where('source_id', $filters['source']);
        }

        return $query->paginate(10);
    }

    public function findArticleById($id)
    {
        return Article::findOrFail($id);
    }
}
