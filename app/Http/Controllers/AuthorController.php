<?php
namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * @OA\Get(
     *     path="/authors",
     *     tags={"Authors"},
     *     summary="List all authors",
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of authors",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Author"))
     *     )
     * )
     */
    public function index()
    {
        return AuthorResource::collection($this->authorService->getAllAuthors());
    }

    /**
     * @OA\Post(
     *     path="/authors",
     *     tags={"Authors"},
     *     summary="Create a new author",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function store(AuthorRequest $request)
    {
        $author = $this->authorService->createAuthor($request->validated());
        return new AuthorResource($author);
    }

    /**
     * @OA\Get(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Get a specific author",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author details",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function show($id)
    {
        $author = $this->authorService->getAuthorById($id);
        return new AuthorResource($author);
    }

    /**
     * @OA\Put(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Update an author",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function update(AuthorRequest $request, $id)
    {
        $author = $this->authorService->updateAuthor($id, $request->validated());
        return new AuthorResource($author);
    }

    /**
     * @OA\Delete(
     *     path="/authors/{id}",
     *     tags={"Authors"},
     *     summary="Delete an author",
      *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the author",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Author deleted successfully"
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->authorService->deleteAuthor($id);
        return response()->json(null, 204);
    }
}

