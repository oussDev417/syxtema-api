<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventCategoryRequest;
use App\Services\EventCategoryService;
use Illuminate\Http\Request;
use App\Models\EventCategory;

class EventCategoryController extends Controller
{
    protected $eventCategoryService;

    public function __construct(EventCategoryService $eventCategoryService)
    {
        $this->eventCategoryService = $eventCategoryService;
    }

    public function index()
    {
        $categories = $this->eventCategoryService->getAll();
        return view('admin.event_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.event_categories.create');
    }

    public function store(StoreEventCategoryRequest $request)
    {
        $this->eventCategoryService->create($request->validated());
        return redirect()->route('admin.event_categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    public function edit($id)
    {
        $category = EventCategory::findOrFail($id);
        return view('admin.event_categories.edit', compact('category'));
    }

    public function update(StoreEventCategoryRequest $request, $id)
    {
        $category = EventCategory::findOrFail($id);
        $this->eventCategoryService->update($category, $request->validated());
        return redirect()->route('admin.event_categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $category = EventCategory::findOrFail($id);
        $this->eventCategoryService->delete($category);
        return redirect()->route('admin.event_categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
