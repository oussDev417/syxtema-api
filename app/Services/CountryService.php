<?php

namespace App\Services;

use App\Models\Country;

class CountryService
{
    public function getAll()
    {
        return Country::all();
    }

    public function create(array $data)
    {
        if (isset($data['flag'])) {
            $imagePath = $data['flag']->store('images/country', 'public'); // Déplace l'image
            $data['flag'] = $imagePath; // Met à jour le chemin de l'image
        }
        return Country::create($data);
    }

    public function update(Country $country, array $data)
    {
        if (isset($data['flag'])) {
            $imagePath = $data['flag']->store('images/country', 'public'); // Déplace l'image
            $data['flag'] = $imagePath; // Met à jour le chemin de l'image
        }
        $country->update($data);
        return $country;
    }

    public function delete(Country $country)
    {
        return $country->delete();
    }
} 