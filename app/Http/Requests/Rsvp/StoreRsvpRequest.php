<?php

namespace App\Http\Requests\Rsvp;

use Illuminate\Foundation\Http\FormRequest;

class StoreRsvpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_id' => 'required|exists:guests,id',
            'status' => 'required|string|in:accepted,declined,pending',
            'response_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }
}
