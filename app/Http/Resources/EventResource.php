<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'price' => $this->price,
            'number_of_ticket' => $this->number_of_ticket,
            'number_of_ticket_left' => $this->number_of_ticket_left,
            'description' => $this->description,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail->path) : null,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'country' => [
                'id' => $this->country->id,
                'country_name' => $this->country->country_name,
            ],
            'departement' => [
                'id' => $this->departement->id,
                'name' => $this->departement->name,
            ],
            'created_at' => $this->created_at,
        ];
    }
}