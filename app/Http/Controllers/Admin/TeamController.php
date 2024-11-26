<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\StoreTestimonialRequest;
use App\Models\Team;
use App\Services\TeamService;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index()
    {
        $teams = $this->teamService->getAll();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('admin.teams.create', compact('teams'));
    }

    public function store(StoreTeamRequest $request)
    {
        $this->teamService->create($request->validated());
        return redirect()->route('admin.teams.index')->with('success', 'Membre créé avec succès.');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
    }

    public function update(StoreTestimonialRequest $request, $id)
    {
        $team = Team::findOrFail($id);
        $this->teamService->update($team, $request->validated());
        return redirect()->route('admin.teams.index')->with('success', 'Membre mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $this->teamService->delete($team);
        return redirect()->route('admin.teams.index')->with('success', 'Membre supprimé avec succès.');
    }
}
