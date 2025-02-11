<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'secteur' => $this->secteur,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $this->image ? asset('storage/' . $this->image->path) : null,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'departement' => [
                'id' => $this->departement->id,
                'name' => $this->departement->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}