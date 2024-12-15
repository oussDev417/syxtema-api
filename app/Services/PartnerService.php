<?php

namespace App\Services;

use App\Models\Partner;

class PartnerService
{
    public function create(array $data): Partner
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/partners', 'public');
            $data['image'] = $imagePath;
        }
        return Partner::create($data);
    }

    public function update(Partner $partner, array $data): Partner
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/partners', 'public');
            $data['image'] = $imagePath;
        }
        $partner->update($data);
        return $partner;
    }

    public function delete(Partner $partner)
    {
        return $partner->delete();
    }

    public function getAll()
    {
        return Partner::all();
    }
}
