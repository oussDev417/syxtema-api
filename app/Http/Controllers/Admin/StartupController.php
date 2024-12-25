<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStartupRequest;
use App\Models\Startup;
use App\Services\StartupService;

class StartupController extends Controller
{
    protected $startupService;

    public function __construct(StartupService $startupService)
    {
        $this->startupService = $startupService;
    }

    public function index()
    {
        $startups = $this->startupService->getAll();
        return view('admin.startups.index', compact('startups'));
    }

    public function create()
    {
        return view('admin.startups.create');
    }

    public function store(StoreStartupRequest $request)
    {
        $this->startupService->create($request->validated());
        return redirect()->route('admin.startups.index')->with('success', 'Startup créée avec succès.');
    }

    public function edit($id)
    {
        $startup = Startup::findOrFail($id);
        return view('admin.startups.edit', compact('startup'));
    }

    public function update(StoreStartupRequest $request, $id)
    {
        $startup = Startup::findOrFail($id);
        $this->startupService->update($startup, $request->validated());
        return redirect()->route('admin.startups.index')->with('success', 'Startup mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $startup = Startup::findOrFail($id);
        $this->startupService->delete($startup);
        return redirect()->route('admin.startups.index')->with('success', 'Startup supprimée avec succès.');
    }
}
