<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    public function create(array $data): Team
    {
        $team = Team::create($data);
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/teams', 'public');
            $team->avatar()->create(['path' => $imagePath]);
        }
        return $team;
    }

    public function update(Team $team, array $data): Team
    {
        $team->update($data);
        if (isset($data['avatar'])) {
            $imagePath = $data['avatar']->store('images/teams', 'public');
            if ($team->avatar) {
                $team->avatar()->delete();
            }
            $team->avatar()->create(['path' => $imagePath]);
        }
        return $team;
    }

    public function delete(Team $team)
    {
        if ($team->avatar) {
            $team->avatar()->delete();
        }
        return $team->delete();
    }

    public function getAll()
    {
        return Team::all();
    }
}
