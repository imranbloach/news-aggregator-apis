<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'article_id' => $this->id, 
            'title' => $this->title,
            'description' => $this->content,
            'article_url' => $this->url,
            'news_agency' => $this->source,
            'category' => $this->category,
            'published_at' => $this->published_at ? (Carbon::parse($this->published_at))->format('Y-m-d H:i:s') : null,
            'author_name' => $this->author->name ?? null,
            'category_name' => $this->category->name ?? $this->category,
            'source_name' => $this->source->name ?? $this->source,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
