<?php

namespace App\Services;

use App\Repositories\PreferenceRepository;

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
}
