<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuccessStoryRequest;
use App\Models\SuccessStories;
use App\Services\SuccessStoryService;

class SuccessStoryController extends Controller
{
    protected $successStoryService;

    public function __construct(SuccessStoryService $successStoryService)
    {
        $this->successStoryService = $successStoryService;
    }

    public function index()
    {
        $success_stories = $this->successStoryService->getAll();
        return view('admin.success_stories.index', compact('success_stories'));
    }

    public function create()
    {
        return view('admin.success_stories.create');
    }

    public function store(StoreSuccessStoryRequest $request)
    {
        $this->successStoryService->create($request->validated());
        return redirect()->route('admin.success_stories.index')->with('success', 'Succès créé avec succès.');
    }

    public function edit($id)
    {
        $success_story = SuccessStories::findOrFail($id);
        return view('admin.success_stories.edit', compact('success_story'));
    }

    public function update(StoreSuccessStoryRequest $request, $id)
    {
        $success_story = SuccessStories::findOrFail($id);
        $this->successStoryService->update($success_story, $request->validated());
        return redirect()->route('admin.success_stories.index')->with('success', 'Succès mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $success_story = SuccessStories::findOrFail($id);
        $this->successStoryService->delete($success_story);
        return redirect()->route('admin.success_stories.index')->with('success', 'Succès supprimé avec succès.');
    }
}
