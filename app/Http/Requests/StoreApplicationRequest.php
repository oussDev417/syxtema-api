<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'phone_number' => 'required|string|max:20',
            'cover_letter' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est requis.',
            'email.email' => 'L\'email doit être une adresse valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'phone_number.required' => 'Le numéro de téléphone est requis.',
            'phone_number.max' => 'Le numéro de téléphone ne doit pas dépasser 20 caractères.',
            'cover_letter.required' => 'La lettre de motivation est requise.',
            'cover_letter.mimes' => 'La lettre de motivation doit être au format PDF, DOC ou DOCX.',
            'cover_letter.max' => 'La lettre de motivation ne doit pas dépasser 5 Mo.',
            'cv.required' => 'Le CV est requis.',
            'cv.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 5 Mo.',
        ];
    }
}
