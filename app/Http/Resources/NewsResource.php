<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image->path) : null,
            'country' => [
                'id' => $this->country->id,
                'country_name' => $this->country->country_name,
            ],
            'created_at' => $this->created_at,
            'status' => $this->status
        ];
    }
}