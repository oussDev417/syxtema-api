<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'profession' => $this->profession,
            'facebook_url' => $this->facebook_url,
            'linkedin_url' => $this->linkedin_url,
            'avatar' => $this->avatar ? url('storage/' . $this->avatar->path) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}