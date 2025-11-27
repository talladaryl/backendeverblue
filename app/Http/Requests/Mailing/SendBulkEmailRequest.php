<?php

namespace App\Http\Requests\Mailing;

use Illuminate\Foundation\Http\FormRequest;

class SendBulkEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'L\'événement est requis',
            'event_id.exists' => 'L\'événement n\'existe pas',
            'subject.required' => 'Le sujet est requis',
            'body.required' => 'Le corps du message est requis',
            'recipients.required' => 'Les destinataires sont requis',
            'recipients.min' => 'Au moins un destinataire est requis',
            'recipients.*.email' => 'Tous les destinataires doivent être des adresses email valides',
        ];
    }
}
