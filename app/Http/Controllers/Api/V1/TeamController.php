<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        try {
            $teams = Team::with('avatar')
                ->orderBy('nom')
                ->get();

            return TeamResource::collection($teams);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des membres'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $team = Team::with('avatar')->findOrFail($id);
            return new TeamResource($team);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Membre non trouvé'
            ], 404);
        }
    }
}