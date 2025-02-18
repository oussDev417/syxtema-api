<?php

namespace App\Services;

use App\Models\Coworking;
use Illuminate\Support\Str;

class CoworkingService
{
    public function getAll()
    {
        return Coworking::with(['image', 'creator'])->latest()->get();
    }

    public function create(array $data)
    {
        // Générer le slug si non fourni
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $coworking = Coworking::create($data);

        // Gérer l'upload de l'image si présente
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('images/coworkings', 'public');
            $coworking->image()->create(['path' => $imagePath]);
        }

        return $coworking;
    }

    public function update(Coworking $coworking, array $data)
    {
        // Mettre à jour le slug si le titre a changé
        if (isset($data['title']) && $data['title'] !== $coworking->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        $coworking->update($data);

        // Gérer l'upload de la nouvelle image si présente
        if (isset($data['image'])) {
            // Supprimer l'ancienne image si elle existe
            if ($coworking->image) {
                $coworking->image->delete();
            }
            
            $imagePath = $data['image']->store('images/coworkings', 'public');
            $coworking->image()->create(['path' => $imagePath]);
        }

        return $coworking;
    }

    public function delete(Coworking $coworking)
    {
        // Supprimer l'image associée si elle existe
        if ($coworking->image) {
            $coworking->image->delete();
        }
        
        return $coworking->delete();
    }

    public function checkAvailability(Coworking $coworking, $startDate, $endDate)
    {
        return $coworking->reservations()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('datestart', '<=', $startDate)
                      ->where('dateend', '>=', $startDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('datestart', '<=', $endDate)
                      ->where('dateend', '>=', $endDate);
                });
            })
            ->where('status', 'approved')
            ->doesntExist();
    }
} 