<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'images' => $this->images != null ? asset('storage/') . '/' . $this->images : null,
            'documents' => $this->documents != null ? asset('storage/') . '/' . $this->documents : null,
            'audios' => $this->audios != null ? asset('storage/') . '/' . $this->audios : null,
            'videos' => $this->videos != null ? asset('storage/') . '/' . $this->videos : null,
        ];
    }
}
