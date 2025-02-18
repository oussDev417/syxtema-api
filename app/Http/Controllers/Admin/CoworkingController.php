<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoworkingRequest;
use App\Http\Resources\CoworkingResource;
use App\Models\Coworking;
use App\Services\CoworkingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CoworkingController extends Controller
{
    protected $coworkingService;

    public function __construct(CoworkingService $coworkingService)
    {
        $this->coworkingService = $coworkingService;
    }

    public function index()
    {
        $coworkings = $this->coworkingService->getAll();
        return view('admin.coworkings.index', compact('coworkings'));
    }

    public function create()
    {
        return view('admin.coworkings.create');
    }

    public function store(StoreCoworkingRequest $request)
    {
        $coworking = $this->coworkingService->create($request->validated());
        return new CoworkingResource($coworking);
    }

    public function show(Coworking $coworking)
    {
        return new CoworkingResource($coworking);
    }

    public function edit(Coworking $coworking)
    {
        return view('admin.coworkings.edit', compact('coworking'));
    }

    public function update(StoreCoworkingRequest $request, Coworking $coworking)
    {
        $coworking = $this->coworkingService->update($coworking, $request->validated());
        return new CoworkingResource($coworking);
    }

    public function destroy(Coworking $coworking)
    {
        $this->coworkingService->delete($coworking);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function getReservations(Coworking $coworking)
    {
        $reservations = $coworking->reservations()
            ->with(['user', 'event'])
            ->latest()
            ->paginate(10);
            
        return response()->json($reservations);
    }

    public function toggleStatus(Coworking $coworking)
    {
        $newStatus = $coworking->status === 'disponible' ? 'occupé' : 'disponible';
        $coworking->update(['status' => $newStatus]);
        
        return new CoworkingResource($coworking);
    }
} 