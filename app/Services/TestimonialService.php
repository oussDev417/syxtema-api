<?php

namespace App\Services;

use App\Models\Temoignage;

class TestimonialService
{
    public function create(array $data): Temoignage
    {
        return Temoignage::create($data);
    }

    public function update(Temoignage $testimonial, array $data): Temoignage
    {
        $testimonial->update($data);
        return $testimonial;
    }

    public function delete(Temoignage $testimonial): void
    {
        $testimonial->delete();
    }

    public function getAll()
    {
        return Temoignage::all();
    }
}
