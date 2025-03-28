<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Autoriser toutes les requêtes pour cet exemple
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'slug' => 'required|string|unique:news,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'created_by' => 'nullable|exists:admins,id',
            'status' => 'required|integer',
        ];
    }
}
