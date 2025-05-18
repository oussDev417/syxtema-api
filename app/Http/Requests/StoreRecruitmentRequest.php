<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruitmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajustez selon vos besoins d'autorisation
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file_pdf' => 'sometimes|file|mimes:pdf|max:10240', // Max 10MB
            'deadline' => 'required|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Le pays est requis.',
            'country_id.exists' => 'Le pays sélectionné n\'existe pas.',
            'title.required' => 'Le titre est requis.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est requise.',
            'file_pdf.mimes' => 'Le fichier doit être un PDF.',
            'file_pdf.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            'deadline.required' => 'La date limite est requise.',
            'deadline.date' => 'La date limite doit être une date valide.',
            'deadline.after' => 'La date limite doit être postérieure à aujourd\'hui.',
        ];
    }
}
