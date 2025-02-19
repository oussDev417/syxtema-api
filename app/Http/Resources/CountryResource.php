<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'short_name' => $this->short_name,
            'country_name' => $this->country_name,
            'slug' => $this->slug,
            'location_map_url' => $this->location_map_url,
            'phonecode' => $this->phonecode,
            'continent' => $this->continent,
            'status' => $this->status,
            'flag' => $this->flag ? asset('storage/' . $this->flag->path) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 