<?php

namespace App\Http\Requests\AIImage;

use Illuminate\Foundation\Http\FormRequest;

class GenerateImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => 'required|string',
            'model' => 'nullable|string',
            'size' => 'nullable|string',
        ];
    }
}
