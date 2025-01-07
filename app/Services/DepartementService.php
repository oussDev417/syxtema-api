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
        $departement = Departement::create($data);
        if (isset($data['logo'])) {
            $imagePath = $data['logo']->store('images/departements', 'public');
            $departement->logo()->create(['path' => $imagePath]);
        }
        return $departement;
    }

    public function update(Departement $departement, array $data)
    {
        $departement->update($data);
        if (isset($data['logo'])) {
            $imagePath = $data['logo']->store('images/departements', 'public');
            if ($departement->logo) {
                $departement->logo->delete();
            }
            $departement->logo()->create(['path' => $imagePath]);
        }
        return $departement;
    }

    public function delete(Departement $departement)
    {
        if ($departement->logo) {
            $departement->logo->delete();
        }
        return $departement->delete();
    }
}
