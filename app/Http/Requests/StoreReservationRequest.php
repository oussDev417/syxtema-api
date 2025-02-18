<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'coworking_id' => 'required|exists:coworkings,id',
            'event_id' => 'nullable|exists:events,id',
            'message' => 'nullable|string|max:500',
            'datestart' => 'required|date|after_or_equal:today',
            'dateend' => 'required|date|after:datestart',
            'status' => ['sometimes', Rule::in(['en_attente', 'approuvé', 'rejeté'])]
        ];
    }

    public function messages(): array
    {
        return [
            'coworking_id.required' => 'L\'espace de coworking est requis',
            'coworking_id.exists' => 'L\'espace de coworking sélectionné n\'existe pas',
            'event_id.exists' => 'L\'événement sélectionné n\'existe pas',
            'message.max' => 'Le message ne doit pas dépasser 500 caractères',
            'datestart.required' => 'La date de début est requise',
            'datestart.date' => 'La date de début doit être une date valide',
            'datestart.after_or_equal' => 'La date de début doit être aujourd\'hui ou une date ultérieure',
            'dateend.required' => 'La date de fin est requise',
            'dateend.date' => 'La date de fin doit être une date valide',
            'dateend.after' => 'La date de fin doit être postérieure à la date de début',
            'status.in' => 'Le statut doit être en attente, approuvé ou rejeté'
        ];
    }
} 