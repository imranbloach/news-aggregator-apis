<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="News Aggregator API",
 *     version="1.0.0",
 *     description="API documentation for the News Aggregator application."
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Use 'Bearer {token}' to authenticate requests."
 * )
 * 
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     title="Article",
 *     description="An article object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The ID of the article"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the article"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="The content of the article"
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="The URL of the article"
 *     ),
 *     @OA\Property(
 *         property="source",
 *         type="string",
 *         description="The source name of the article"
 *     ),
 *     @OA\Property(
 *         property="category",
 *         type="string",
 *         description="The category name of the article"
 *     ),
 *     @OA\Property(
 *         property="published_at",
 *         type="string",
 *         format="date-time",
 *         description="The publication date of the article"
 *     ),
 *     @OA\Property(
 *         property="author_id",
 *         type="integer",
 *         nullable=true,
 *         description="The ID of the author associated with the article"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         nullable=true,
 *         description="The ID of the category associated with the article"
 *     ),
 *     @OA\Property(
 *         property="source_id",
 *         type="integer",
 *         nullable=true,
 *         description="The ID of the source associated with the article"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The creation date of the article in the local database"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The last update date of the article in the local database"
 *     ),
 * )
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="slug", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="bio", type="string"),
 *     @OA\Property(property="profile_url", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * @OA\Schema(
 *     schema="Source",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="url", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
 



class SwaggerController extends Controller
{
    // This file is for Swagger documentation only.
}
