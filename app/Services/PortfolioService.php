<?php

namespace App\Services;

use App\Models\Portfolio;

class PortfolioService
{
    public function getAll()
    {
        return Portfolio::with(['departement'])->get();
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public'); 
            $data['image'] = $imagePath;
        }

        return Portfolio::create($data);
    }

    public function update(Portfolio $portfolio, array $data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/services', 'public');
            $data['image'] = $imagePath;
        }

        $portfolio->update($data);
        return $portfolio;
    }

    public function delete(Portfolio $portfolio)
    {
        return $portfolio->delete();
    }
} 