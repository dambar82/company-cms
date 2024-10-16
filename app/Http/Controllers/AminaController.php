<?php

namespace App\Http\Controllers;


use App\Http\Resources\AminaAudioResource;
use App\Http\Resources\AminaNewsResource;
use App\Http\Resources\AminaVideoResource;
use App\Models\Audio;
use App\Models\News;
use App\Models\Video;


class AminaController extends Controller
{
    public function getAudios()
    {
        return AminaAudioResource::collection(Audio::all());
    }

    public function getAudio(int $id)
    {
        return new AminaAudioResource(Audio::find($id));
    }

    public function getAllNews()
    {
        $newsWithImages = News::where('images', '!=', '[]')->orderBy('created_at', 'desc')->get();
        $newsWithoutImages = News::where('images', '=', '[]')->orderBy('created_at', 'desc')->get();
        $allNews = $newsWithImages;

        foreach ($newsWithoutImages as $news) {
            $allNews[] = $news;
        }

        return AminaNewsResource::collection($allNews);
    }

    public function getNews(int $id)
    {
        return new AminaNewsResource(News::find($id));
    }

    public function getVideos()
    {
        return AminaVideoResource::collection(Video::all());
    }

    public function getVideo(int $id)
    {
        return new AminaVideoResource(Video::find($id));
    }
}
