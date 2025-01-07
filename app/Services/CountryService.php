<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function getAll()
    {
        return Country::all();
    }

    public function create(array $data): Country
    {
        $country = Country::create($data);
        if (isset($data['flag'])) {
            $imagePath = $data['flag']->store('images/country', 'public'); // store the image
            $country->flag()->create(['path' => $imagePath]);
        }
        return $country;
    }

    public function update(Country $country, array $data): Country
    {
        $country->update($data);
        if (isset($data['flag'])) {
            $imagePath = $data['flag']->store('images/country', 'public'); // Stocker l'image
            if ($country->flag) {
                $country->flag->delete();
            }
            $country->flag()->create(['path' => $imagePath]);
        }
        return $country;
    }

    public function delete(Country $country)
    {
        if ($country->flag) {
            $country->flag->delete();
        }
        return $country->delete();
    }
}
