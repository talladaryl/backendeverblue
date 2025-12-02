<?php

namespace App\Http\Requests\Mailing;

use Illuminate\Foundation\Http\FormRequest;

class BulkSendRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'L\'événement est requis',
            'event_id.exists' => 'L\'événement n\'existe pas',
            'channel.required' => 'Le canal est requis',
            'channel.in' => 'Le canal doit être: email, sms, whatsapp ou mms',
        ];
    }
}
