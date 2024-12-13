<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Resources\NewsletterResource;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emails = Newsletter::all();
        return NewsletterResource::collection($emails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsletterRequest $request)
    {
        $newsletter = Newsletter::create($request->validated());
        return new NewsletterResource($newsletter);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        return new NewsletterResource($newsletter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNewsletterRequest $request, string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->update($request->validated());
        return new NewsletterResource($newsletter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();
        return response()->noContent();
    }
}
