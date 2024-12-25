<?php

namespace App\Services;

use App\Models\SuccessStories;

class SuccessStoryService
{
    public function getAll()
    {
        return SuccessStories::all();
    }

    public function create(array $data)
    {
        $success_story = SuccessStories::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/success-stories', 'public');
            $success_story->image()->create(['path' => $imagePath]);
        }

        return $success_story;
    }

    public function update(SuccessStories $success_story, array $data)
    {
        $success_story->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/success-stories', 'public');
            if ($success_story->image) {
                // delete the image
                $success_story->image->delete();
            }
            $success_story->image()->create(['path' => $imagePath]);
        }
        return $success_story;
    }

    public function delete(SuccessStories $success_story)
    {
        if ($success_story->image) {
            $success_story->image->delete();
        }
        return $success_story->delete();
    }
}
