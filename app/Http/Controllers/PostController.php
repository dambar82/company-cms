<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/blog/posts",
     *     summary="Получить список всех записей",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Список публикаций успешно получен",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items()
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера",
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::all());
    }

    /**
     * @OA\Get(
     *     path="/api/blog/posts/{post}",
     *     summary="Получить запись по ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID публикации",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Публикация успешно получена",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Публикация не найдена",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера",
     *     )
     * )
     */
    public function getPost(Post $post): PostResource
    {
        return new PostResource($post);
    }
}
