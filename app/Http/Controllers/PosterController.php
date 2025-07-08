<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    public function getAllPosters()
    {
        return Poster::select('id', 'poster')
            ->get()
            ->map(function ($poster) {
                $poster->poster = asset('storage/' . $poster->poster);
                return $poster;
            });
    }

    public function getPoster(Poster $poster)
    {
        return Poster::where('id', $poster->id)
            ->select('id', 'poster')
            ->get()
            ->map(function ($poster) {
                $poster->poster = asset('storage/' . $poster->poster);
                return $poster;
            });
    }
}
