<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'recruitment_id' => $this->recruitment_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'cv' => $this->cv ? asset('storage/' . $this->cv) : null,
            'cover_letter' => $this->cover_letter ? asset('storage/' . $this->cover_letter) : null,
            'status' => $this->status,
            'recruitment' => new RecruitmentResource($this->whenLoaded('recruitment')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
