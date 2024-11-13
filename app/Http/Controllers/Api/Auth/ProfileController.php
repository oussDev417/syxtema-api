<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user(); // Récupère l'utilisateur authentifié
        return response()->json($user, 200);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|nullable|string',
        ]);

        $user->update($validatedData);

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'user' => $user
        ], 200);
    }
}
