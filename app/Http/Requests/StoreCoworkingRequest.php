<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoworkingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'map_url' => 'nullable|url|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'advantage' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'status' => ['required', Rule::in(['disponible', 'occupé'])],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        // Ajouter la validation du slug uniquement lors de la création
        if ($this->isMethod('post')) {
            $rules['slug'] = 'required|string|unique:coworkings,slug|max:255';
        } elseif ($this->isMethod('put')) {
            $rules['slug'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('coworkings', 'slug')->ignore($this->coworking)
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'title.required' => 'Le titre est requis',
            'location.required' => 'L\'adresse est requise',
            'price.required' => 'Le prix est requis',
            'price.numeric' => 'Le prix doit être un nombre',
            'capacity.required' => 'La capacité est requise',
            'capacity.integer' => 'La capacité doit être un nombre entier',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut doit être soit disponible soit occupé',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format jpeg, png ou jpg',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo'
        ];
    }
} 