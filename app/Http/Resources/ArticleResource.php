<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'article_id' => $this->id, 
            'title' => $this->title,
            'description' => $this->content,
            'author_name' => $this->author->name,
            'category_name' => $this->category->name,
            'published_date' => $this->created_at->format('Y-m-d'),
        ];
    }
}

