<?php

namespace App\Services;

use App\Models\Temoignage;

class TestimonialService
{
    public function create(array $data): Temoignage
    {
        $testimonial = Temoignage::create($data);
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/testimonials', 'public');
            $testimonial->avatar()->create(['path' => $imagePath]);
        }
        return $testimonial;
    }

    public function update(Temoignage $testimonial, array $data): Temoignage
    {
        $testimonial->update($data);
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/testimonials', 'public');
            if ($testimonial->avatar) {
                // delete the avatar
                $testimonial->avatar->delete();
            }
            $testimonial->avatar()->create(['path' => $imagePath]);
        }
        return $testimonial;
    }

    public function delete(Temoignage $testimonial)
    {
        if ($testimonial->avatar) {
            $testimonial->avatar->delete();
        }
        return $testimonial->delete();
    }

    public function getAll()
    {
        return Temoignage::all();
    }
}
