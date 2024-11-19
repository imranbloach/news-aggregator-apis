<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use App\Models\Author;

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
            'url' => $this->faker->url,
            'source' => Source::inRandomOrder()->first()->name ?? 'Default Source',
            'category' => Category::inRandomOrder()->first()->name ?? 'Default Category',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),

            'author_id' => \App\Models\Author::factory(),
            'category_id' =>Category::inRandomOrder()->first()->id, 
            'source_id' => \App\Models\Source::factory(),
        ];
    }
}
