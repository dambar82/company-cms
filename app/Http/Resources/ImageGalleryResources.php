<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageGalleryResources extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'caption' => $this->caption != null ? asset('storage/') . '/' . $this->caption : null,
            'images' => ImageResources::collection($this->images)
        ];
    }
}
