<?php

namespace App\Http\Controllers;

use App\Http\Resources\PosterResource;
use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    public function getAllPosters()
    {
        return PosterResource::collection(Poster::all());
    }

    public function getPoster(Poster $poster)
    {
        return new PosterResource($poster);
    }
}
