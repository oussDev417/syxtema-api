<?php

namespace App\Services;

use App\Models\Temoignage;

class TestimonialService
{
    public function create(array $data): Temoignage
    {
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/testimonials', 'public');
            $data['avatar'] = $imagePath;
        }
        return Temoignage::create($data);
    }

    public function update(Temoignage $testimonial, array $data): Temoignage
    {
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/testimonials', 'public');
            $data['avatar'] = $imagePath;
        }
        $testimonial->update($data);
        return $testimonial;
    }

    public function delete(Temoignage $testimonial)
    {
        return $testimonial->delete();
    }

    public function getAll()
    {
        return Temoignage::all();
    }
}
