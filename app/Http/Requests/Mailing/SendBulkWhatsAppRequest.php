<?php

namespace App\Http\Requests\Mailing;

use Illuminate\Foundation\Http\FormRequest;

class SendBulkWhatsAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'message' => 'required|string|max:4096',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|string|regex:/^\+?[1-9]\d{1,14}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'L\'événement est requis',
            'event_id.exists' => 'L\'événement n\'existe pas',
            'message.required' => 'Le message est requis',
            'message.max' => 'Le message ne peut pas dépasser 4096 caractères',
            'recipients.required' => 'Les destinataires sont requis',
            'recipients.min' => 'Au moins un destinataire est requis',
            'recipients.*.regex' => 'Tous les numéros doivent être au format E.164 (+33612345678)',
        ];
    }
}
