<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceRequest;
use App\Http\Resources\SourceResource;
use App\Services\SourceService;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    protected $sourceService;

    public function __construct(SourceService $sourceService)
    {
        $this->sourceService = $sourceService;
    }

    /**
     * @OA\Get(
     *     path="/sources",
     *     tags={"Sources"},
     *     summary="List all sources",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of sources",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Source"))
     *     )
     * )
     */
    public function index()
    {
        return SourceResource::collection($this->sourceService->getAllSources());
    }

    /**
     * @OA\Post(
     *     path="/sources",
     *     tags={"Sources"},
     *     summary="Create a new source",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Source")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Source created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Source")
     *     )
     * )
     */
    public function store(SourceRequest $request)
    {
        $source = $this->sourceService->createSource($request->validated());
        return new SourceResource($source);
    }

    /**
     * @OA\Get(
     *     path="/sources/{id}",
     *     tags={"Sources"},
     *     summary="Get a specific source",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the source",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Source details",
     *         @OA\JsonContent(ref="#/components/schemas/Source")
     *     )
     * )
     */
    public function show($id)
    {
        $source = $this->sourceService->getSourceById($id);
        return new SourceResource($source);
    }

    /**
     * @OA\Put(
     *     path="/sources/{id}",
     *     tags={"Sources"},
     *     summary="Update a source",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the source",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Source")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Source updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Source")
     *     )
     * )
     */
    public function update(SourceRequest $request, $id)
    {
        $source = $this->sourceService->updateSource($id, $request->validated());
        return new SourceResource($source);
    }

    /**
     * @OA\Delete(
     *     path="/sources/{id}",
     *     tags={"Sources"},
     *     summary="Delete a source",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the source",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Source deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->sourceService->deleteSource($id);
        return response()->json(null, 204);
    }
}
