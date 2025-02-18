<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoworkingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'map_url' => $this->map_url,
            'location' => $this->location,
            'price' => $this->price,
            'advantage' => $this->advantage,
            'capacity' => $this->capacity,
            'status' => $this->status,
            'image' => $this->image ? asset('storage/' . $this->image->path) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 