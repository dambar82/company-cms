<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = [];

        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                $images[] = asset('storage/') . '/' . $image;
            }
        }

        $date = date('d-m-Y', strtotime($this->date));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'images' => $images,
            'date' => $date
        ];
    }
}
