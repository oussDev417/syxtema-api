<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartupResource;
use App\Models\Startup;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function index()
    {
            $startups = Startup::with('image')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return StartupResource::collection($startups);
    }

    public function showBySlug($slug)
    {
        try {
            $startup = Startup::where('slug', $slug)
                ->with('image')
                ->firstOrFail();
                
            return new StartupResource($startup);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Startup non trouvée'
            ], 404);
        }
    }

    public function getSimilar(Request $request)
    {
        $secteur = $request->query('secteur');
        $excludeId = $request->query('exclude_id');

        if (!$secteur || !$excludeId) {
            return response()->json([
                'message' => 'Les paramètres secteur et exclude_id sont requis'
            ], 400);
        }

        try {
            $similarStartups = Startup::with('image')
                ->where('secteur', $secteur)
                ->where('id', '!=', $excludeId)
                ->take(3)
                ->get();

            return StartupResource::collection($similarStartups);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des startups similaires'
            ], 500);
        }
    }
}