<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Models\Partner;
use App\Services\PartnerService;

class PartnerController extends Controller
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
    }

    public function index()
    {
        $partners = $this->partnerService->getAll();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(StorePartnerRequest $request)
    {
        $this->partnerService->create($request->validated());
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire créé avec succès.');
    }

    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(StorePartnerRequest $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $this->partnerService->update($partner, $request->validated());
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $this->partnerService->delete($partner);
        return redirect()->route('admin.partners.index')->with('success', 'Partenaire supprimé avec succès.');
    }
}
