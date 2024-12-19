<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes
    }

    public function rules()
    {
        return [
            'service_category_id' => 'required|exists:service_categories,id',
            'departement_id' => 'required|exists:departements,id',
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'secteur' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
} 