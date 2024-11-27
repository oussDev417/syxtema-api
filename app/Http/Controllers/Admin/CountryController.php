<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Services\CountryService;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getAll();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $this->countryService->create($request->validated());
        return redirect()->route('admin.countries.index')->with('success', 'Pays créé avec succès.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(StoreCountryRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $this->countryService->update($country, $request->validated());
        return redirect()->route('admin.countries.index')->with('success', 'Pays mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $this->countryService->delete($country);
        return redirect()->route('admin.countries.index')->with('success', 'Pays supprimé avec succès.');
    }
} 