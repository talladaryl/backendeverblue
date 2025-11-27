<?php

namespace App\Http\Requests\AIImage;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneratedImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prompt' => 'required|string|min:5|max:4000',
            'negative_prompt' => 'nullable|string|max:500',
            'provider' => 'nullable|string|in:openai,gamma',
            'model' => 'nullable|string|in:dall-e-3,dall-e-2',
            'style' => 'nullable|string|in:realistic,artistic,cartoon,abstract,photorealistic,oil_painting,watercolor,vivid,natural',
            'size' => 'nullable|string|in:512x512,768x768,1024x1024,1024x576,576x1024,1792x1024,1024x1792',
            'quality' => 'nullable|string|in:low,medium,high,ultra,standard,hd',
            'event_id' => 'nullable|exists:events,id',
            'num_images' => 'nullable|integer|min:1|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'prompt.required' => 'Le prompt est requis',
            'prompt.min' => 'Le prompt doit contenir au moins 5 caractères',
            'prompt.max' => 'Le prompt ne peut pas dépasser 4000 caractères',
            'provider.in' => 'Le fournisseur doit être: openai ou gamma',
            'model.in' => 'Le modèle sélectionné est invalide',
            'style.in' => 'Le style sélectionné est invalide',
            'size.in' => 'La taille sélectionnée est invalide',
            'quality.in' => 'La qualité sélectionnée est invalide',
            'event_id.exists' => 'L\'événement sélectionné n\'existe pas',
            'num_images.min' => 'Vous devez générer au moins 1 image',
            'num_images.max' => 'Vous ne pouvez générer que 4 images maximum',
        ];
    }
}
