<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are authors, categories, and sources before creating articles
        $authors = Author::all();
        $categories = Category::all();
        $sources = Source::all();

        // Generate 20 articles
        Article::factory(20)->make()->each(function ($article) use ($authors, $categories, $sources) {
            $article->author_id = $authors->random()->id;
            $article->category_id = $categories->random()->id;
            $article->source_id = $sources->random()->id;
            $article->save();
        });
    }
}

