<?php

namespace App\Services;

use App\Models\News;

class NewService
{
    public function create(array $data): News
    {
        $news = News::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/news', 'public');
            $news->image()->create(['path' => $imagePath]);
        }
        return $news;
    }

    public function update(News $new, array $data): News
    {
        $new->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/news', 'public');
            if ($new->image) {
                // delete the image
                $new->image->delete();
            }
            $new->image()->create(['path' => $imagePath]);
        }
        return $new;
    }

    public function delete(News $new): void
    {
        if ($new->image) {
            // delete the image
            $new->image->delete();
        }
        $new->delete();
    }

    public function getAll()
    {
        return News::all();
    }
}
