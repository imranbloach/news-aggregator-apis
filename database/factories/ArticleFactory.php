<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Article::class;
    
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'author_id' => \App\Models\Author::factory(),  // Creates an author if needed
            'category_id' => \App\Models\Category::factory(), // Creates a category if needed
            'source_id' => \App\Models\Source::factory(),  // Creates a source if needed
        ];
    }
}
