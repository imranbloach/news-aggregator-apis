<?php

namespace App\Repositories;

use App\Models\Preference;
use Illuminate\Support\Facades\Log;

class PreferenceRepository
{
    public function savePreferences($user, $data)
    {
        return $data = Preference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'categories' => $data['categories'] ?? [],
                'sources' => $data['sources'] ?? [],
                'authors' => $data['authors'] ?? [],
            ]
        );
        Log::info('Saving preferences:', ['user_id' => $user->id, 'data' => $data]);

    }

    public function getUserPreferences($user)
    {
        $preference = Preference::where('user_id', $user->id)->first();

        if (!$preference) {
            return null;
        }

        return [
            'categories' => is_string($preference->categories) ? json_decode($preference->categories, true) : $preference->categories,
            'sources' => is_string($preference->sources) ? json_decode($preference->sources, true) : $preference->sources,
            'authors' => is_string($preference->authors) ? json_decode($preference->authors, true) : $preference->authors,
        ];
    }


}
