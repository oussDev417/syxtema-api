<?php

namespace App\Services;

use App\Models\ServiceCategory;

class ServiceCategoryService
{
    public function getAll()
    {
        return ServiceCategory::all();
    }

    public function create(array $data)
    {
        return ServiceCategory::create($data);
    }

    public function update(ServiceCategory $serviceCategory, array $data)
    {
        $serviceCategory->update($data);
        return $serviceCategory;
    }

    public function delete(ServiceCategory $serviceCategory)
    {
        return $serviceCategory->delete();
    }
} 