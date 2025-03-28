<?php

namespace App\Http\Controllers;

use App\Http\Resources\AminaFeedbackResource;
use App\Http\Resources\AudioResource;
use App\Http\Resources\AminaSongResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\VideoGalleryResources;
use App\Http\Traits\CheckForbiddenWordTrait;
use App\Models\AminaFeedback;
use App\Models\Audio;
use App\Models\District;
use App\Models\AminaSong;
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
     *     path="/api/amina/songs",
     *     tags={"Amina"},
     *     summary="Все песни",
     *     description="Returns a collection of songs.",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No songs found",
     *         @OA\JsonContent()
     *     ),
     * )
     */
    public function getAllSongs(): AnonymousResourceCollection
    {
        $songs = AminaSong::where('active', 1)->get();

        return AminaSongResource::collection($songs);
    }

    /**
     * @OA\Get(
     *     path="/api/amina/songs/{id}",
     *     tags={"Amina"},
     *     summary="Песня по ID",
     *     description="Returns a song for the specified ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the song",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Song record not found",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function getSong(int $id): AminaSongResource
    {
        return new AminaSongResource(AminaSong::find($id));
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

        /**
     * @OA\Post(
     *     path="/api/amina/add_feedback",
     *     tags={"Amina"},
     *     summary="Добавление отзыва",
     *     description="Метод позволяет пользователю добавить отзыв с текстом и изображением.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"creator", "region", "fio", "email", "text", "image"},
     *             @OA\Property(property="creator", type="string", example="Создатель"),
     *             @OA\Property(property="organization", type="string", example="Организация"),
     *             @OA\Property(property="job_title", type="string", example="Должность"),
     *             @OA\Property(property="region", type="string", example="Казань"),
     *             @OA\Property(property="fio", type="string", example="Иванов Иван Иванович"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="text", type="string", example="Текст отзыва"),
     *             @OA\Property(property="image", type="string", format="binary", description="Картинка")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Отзыв успешно добавлен",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка при добавлении отзыва",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function addFeedback(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'creator' => 'required|string',
                'organization' => 'nullable|string|max:60',
                'job_title' => 'nullable|string|max:60',
                'region' => 'required|string|max:20|min:3',
                'fio' => 'required|string|max:40|min:3',
                'email' => 'required|email|max:40|min:6',
                'text' => 'required|string|min:10|max:255',
                'images' => 'nullable|array',
                'images.*' => 'required|file|mimes:jpg,jpeg,png,svg|max:2048'
            ]);

            if (!$this->checkForbiddenWord($validated['text'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Текст содержит запрещенные слова. Пожалуйста, измените текст и попробуйте снова.'
                ], 422);
            }

            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('amina/feedbacks', 'public');
                        $images[] = $path;
                    }
                }
            }

            $feedbackData = $validated;
            $feedbackData['images'] = !empty($images) ? json_encode($images) : null;

            AminaFeedback::create($feedbackData);

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

    /**
     * @OA\Get(
     *     path="/api/amina/new_feedbacks",
     *     tags={"Amina"},
     *     summary="Выводит сначала новые отзывы",
     *     description="Returns a collection of feedback filtered by project ID 1.",
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
    public function getNewFeedbacks(): AnonymousResourceCollection
    {
        return AminaFeedbackResource::collection(AminaFeedback::all()->sortDesc());
    }

    /**
     * @OA\Get(
     *     path="/api/amina/old_feedbacks",
     *     tags={"Amina"},
     *     summary="Выводит сначала старые отзывы",
     *     description="Returns a collection of feedback filtered by project ID 1.",
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
    public function getOldFeedbacks(): AnonymousResourceCollection
    {
        return AminaFeedbackResource::collection(AminaFeedback::all());
    }

    /**
     * @OA\Get(
     *     path="/api/amina/image_feedbacks",
     *     tags={"Amina"},
     *     summary="Выводит сначала отзывы с картинками",
     *     description="Returns a collection of feedback filtered by project ID 1.",
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
    public function getImageFeedbacks(): AnonymousResourceCollection
    {
        return AminaFeedbackResource::collection(AminaFeedback::orderByRaw('images IS NULL, images')->get());
    }

    /**
     * @return array
     */
    public function getDistricts(): array
    {
        return District::all()->select('title')->toArray();
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
            ->where('active', true) // Изменено
            ->where(function ($query) {
                $query->whereNull('images')
                    ->orWhere('images', '=', '[]');
            })
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
    @@ -157,19 +135,14 @@ public function getAllNews(): AnonymousResourceCollection
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
}
