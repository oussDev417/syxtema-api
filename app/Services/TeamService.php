<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    public function create(array $data): Team
    {
        return Team::create($data);
    }

    public function update(Team $team, array $data): Team
    {
        $team->update($data);
        return $team;
    }

    public function delete(Team $team): void
    {
        $team->delete();
    }

    public function getAll()
    {
        return Team::all();
    }
}
