<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    public function create(array $data): Team
    {
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/teams', 'public');
            $data['avatar'] = $imagePath;
        }
        return Team::create($data);
    }

    public function update(Team $team, array $data): Team
    {
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/teams', 'public');
            $data['avatar'] = $imagePath;
        }
        $team->update($data);
        return $team;
    }

    public function delete(Team $team)
    {
        return $team->delete();
    }

    public function getAll()
    {
        return Team::all();
    }
}
