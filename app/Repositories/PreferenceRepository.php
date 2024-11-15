<?php

namespace App\Repositories;

use App\Models\Preference;

class PreferenceRepository
{
    public function savePreferences($user, $data)
    {
        return Preference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'categories' => $data['categories'] ?? [],
                'sources' => $data['sources'] ?? [],
                'authors' => $data['authors'] ?? [],
            ]
        );
    }

    public function getUserPreferences($user)
    {
        return $user->preferences;
    }
}
