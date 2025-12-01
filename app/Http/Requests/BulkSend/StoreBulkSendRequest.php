<?php

namespace App\Http\Requests\BulkSend;

use Illuminate\Foundation\Http\FormRequest;

class StoreBulkSendRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'channel' => 'required|string|in:email,sms,whatsapp,mms',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'L\'événement est requis',
            'channel.required' => 'Le canal est requis',
            'channel.in' => 'Le canal doit être: email, sms, whatsapp ou mms',
            'body.required' => 'Le corps du message est requis',
            'recipients.required' => 'Les destinataires sont requis',
            'recipients.min' => 'Au moins un destinataire est requis',
        ];
    }
}
