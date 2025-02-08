<?php

namespace App\Services;

use App\Models\Portfolio;

class PortfolioService
{
    public function getAll()
    {
        return Portfolio::with(['departement', 'image'])->latest()->get();
    }

    public function create(array $data)
    {
        $portfolio = Portfolio::create($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/portfolios', 'public');
            $portfolio->image()->create(['path' => $imagePath]);
        }

        return $portfolio;
    }

    public function update(Portfolio $portfolio, array $data)
    {
        $portfolio->update($data);
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/portfolios', 'public');
            if ($portfolio->image) {
                // delete the image
                $portfolio->image->delete();
            }
            $portfolio->image()->create(['path' => $imagePath]);
        }
        return $portfolio;
    }

    public function delete(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            $portfolio->image->delete();
        }
        return $portfolio->delete();
    }

    public function find($id)
    {
        return Portfolio::with(['departement', 'image'])->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Portfolio::with(['departement', 'image'])->where('slug', $slug)->firstOrFail();
    }
}
