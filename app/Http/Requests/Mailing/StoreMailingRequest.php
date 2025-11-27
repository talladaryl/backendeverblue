<?php

namespace App\Http\Requests\Mailing;

use Illuminate\Foundation\Http\FormRequest;

class StoreMailingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'channel' => 'required|string|in:email,sms,whatsapp,mms',
            'type' => 'nullable|string|in:single,bulk',
            'recipient_type' => 'nullable|string|in:guest,custom',
            'recipients' => 'nullable|array',
            'recipients.*' => 'string',
            'media_urls' => 'nullable|array',
            'media_urls.*' => 'url',
            'scheduled_at' => 'nullable|date|after:now',
            'status' => 'nullable|string|in:draft,scheduled,sent,failed',
        ];
    }

    public function messages(): array
    {
        return [
            'channel.required' => 'Le canal de communication est requis',
            'channel.in' => 'Le canal doit être: email, sms, whatsapp ou mms',
            'body.required' => 'Le contenu du message est requis',
            'event_id.required' => 'L\'événement est requis',
            'recipients.array' => 'Les destinataires doivent être un tableau',
            'scheduled_at.after' => 'La date d\'envoi doit être dans le futur',
        ];
    }
}
