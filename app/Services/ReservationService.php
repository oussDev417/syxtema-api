<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Coworking;
use App\Notifications\ReservationStatusChanged;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    protected $coworkingService;

    public function __construct(CoworkingService $coworkingService)
    {
        $this->coworkingService = $coworkingService;
    }

    public function getAll()
    {
        return Reservation::with(['user', 'coworking', 'event'])->latest()->get();
    }

    public function getUserReservations($userId)
    {
        return Reservation::with(['coworking', 'event'])
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        // Vérifier la disponibilité
        $coworking = Coworking::findOrFail($data['coworking_id']);
        $isAvailable = $this->coworkingService->checkAvailability(
            $coworking,
            $data['datestart'],
            $data['dateend']
        );

        if (!$isAvailable) {
            throw new \Exception('Cet espace n\'est pas disponible pour les dates sélectionnées.');
        }

        return DB::transaction(function () use ($data) {
            $reservation = Reservation::create($data);
            
            // Notifier l'administrateur de la nouvelle réservation
            // TODO: Implémenter la notification admin
            
            return $reservation;
        });
    }

    public function updateStatus(Reservation $reservation, string $status)
    {
        return DB::transaction(function () use ($reservation, $status) {
            $oldStatus = $reservation->status;
            $reservation->update(['status' => $status]);

            // Notifier l'utilisateur du changement de statut
            if ($oldStatus !== $status) {
                $reservation->user->notify(new ReservationStatusChanged($reservation));
            }

            return $reservation;
        });
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->status === 'approved') {
            // Logique supplémentaire pour la gestion d'annulation
            // Par exemple, notification à l'admin, mise à jour des disponibilités, etc.
        }

        return $this->updateStatus($reservation, 'rejected');
    }

    public function checkConflicts($coworkingId, $startDate, $endDate, $excludeReservationId = null)
    {
        $query = Reservation::where('coworking_id', $coworkingId)
            ->where('status', 'approved')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('datestart', [$startDate, $endDate])
                    ->orWhereBetween('dateend', [$startDate, $endDate]);
            });

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->exists();
    }
} 