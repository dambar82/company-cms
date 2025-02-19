<?php

namespace App\Http\Resources\MDT;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'description' => $this->description,
            'preview' => asset('storage/' . $this->preview),
            'video' => asset('storage/' . $this->video),
        ];
    }
}
