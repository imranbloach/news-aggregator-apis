<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\PreferenceRepository;
use Illuminate\Support\Facades\Auth;

class PreferenceService
{
    protected $preferenceRepo;

    public function __construct(PreferenceRepository $preferenceRepo)
    {
        $this->preferenceRepo = $preferenceRepo;
    }

    public function storePreferences($user, $data)
    {
        return $this->preferenceRepo->savePreferences($user, $data);
    }

    public function getPreferences($user)
    {
        return $this->preferenceRepo->getUserPreferences($user);
    }

    public function fetchPersonalizedNews($user)
    {
        // Retrieve user preferences from the repository
        $preferences = $this->preferenceRepo->getUserPreferences($user);

        if (!$preferences) {
            return response()->json(['message' => 'No preferences found for user'], 404);
        }

        // Fetch articles based on preferences
        $articles = Article::whereIn('category_id', $preferences['categories'])
            ->orWhereIn('source_id', $preferences['sources'])
            ->orWhereIn('author_id', $preferences['authors'])
            ->orderBy('published_at', 'desc')
            ->get();

        return $articles;
    }
}
