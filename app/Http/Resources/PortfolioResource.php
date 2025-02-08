<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'client' => $this->client,
            'url' => $this->url,
            'location' => $this->location,
            'image' => $this->image ? asset('storage/' . $this->image->path) : null,
            'departement' => [
                'id' => $this->departement->id,
                'name' => $this->departement->name
            ],
            'created_at' => $this->created_at
        ];
    }
}
