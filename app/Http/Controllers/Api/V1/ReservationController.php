<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Services\ReservationService;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
        $this->middleware('auth:sanctum');
    }

    public function index(): AnonymousResourceCollection
    {
        $reservations = $this->reservationService->getUserReservations(auth()->id());
        return ReservationResource::collection($reservations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coworking_id' => 'required|exists:coworkings,id',
            'event_id' => 'nullable|exists:events,id',
            'datestart' => 'required|date|after:now',
            'dateend' => 'required|date|after:datestart',
            'message' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();

        try {
            $reservation = $this->reservationService->create($validated);
            return new ReservationResource($reservation);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return new ReservationResource($reservation);
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);
        
        try {
            $reservation = $this->reservationService->cancel($reservation);
            return new ReservationResource($reservation);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $validated = $request->validate([
            'datestart' => 'sometimes|required|date|after:now',
            'dateend' => 'sometimes|required|date|after:datestart',
            'message' => 'nullable|string'
        ]);

        try {
            // Vérifier les conflits de dates si les dates sont modifiées
            if (isset($validated['datestart']) || isset($validated['dateend'])) {
                $hasConflicts = $this->reservationService->checkConflicts(
                    $reservation->coworking_id,
                    $validated['datestart'] ?? $reservation->datestart,
                    $validated['dateend'] ?? $reservation->dateend,
                    $reservation->id
                );

                if ($hasConflicts) {
                    throw new \Exception('Ces dates ne sont pas disponibles.');
                }
            }

            $reservation->update($validated);
            return new ReservationResource($reservation);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
} 