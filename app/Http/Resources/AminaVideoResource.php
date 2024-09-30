<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AminaVideoResource extends JsonResource
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
            'video' => $this->path != null ? asset('storage/') . '/' . $this->path : null,
            'preview' => $this->preview != null ? asset('storage/') . '/' . $this->preview : null,
        ];
    }
}
