<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Services\ServiceCategoryService;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    protected $serviceCategoryService;

    public function __construct(ServiceCategoryService $serviceCategoryService)
    {
        $this->serviceCategoryService = $serviceCategoryService;
    }

    public function index()
    {
        $serviceCategories = $this->serviceCategoryService->getAll();
        return view('admin.service_categories.index', compact('serviceCategories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(StoreServiceCategoryRequest $request)
    {
        $this->serviceCategoryService->create($request->validated());
        return redirect()->route('admin.service_categories.index')->with('success', 'Catégorie de service créée avec succès.');
    }

    public function edit($id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        return view('admin.service_categories.edit', compact('serviceCategory'));
    }

    public function update(StoreServiceCategoryRequest $request, $id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $this->serviceCategoryService->update($serviceCategory, $request->validated());
        return redirect()->route('admin.service_categories.index')->with('success', 'Catégorie de service mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $serviceCategory = ServiceCategory::findOrFail($id);
        $this->serviceCategoryService->delete($serviceCategory);
        return redirect()->route('admin.service_categories.index')->with('success', 'Catégorie de service supprimée avec succès.');
    }
} 