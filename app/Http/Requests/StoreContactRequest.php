<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être une adresse valide',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères',
            'phone.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères',
            'message.required' => 'Le message est requis',
            'message.min' => 'Le message doit contenir au moins 10 caractères'
        ];
    }
} 