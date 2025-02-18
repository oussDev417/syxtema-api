<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'coworking'])
            ->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'coworking']);
        
        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:approuvé,rejeté'
        ]);

        try {
            DB::beginTransaction();

            // Mettre à jour le statut
            $oldStatus = $reservation->status;
            $reservation->status = $request->status;
            $reservation->save();

            // Enregistrer l'historique du statut
            $reservation->statusHistory()->create([
                'status' => $request->status,
                'changed_by' => auth()->id()
            ]);

            // Envoyer la notification
            $reservation->user->notify(new ReservationStatusChanged($reservation));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du statut'
            ], 500);
        }
    }

    public function statistics()
    {
        $stats = [
            'total' => Reservation::count(),
            'approved' => Reservation::where('status', 'approuvé')->count(),
            'rejected' => Reservation::where('status', 'rejeté')->count(),
            'pending' => Reservation::where('status', 'en_attente')->count(),
            'monthly' => Reservation::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total')
            )
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get(),
            'recent' => Reservation::with(['user', 'coworking'])
                ->latest()
                ->limit(5)
                ->get()
        ];

        return view('admin.reservations.statistics', compact('stats'));
    }
} 