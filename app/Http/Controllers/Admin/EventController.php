<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Services\EventService;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Country;
use App\Models\Departement;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getAll();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = EventCategory::all();
        $countries = Country::all();
        $departements = Departement::all();
        return view('admin.events.create', compact('categories', 'countries', 'departements'));
    }

    public function store(StoreEventRequest $request)
    {
        $this->eventService->create($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Événement créé avec succès.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $categories = EventCategory::all();
        $countries = Country::all();
        $departements = Departement::all();
        return view('admin.events.edit', compact('event', 'categories', 'countries', 'departements'));
    }

    public function update(StoreEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $this->eventService->update($event, $request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $this->eventService->delete($event);
        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès.');
    }
}
