<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartementRequest;
use App\Services\DepartementService;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    protected $departementService;

    public function __construct(DepartementService $departementService)
    {
        $this->departementService = $departementService;
    }

    public function index()
    {
        $departements = $this->departementService->getAll();
        return view('admin.departements.index', compact('departements'));
    }

    public function create()
    {
        return view('admin.departements.create');
    }

    public function store(StoreDepartementRequest $request)
    {
        $this->departementService->create($request->validated());
        return redirect()->route('admin.departements.index')->with('success', 'Département créé avec succès.');
    }

    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('admin.departements.edit', compact('departement'));
    }

    public function update(StoreDepartementRequest $request, $id)
    {
        $departement = Departement::findOrFail($id);
        $this->departementService->update($departement, $request->validated());
        return redirect()->route('admin.departements.index')->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $this->departementService->delete($departement);
        return redirect()->route('admin.departements.index')->with('success', 'Département supprimé avec succès.');
    }
} 