<?php

namespace App\Http\Resources\MDT;

use App\Models\MDT\Category;
use App\Models\MDT\Service;
use App\Models\MDT\ServiceContentImage;
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
        $images = ServiceContentImage::where('service_content_id', $this->id)->get();
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
                    'name' => $this->name,
                    'description' => $this->description,
                    'image' => $this->image ? asset('storage/' . $this->image) : null,
                    'preview' => $this->preview ? asset('storage/' . $this->preview) : null,
                    'video' => $this->video ? asset('storage/' . $this->video) : null,
                    'images' => $images->map(function($image) {
                        return [
                            'name' => $image->name,
                            'description' => $image->description,
                            'image' => $image->image ? asset('storage/' . $image->image) : null,
                        ];
                    }),
                    'is_first' => $this->is_first
                ]
        ];
    }
}
