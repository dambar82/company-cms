<?php

namespace App\Http\Controllers;


use App\Http\Resources\AminaAudioResource;
use App\Http\Resources\AminaNewsResource;
use App\Http\Resources\AminaVideoResource;
use App\Models\Audio;
use App\Models\News;
use App\Models\VideoGallery;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Info(
 *     title="COMPANY-CMS",
 *     version="1.0.0",
 * )
 */
class AminaController extends Controller
{
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
        return AminaAudioResource::collection(Audio::all()->where('project_id', '=', 1));
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
    public function getAudio(int $id): AminaAudioResource
    {
        return new AminaAudioResource(Audio::query()->find($id));
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
            ->where('images', '!=', '[]')
            ->where('project_id', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $newsWithoutImages = News::query()
            ->where('images', '=', '[]')
            ->where('project_id', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        $allNews = $newsWithImages;

        foreach ($newsWithoutImages as $news) {
            $allNews[] = $news;
        }

        return AminaNewsResource::collection($allNews);
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
    public function getNews(int $id): AminaNewsResource
    {
        return new AminaNewsResource(News::query()->find($id));
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
        return AminaVideoResource::collection(VideoGallery::all()->where('project_id', '=', 1));
    }

    /**
     * @OA\Get(
     *     path="/api/amona/videos/{id}",
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
    public function getVideo(int $id): AminaVideoResource
    {
        return new AminaVideoResource(VideoGallery::query()->find($id));
    }
}
