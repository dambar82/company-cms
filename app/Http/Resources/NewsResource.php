<?php

namespace App\Http\Resources;

use App\Models\NewsContent;
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
        $content = NewsContent::where('news_id', $this->id)
            ->select('position', 'text', 'image', 'video', 'link')
            ->orderBy('position')
            ->get()
            ->values()
            ->toArray();

        if ($content) {
            foreach ($content as $key => $item) {
                if (!empty($item['image'])) {
                    $content[$key]['image'] = asset('storage/' . $item['image']);
                }

                if (!empty($item['video'])) {
                    $content[$key]['video'] = asset('storage/' . $item['video']);
                }
            }
        }

        $date = date('d-m-Y', strtotime($this->date));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $date,
            'content' => $content
        ];
    }
}
