<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageGalleryResources;
use App\Models\ImageGallery;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{
    public function index()
    {
        $num = 123;
        return ['imgGallery' => ImageGalleryResources::collection(ImageGallery::all())];
    }

    public function show(int $id)
    {
        return  ['imgGallery' => new ImageGalleryResources(ImageGallery::findOrFail($id))];
    }
}
