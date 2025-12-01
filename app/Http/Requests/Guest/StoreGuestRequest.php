<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'full_name' => 'required|string|max:200', // correspond à la colonne full_name
            'email' => 'nullable|string|email|max:180', // nullable selon la table
            'phone' => 'nullable|string|max:50',
            'plus_one_allowed' => 'nullable|boolean',
            'metadata' => 'nullable|array',
        ];
    }

}