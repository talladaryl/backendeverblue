<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class ImportGuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guests' => 'required|array',
            'guests.*.name' => 'required|string|max:255',
            'guests.*.email' => 'required|string|email|max:255',
            'guests.*.phone' => 'nullable|string',
        ];
    }
}
