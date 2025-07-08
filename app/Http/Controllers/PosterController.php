<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    public function getAllPosters()
    {
        return Poster::select('id', 'poster_rus', 'poster_tat')
            ->get()
            ->map(function ($poster) {
                $poster->poster_rus = asset('storage/' . $poster->poster_rus);
                $poster->poster_tat = asset('storage/' . $poster->poster_tat);
                return $poster;
            });
    }

    public function getPoster(Poster $poster)
    {
        return Poster::where('id', $poster->id)
            ->select('id', 'poster_rus', 'poster_tat')
            ->get()
            ->map(function ($poster) {
                $poster->poster_rus = asset('storage/' . $poster->poster_rus);
                $poster->poster_tat = asset('storage/' . $poster->poster_tat);
                return $poster;
            });
    }
}
