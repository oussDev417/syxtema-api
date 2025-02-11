<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Country;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['thumbnail', 'category', 'country', 'departement'])
            ->where('status', 1);

        // Filtrage par catégorie
        if ($request->has('category_id')) {
            $query->where('event_category_id', $request->category_id);
        }

        // Filtrage par pays
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Filtrage par département
        if ($request->has('departement_id')) {
            $query->where('departement_id', $request->departement_id);
        }

        // Filtrage par type d'événement
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Recherche par titre
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filtrage par date
        if ($request->has('date')) {
            $date = $request->date;
            $query->where('start_date', '>=', $date)
                  ->orWhere('end_date', '>=', $date);
        }

        // Tri
        $sort = $request->input('sort', 'start_date');
        $direction = $request->input('direction', 'asc');
        $query->orderBy($sort, $direction);

        $events = $query->paginate(9);
        return EventResource::collection($events);
    }

    public function showBySlug($slug)
    {
        try {
            $event = Event::where('slug', $slug)
                ->where('status', 1)
                ->with(['thumbnail', 'category', 'country', 'departement'])
                ->firstOrFail();
                
            return new EventResource($event);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Événement non trouvé'
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
            $events = Event::where('status', 1)
                ->where('event_category_id', $categoryId)
                ->where('id', '!=', $excludeId)
                ->with(['thumbnail', 'category', 'country', 'departement'])
                ->take(3)
                ->get();

            return EventResource::collection($events);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des événements similaires'
            ], 500);
        }
    }

    public function getCategories()
    {
        try {
            $categories = EventCategory::select('id', 'name')
                ->where('status', 'actif')
                ->orderBy('name')
                ->get();

            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des catégories'
            ], 500);
        }
    }

    public function getCountries()
    {
        try {
            $countries = Country::select('id', 'country_name')
                ->orderBy('country_name')
                ->get();

            return response()->json($countries);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des pays'
            ], 500);
        }
    }
}