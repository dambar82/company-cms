<?php

namespace App\Http\Controllers;

use App\Http\Resources\AudioResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\VideoGalleryResources;
use App\Http\Traits\CheckForbiddenWordTrait;
use App\Models\AminaFeedback;
use App\Models\Audio;
use App\Models\News;
use App\Models\VideoGallery;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *     title="COMPANY-CMS",
 *     version="1.0.0",
 * )
 */
class AminaController extends Controller
{
    use CheckForbiddenWordTrait;

    /**
     * @OA\Get(
     *     path="/api/amina/audios",
     *     tags={"Amina"},
     *     summary="Все аудио записи",
     *     description="Returns a collection of audio resources belonging to the project with ID 1.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No audios found for the specified project",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function getAudios(): AnonymousResourceCollection
    {
        return AudioResource::collection(
        Audio::query()
            ->whereHas('projects', function ($query) {
            $query->where('project_id', 1);
        })->get()
    );
    }

    /**
     * @OA\Get(
     *     path="/api/amina/audios/{id}",
     *     tags={"Amina"},
     *     summary="Аудио запись по ID",
     *     description="Returns an audio resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the audio record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Audio record not found",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function getAudio(int $id): AudioResource
    {
        $audio = Audio::query()
            ->whereHas('projects', function ($query) {
            $query->where('project_id', 1);
        })->findOrFail($id);

        return new AudioResource($audio);
    }

    /**
     * @OA\Get(
     *     path="/api/amina/news",
     *     tags={"Amina"},
     *     summary="Все новости",
     *     description="Returns a collection of news articles filtered by project ID 1, including articles with and without images.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No news found for the specified project",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function getAllNews(): AnonymousResourceCollection
    {
        $newsWithImages = News::query()
            ->whereHas('projects', function ($query) {
                $query->where('project_id', 1);
            })
            ->where('active', true)
            ->whereNotNull('images')
            ->where('images', '<>', '[]')
            ->orderBy('created_at', 'desc')
            ->get();

        $newsWithoutImages = News::query()
            ->whereHas('projects', function ($query) {
                $query->where('project_id', 1);
            })
            ->where('active', true)
            ->whereNull('images')
            ->orWhere('images', '=', '[]')
            ->orderBy('created_at', 'desc')
            ->get();

        $allNews = $newsWithImages->merge($newsWithoutImages);

        return NewsResource::collection($allNews);
    }

    /**
     * @OA\Get(
     *     path="/api/amina/news/{id}",
     *     tags={"Amina"},
     *     summary="Новость по ID",
     *     description="Returns a news article for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the news article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="News record not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getNews(int $id): NewsResource
    {
        $news = News::query()
            ->whereHas('projects', function ($query) {
            $query->where('project_id', 1);
        })->findOrFail($id);

        return new NewsResource($news);
    }

    /**
     * @OA\Get(
     *     path="/api/amina/videos",
     *     tags={"Amina"},
     *     summary="Все видео",
     *     description="Returns a collection of video resources filtered by project ID 1.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No videos found for the specified project",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getVideos(): AnonymousResourceCollection
    {
        return VideoGalleryResources::collection(
            VideoGallery::query()
            ->whereHas('projects', function ($query) {
                $query->where('project_id', 1)->where('is_published', 1);
            })->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/amina/videos/{id}",
     *     tags={"Amina"},
     *     summary="Видео по ID",
     *     description="Returns a video resource for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the video record",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video record not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getVideo(int $id): VideoGalleryResources
    {
        $videoGallery = VideoGallery::query()
            ->whereHas('projects', function ($query) {
            $query->where('project_id', 1)->where('is_published', 1);
        })->findOrFail($id);

        return new VideoGalleryResources($videoGallery);
    }

    public function addFeedback(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'text' => 'required|string|min:10|max:255',
                'image' => 'required|file|mimes:jpg,jpeg,png,svg|max:2000',
                'organization' => 'nullable|string|max:255',
                'private_person' => 'nullable|boolean'
            ]);

            if (!$this->checkForbiddenWord($validated['text'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Текст содержит запрещенные слова. Пожалуйста, измените текст и попробуйте снова.'
                ], 422);
            }

            $image = $request->file('image');
            $path = $image->store('amina/feedbacks', 'public');

            AminaFeedback::create([
                'text' => $validated['text'],
                'image' => $path,
                'organization' => $validated['organization'] ?? null,
                'private_person' => $validated['private_person'] ?? false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Отзыв успешно добавлен',
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при добавлении отзыва',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
