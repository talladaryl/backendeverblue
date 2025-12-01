<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:organizations',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l\'organisation est requis',
            'name.unique' => 'Cette organisation existe déjà',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères',
        ];
    }
}
