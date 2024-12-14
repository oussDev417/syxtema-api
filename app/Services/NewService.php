<?php

namespace App\Services;

use App\Models\News;

class NewService
{
    public function create(array $data): News
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/news', 'public');
            $data['image'] = $imagePath;
        }
        return News::create($data);
    }

    public function update(News $new, array $data): News
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/news', 'public');
            $data['image'] = $imagePath;
        }
        $new->update($data);
        return $new;
    }

    public function delete(News $new): void
    {
        $new->delete();
    }

    public function getAll()
    {
        return News::all();
    }
}
