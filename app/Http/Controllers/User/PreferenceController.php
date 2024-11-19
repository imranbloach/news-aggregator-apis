<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\PreferenceService;
use App\Http\Requests\StorePreferenceRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    protected $preferenceService;

    public function __construct(PreferenceService $preferenceService)
    {
        $this->preferenceService = $preferenceService;
    }

    /**
     * @OA\Post(
     *     path="/save-preferences",
     *     tags={"Preferences"},
     *     summary="Store or update user preferences",
     *     security={{"sanctum": {}}},
     *     description="Stores or updates the categories, sources, and authors preferences for a user.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="categories", type="array", @OA\Items(type="integer"), example={1, 2}),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="integer"), example={3, 4}),
     *             @OA\Property(property="authors", type="array", @OA\Items(type="integer"), example={5, 6})
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Preferences stored successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="authors", type="array", @OA\Items(type="integer")),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bad request due to invalid input")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(StorePreferenceRequest $request)
    {
        $preferences = $this->preferenceService->storePreferences($request->user(), $request->validated());
        return response()->json($preferences, 201);
    }

    /**
     * @OA\Get(
     *     path="/get-preferences",
     *     tags={"Preferences"},
     *     summary="Get user preferences",
     *     security={{"sanctum": {}}},
     *     description="Retrieves the stored preferences for categories, sources, and authors for the authenticated user.",
     *     @OA\Response(
     *         response=200,
     *         description="Preferences retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="string")),
     *             @OA\Property(property="authors", type="array", @OA\Items(type="string")),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bad request due to invalid input")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Preferences not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No preferences found")
     *         )
     *     )
     * )
     */
    public function show(Request $request)
    {
        $preferences = $this->preferenceService->getPreferences($request->user());
        if (empty($preferences)) {
            return response()->json(['message' => 'No preferences found'], 404);
        }

        return response()->json($preferences);
    }

    /**
     * @OA\Get(
     *     path="/preferences/news",
     *     tags={"Preferences"},
     *     summary="Get personalized news based on user preferences",
     *     description="Fetch a personalized news feed based on the user's preferred categories, sources, and authors.",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Personalized news feed retrieved successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Article"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No preferences found for user",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No personalized news found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function getPersonalizedNews()
    {
        $newsFeed = $this->preferenceService->fetchPersonalizedNews();

        return response()->json([
            'message' => 'Personalized news feed retrieved successfully',
            'data' => ArticleResource::collection($newsFeed)
        ]);
    }
}
