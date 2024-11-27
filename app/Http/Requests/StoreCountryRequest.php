<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser toutes les requêtes
    }

    public function rules()
    {
        return [
            'short_name' => 'nullable|string|max:10',
            'country_name' => 'nullable|string',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slug' => 'nullable|string',
            'location_map_url' => 'nullable|string',
            'phonecode' => 'nullable|string',
            'continent' => 'nullable|string',
            'status' => 'nullable|integer',
        ];
    }
} 