<?php

namespace App\Services;

use App\Models\Departement;

class DepartementService
{
    public function getAll()
    {
        return Departement::all();
    }

    public function create(array $data)
    {
        if (isset($data['logo'])) {
            $imagePath = $data['logo']->store('images/departements', 'public');
            $data['logo'] = $imagePath;
        }
        return Departement::create($data);
    }

    public function update(Departement $departement, array $data)
    {
        if (isset($data['logo'])) {
            $imagePath = $data['logo']->store('images/departements', 'public');
            $data['logo'] = $imagePath;
        }
        $departement->update($data);
        return $departement;
    }

    public function delete(Departement $departement)
    {
        return $departement->delete();
    }
} 