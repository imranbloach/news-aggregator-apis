<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Technology', 'Sports', 'Health', 'Business', 'Entertainment'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower($category),
                'description' => "{$category} related news",
            ]);
        }
    }
}

