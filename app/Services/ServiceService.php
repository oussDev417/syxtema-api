<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    public function getAll()
    {
        return Service::with(['category', 'departement'])->get();
    }

    public function create(array $data)
    {
        $service = Service::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public');
            $service->image()->create(['path' => $imagePath]);
        }
        return $service;
    }

    public function update(Service $service, array $data)
    {
        $service->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public');
            if ($service->image) {
                // delete the image
                $service->image->delete();
            }
            $service->image()->create(['path' => $imagePath]);
        }
        return $service;
    }

    public function delete(Service $service)
    {
        if ($service->image) {
            $service->image->delete();
        }
        return $service->delete();
    }
}
