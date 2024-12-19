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
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public'); 
            $data['image'] = $imagePath;
        }

        return Service::create($data);
    }

    public function update(Service $service, array $data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public');
            $data['image'] = $imagePath;
        }

        $service->update($data);
        return $service;
    }

    public function delete(Service $service)
    {
        return $service->delete();
    }
} 