<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Models\Temoignage;
use App\Services\TestimonialService;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index()
    {
        $testimonials = $this->testimonialService->getAll();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $testimonials = Temoignage::all();
        return view('admin.testimonials.create', compact('testimonials'));
    }

    public function store(StoreTestimonialRequest $request)
    {
        $this->testimonialService->create($request->validated());
        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage créé avec succès.');
    }

    public function edit($id)
    {
        $testimonial = Temoignage::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(StoreTestimonialRequest $request, $id)
    {
        $testimonial = Temoignage::findOrFail($id);
        $this->testimonialService->update($testimonial, $request->validated());
        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $testimonial = Temoignage::findOrFail($id);
        $this->testimonialService->delete($testimonial);
        return redirect()->route('admin.testimonials.index')->with('success', 'Témoignage supprimé avec succès.');
    }
}
