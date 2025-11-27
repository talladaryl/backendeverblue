<?php

namespace App\Http\Requests\Mailing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMailingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'channel' => 'nullable|string|in:email,sms,whatsapp,mms',
            'recipients' => 'nullable|array',
            'recipients.*' => 'string',
            'media_urls' => 'nullable|array',
            'media_urls.*' => 'url',
            'scheduled_at' => 'nullable|date|after:now',
            'status' => 'nullable|string|in:draft,scheduled,sent,failed',
        ];
    }
}
