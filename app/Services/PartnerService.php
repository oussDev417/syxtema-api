<?php

namespace App\Services;

use App\Models\Partner;

class PartnerService
{
    public function create(array $data): Partner
    {
        $partner = Partner::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/partners', 'public');
            $partner->logo()->create(['path' => $imagePath]);
        }
        return $partner;
    }

    public function update(Partner $partner, array $data): Partner
    {
        $partner->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/partners', 'public');
            if ($partner->logo) {
                $partner->logo->delete();
            }
            $partner->logo()->create(['path' => $imagePath]);
        }
        return $partner;
    }

    public function delete(Partner $partner)
    {
        if ($partner->logo) {
            $partner->logo->delete();
        }
        return $partner->delete();
    }

    public function getAll()
    {
        return Partner::all();
    }
}
