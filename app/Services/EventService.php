<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function create(array $data): Event
    {
        $event = Event::create($data);
        if (isset($data['thumbnail'])) {
            $imagePath = $data['thumbnail']->store('images/events', 'public');
            $event->thumbnail()->create(['path' => $imagePath]);
        }
        return $event;
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        if (isset($data['thumbnail'])) {
            $imagePath = $data['thumbnail']->store('images/events', 'public');
            if ($event->thumbnail) {
                // delete the thumbnail
                $event->thumbnail->delete();
            }
            $event->thumbnail()->create(['path' => $imagePath]);
        }
        return $event;
    }

    public function delete(Event $event)
    {
        if ($event->thumbnail) {
            $event->thumbnail->delete();
        }
        return $event->delete();
    }

    public function getAll()
    {
        return Event::all();
    }
}
