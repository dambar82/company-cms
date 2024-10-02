<?php

namespace App\Http\Controllers;


use App\Http\Resources\AminaAudioResource;
use App\Http\Resources\AminaNewsResource;
use App\Http\Resources\AminaVideoResource;
use App\Models\AminaAudio;
use App\Models\AminaNews;
use App\Models\AminaVideo;
use Illuminate\Support\Facades\Log;


class AminaController extends Controller
{
    public function getAudios()
    {
        return AminaAudioResource::collection(AminaAudio::all());
    }

    public function getAudio(int $id)
    {
        return new AminaAudioResource(AminaAudio::find($id));
    }

    public function getAllNews()
    {
        $newsWithImages = AminaNews::where('images', '!=', '[]')->orderBy('created_at', 'desc')->get();
        $newsWithoutImages = AminaNews::where('images', '=', '[]')->orderBy('created_at', 'desc')->get();
        $allNews = $newsWithImages;

        foreach ($newsWithoutImages as $news) {
            $allNews[] = $news;
        }

        return AminaNewsResource::collection($allNews);
    }

    public function getNews(int $id)
    {
        return new AminaNewsResource(AminaNews::find($id));
    }

    public function getVideos()
    {
        return AminaVideoResource::collection(AminaVideo::all());
    }

    public function getVideo(int $id)
    {
        return new AminaVideoResource(AminaVideo::find($id));
    }
}
