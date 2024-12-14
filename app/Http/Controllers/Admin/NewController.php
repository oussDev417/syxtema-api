<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewRequest;
use App\Services\NewService;
// use App\Models\EventCategory;
use App\Models\News;
use App\Models\Country;
use Illuminate\Http\Request;

class NewController extends Controller
{
    protected $newService;

    public function __construct(NewService $newService)
    {
        $this->newService = $newService;
    }

    public function index()
    {
        $news = $this->newService->getAll();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        // $categories = EventCategory::all();
        $countries = Country::all();
        return view('admin.news.create', compact('countries'));
    }

    public function store(StoreNewRequest $request)
    {
        $this->newService->create($request->validated());
        return redirect()->route('admin.news.index')->with('success', 'New créé avec succès.');
    }

    public function edit($id)
    {
        $new = News::findOrFail($id);
        // $categories = EventCategory::all();
        $countries = Country::all();
        return view('admin.news.edit', compact('new', 'countries'));
    }

    public function update(StoreNewRequest $request, $id)
    {
        $new = News::findOrFail($id);
        $this->newService->update($new, $request->validated());
        return redirect()->route('admin.news.index')->with('success', 'New mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $new = News::findOrFail($id);
        $this->newService->delete($new);
        return redirect()->route('admin.news.index')->with('success', 'Nerw supprimé avec succès.');
    }
}
