<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PreferenceService;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    protected $preferenceService;

    public function __construct(PreferenceService $preferenceService)
    {
        $this->preferenceService = $preferenceService;
    }

    public function store(Request $request)
    {
        $preferences = $this->preferenceService->storePreferences($request->user(), $request->all());
        return response()->json($preferences);
    }

    public function show(Request $request)
    {
        $preferences = $this->preferenceService->getPreferences($request->user());
        return response()->json($preferences);
    }
}

