<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PosterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rus' => [
                'title' => $this->title_rus,
                'poster' => asset('/storage/' . $this->poster_rus)
            ],
            'tat' => [
                'title' => $this->title_tat,
                'poster' => asset('/storage/' . $this->poster_tat)
            ]
        ];
    }
}
