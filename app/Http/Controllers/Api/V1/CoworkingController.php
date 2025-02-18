<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoworkingResource;
use App\Services\CoworkingService;
use App\Models\Coworking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoworkingController extends Controller
{
    protected $coworkingService;

    public function __construct(CoworkingService $coworkingService)
    {
        $this->coworkingService = $coworkingService;
    }

    public function index(): AnonymousResourceCollection
    {
        $coworkings = $this->coworkingService->getAll();
        return CoworkingResource::collection($coworkings);
    }

    public function show(string $slug)
    {
        $coworking = Coworking::where('slug', $slug)
            ->with(['image', 'creator'])
            ->firstOrFail();
        return new CoworkingResource($coworking);
    }

    public function checkAvailability(Request $request, Coworking $coworking)
    {
        $request->validate([
            'datestart' => 'required|date|after:now',
            'dateend' => 'required|date|after:datestart'
        ]);

        $isAvailable = $this->coworkingService->checkAvailability(
            $coworking,
            $request->datestart,
            $request->dateend
        );

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable 
                ? 'L\'espace est disponible pour les dates sélectionnées'
                : 'L\'espace n\'est pas disponible pour les dates sélectionnées'
        ]);
    }

    public function getByCategory(string $category)
    {
        $coworkings = Coworking::whereHas('categories', function($query) use ($category) {
            $query->where('slug', $category);
        })->with(['image', 'creator'])->get();

        return CoworkingResource::collection($coworkings);
    }

    public function search(Request $request)
    {
        $query = Coworking::query()->with(['image', 'creator']);

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('capacity')) {
            $query->where('capacity', '>=', $request->capacity);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $coworkings = $query->get();
        return CoworkingResource::collection($coworkings);
    }
} 