<?php

namespace App\Services;

use App\Models\Startup;

class StartupService
{
    public function getAll()
    {
        return Startup::all();
    }

    public function create(array $data)
    {
        $startup = Startup::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/startup', 'public');
            $startup->image()->create(['path' => $imagePath]);
        }

        return $startup;
    }

    public function update(Startup $startup, array $data)
    {
        $startup->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/startup', 'public');
            if ($startup->image) {
                // delete the image
                $startup->image->delete();
            }
            $startup->image()->create(['path' => $imagePath]);
        }
        return $startup;
    }

    public function delete(Startup $startup)
    {
        if ($startup->image) {
            $startup->image->delete();
        }
        return $startup->delete();
    }
}
