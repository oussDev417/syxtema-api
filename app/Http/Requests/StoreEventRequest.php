<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser toutes les requêtes pour cet exemple
    }

    public function rules(): array
    {
        return [            
            'title'              => 'required|string|max:255',
            'type'               => 'required|integer',
            'slug'               => 'required|string|unique:events,slug',
            'thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'location'           => 'required|string|max:255',
            'price'              => 'required|numeric',
            'number_of_ticket'   => 'required|integer',
            'description'        => 'nullable|string',
            'created_by'         => 'nullable|exists:admins,id',
            'status'             => 'required|integer',
            'event_category_id'  => 'required|integer|exists:event_categories,id',
            'country_id'         => 'required|integer|exists:countries,id',
            'departement_id'     => 'required|integer|exists:departements,id',
        ];
    }
}
