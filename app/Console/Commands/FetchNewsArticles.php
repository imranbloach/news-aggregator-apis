<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Log;

class FetchNewsArticles extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch and save articles from News APIs to local database based on categories';

    protected $newsController;

    public function __construct(NewsController $newsController)
    {
        parent::__construct();
        $this->newsController = $newsController;
    }

    public function handle()
    {
        // Get categories from the database and use them as search queries
        $categories = Category::pluck('name'); // Assumes 'name' column holds category names

        foreach ($categories as $query) {
            $this->info("Fetching articles for query: {$query}");
            Log::info("Fetching articles for query: {$query}");
            try {
                $this->newsController->fetchAndSaveArticles($query);
                $this->info("Successfully fetched and saved articles for: {$query}");
            } catch (\Exception $e) {
                $this->error("Failed to fetch articles for {$query}: " . $e->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}
