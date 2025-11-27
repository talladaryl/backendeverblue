<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string|in:planning,confirmed,ongoing,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut doit être: planning, confirmed, ongoing, completed ou cancelled',
        ];
    }
}
