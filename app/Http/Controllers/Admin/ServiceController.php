<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;
use App\Models\ServiceCategory;
use App\Models\Departement;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAll();
        // dd($services->toArray());
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $serviceCategories = ServiceCategory::all();
        $departements = Departement::all();
        return view('admin.services.create', compact('serviceCategories', 'departements'));
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceService->create($request->validated());
        return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $serviceCategories = ServiceCategory::all();
        $departements = Departement::all();
        return view('admin.services.edit', compact('service', 'serviceCategories', 'departements'));
    }

    public function update(StoreServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $this->serviceService->update($service, $request->validated());
        return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceService->delete($service);
        return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès.');
    }
} 