<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Source;


class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            ['name' => 'BBC News', 'url' => 'https://www.bbc.com'],
            ['name' => 'CNN', 'url' => 'https://www.cnn.com'],
            ['name' => 'Reuters', 'url' => 'https://www.reuters.com'],
        ];

        foreach ($sources as $source) {
            Source::create($source);
        }
    }
}

