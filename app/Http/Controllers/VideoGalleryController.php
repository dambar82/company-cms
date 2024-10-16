<?php

namespace App\Http\Controllers;

use App\Models\VideoGallery;
use Illuminate\Http\Request;
use App\Http\Resources\VideoGalleryResources;

class VideoGalleryController extends Controller
{
    public function index()
    {
        return ['videoGallery' => VideoGalleryResources::collection(VideoGallery::all()->where('project_id', '=', 2))];
    }

    public function show(int $id)
    {
        return  ['videoGallery' => new VideoGalleryResources(VideoGallery::findOrFail($id))];
    }
}
