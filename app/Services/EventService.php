<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function create(array $data): Event
    {
        if (isset($data['thumbnail'])) {
            $imagePath = $data['thumbnail']->store('images/events', 'public');
            $data['thumbnail'] = $imagePath;
        }
        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        if (isset($data['thumbnail'])) {
            $imagePath = $data['thumbnail']->store('images/events', 'public');
            $data['thumbnail'] = $imagePath;
        }
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): void
    {
        $event->delete();
    }

    public function getAll()
    {
        return Event::all();
    }
} 