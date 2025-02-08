<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Services\PortfolioService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    public function __construct(private PortfolioService $portfolioService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $portfolios = $this->portfolioService->getAll();
        return PortfolioResource::collection($portfolios);
    }

    public function show($id)
    {
        $portfolio = $this->portfolioService->find($id);
        return new PortfolioResource($portfolio);
    }
    public function showBySlug(string $slug)
    {
        $portfolio = $this->portfolioService->findBySlug($slug);
        return new PortfolioResource($portfolio);
    }
}
