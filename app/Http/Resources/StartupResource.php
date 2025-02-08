<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StartupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'secteur' => $this->secteur,
            'description' => $this->description,
            'image' => $this->image ? asset('storage/' . $this->image->path) : null,
            'created_at' => $this->created_at,
        ];
    }
}