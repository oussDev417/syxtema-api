<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Departement;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['image', 'category', 'departement'])
            ->where('status', 'actif');

        // Filtrage par catégorie
        if ($request->has('category_id')) {
            $query->where('service_category_id', $request->category_id);
        }

        // Filtrage par département
        if ($request->has('departement_id')) {
            $query->where('departement_id', $request->departement_id);
        }

        // Filtrage par secteur
        if ($request->has('secteur')) {
            $query->where('secteur', $request->secteur);
        }

        // Recherche par nom
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Tri
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        $services = $query->paginate(9);
        return ServiceResource::collection($services);
    }

    public function showBySlug($slug)
    {
        try {
            $service = Service::where('slug', $slug)
                ->where('status', 'actif')
                ->with(['image', 'category', 'departement'])
                ->firstOrFail();
                
            return new ServiceResource($service);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Service non trouvé'
            ], 404);
        }
    }

    public function getRelated(Request $request)
    {
        $excludeId = $request->query('exclude_id');
        $categoryId = $request->query('category_id');

        if (!$excludeId || !$categoryId) {
            return response()->json([
                'message' => 'Les paramètres exclude_id et category_id sont requis'
            ], 400);
        }

        try {
            $services = Service::where('status', 'actif')
                ->where('service_category_id', $categoryId)
                ->where('id', '!=', $excludeId)
                ->with(['image', 'category', 'departement'])
                ->take(3)
                ->get();

            return ServiceResource::collection($services);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des services similaires'
            ], 500);
        }
    }

    public function getCategories()
    {
        try {
            $categories = ServiceCategory::select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des catégories'
            ], 500);
        }
    }

    public function getDepartements()
    {
        try {
            $departements = Departement::select('id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json($departements);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des départements'
            ], 500);
        }
    }
}