<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete(); // Supprime tous les tokens de l'utilisateur

        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Vérifiez si l'utilisateur existe déjà
        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            // Créez un nouvel utilisateur
            $user = User::create([
                'first_name' => $googleUser->user['given_name'],
                'last_name' => $googleUser->user['family_name'],
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'is_active' => true,
                'role' => 'user', // ou autre rôle par défaut
            ]);
        }

        // Authentifiez l'utilisateur
        Auth::login($user);

        // Générez un token si vous utilisez Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
