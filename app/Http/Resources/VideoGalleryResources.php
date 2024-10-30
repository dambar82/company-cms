<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoGalleryResources extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'preview' => $this->preview != null ? asset('storage/') . '/' . $this->preview : null,
            'video' => $this->video != null ? asset('storage/') . '/' . $this->video : null,
//            'videos' => VideoResource::collection($this->video)
        ];
    }
}
