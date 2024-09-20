<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoGalleryResources extends JsonResource
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
            'preview' => $this->preview != null ? asset('storage/') . '/' . $this->preview : null,
            'video' => $this->video != null ? asset('storage/') . '/' . $this->video : null
        ];
    }
}
