<?php

namespace App\Http\Controllers;


use App\Http\Resources\AminaAudioResource;
use App\Http\Resources\AminaNewsResource;
use App\Http\Resources\AminaVideoResource;
use App\Models\Audio;
use App\Models\News;
use App\Models\VideoGallery;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class AminaController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function getAudios(): AnonymousResourceCollection
    {
        return AminaAudioResource::collection(Audio::all()->where('project_id', '=', 1));
    }

    /**
     * @param int $id
     * @return AminaAudioResource
     */
    public function getAudio(int $id): AminaAudioResource
    {
        return new AminaAudioResource(Audio::query()->find($id));
    }

    /**
     * @return AnonymousResourceCollection
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
     * @param int $id
     * @return AminaNewsResource
     */
    public function getNews(int $id): AminaNewsResource
    {
        return new AminaNewsResource(News::query()->find($id));
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getVideos(): AnonymousResourceCollection
    {
        return AminaVideoResource::collection(VideoGallery::all()->where('project_id', '=', 1));
    }

    /**
     * @param int $id
     * @return AminaVideoResource
     */
    public function getVideo(int $id): AminaVideoResource
    {
        return new AminaVideoResource(VideoGallery::query()->find($id));
    }
}
