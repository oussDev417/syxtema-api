<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'file_pdf' => $this->file_pdf ? asset('storage/' . $this->file_pdf) : null,
            'deadline' => $this->deadline->format('Y-m-d'),
            'deadline_formatted' => $this->deadline->format('d/m/Y'),
            'is_expired' => $this->isExpired(),
            'country' => [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
