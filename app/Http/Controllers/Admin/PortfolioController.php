<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use App\Models\Departement;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    public function index()
    {
        $portfolios = $this->portfolioService->getAll();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('admin.portfolios.create', compact('departements'));
    }

    public function store(StorePortfolioRequest $request)
    {
        $this->portfolioService->create($request->validated());
        return redirect()->route('admin.portfolios.index')->with('success', 'Réalisation créée avec succès.');
    }

    public function edit($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $departements = Departement::all();
        return view('admin.portfolios.edit', compact('portfolio', 'departements'));
    }

    public function update(StorePortfolioRequest $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $this->portfolioService->update($portfolio, $request->validated());
        return redirect()->route('admin.portfolios.index')->with('success', 'Réalisation mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $this->portfolioService->delete($portfolio);
        return redirect()->route('admin.portfolios.index')->with('success', 'Réalisation supprimé avec succès.');
    }
} 