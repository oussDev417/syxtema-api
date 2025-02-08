<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->nom,
            'role' => $this->profession,
            'content' => $this->message,
            'photo' => $this->avatar ? asset('storage/' . $this->avatar->path) : null,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
} 