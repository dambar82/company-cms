<?php

namespace App\Http\Resources\MDT;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $service = Service::find($this->service_id);
        $category = Category::find($this->category_id);
        return [
            'service' => [
                'name' => $service->name,
                'slug' => $service->slug
                ],
            'category' => [
                'name' => $category->name,
                'slug' => $category->slug
                ],
            'content' => [
                    'id' => $this->id,
                    'description' => $this->description,
                    'image' => $this->image ? asset('storage/' . $this->image) : null,
                    'preview' => $this->preview ? asset('storage/' . $this->preview) : null,
                    'video' => $this->video ? asset('storage/' . $this->video) : null,
                ]
        ];
    }
}
