<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'guest_id' => 'required|exists:guests,id',
            'ticket_number' => 'required|string|unique:tickets',
            'status' => 'nullable|string',
        ];
    }
}
