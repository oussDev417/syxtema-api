<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Services\TestimonialService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    public function __construct(private TestimonialService $testimonialService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $testimonials = $this->testimonialService->getAll();
        return TestimonialResource::collection($testimonials);
    }

    public function show($id)
    {
        $testimonial = $this->testimonialService->find($id);
        return new TestimonialResource($testimonial);
    }
} 