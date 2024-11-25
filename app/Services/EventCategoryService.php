<?php

namespace App\Services;

use App\Models\EventCategory;

class EventCategoryService
{
    public function create(array $data): EventCategory
    {
        return EventCategory::create($data);
    }

    public function update(EventCategory $category, array $data): EventCategory
    {
        $category->update($data);
        return $category;
    }

    public function delete(EventCategory $category): void
    {
        $category->delete();
    }

    public function getAll()
    {
        return EventCategory::all();
    }
} 