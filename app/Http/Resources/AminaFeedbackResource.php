<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AminaFeedbackResource extends JsonResource
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
            'creator' => $this->creator,
            'organization' => $this->organization,
            'job_title' => $this->job_title,
            'region' => $this->region,
            'fio' => $this->fio,
            'email' => $this->email,
            'text' => $this->text,
            'images' => $this->images != null ? array_map(fn($file) => asset('storage') .'/'. $file  , $this->images) : null,
            'date' => $this->created_at->format('d/m/Y'),
        ];
    }
}
