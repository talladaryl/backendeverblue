<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_number' => 'nullable|string|unique:tickets,ticket_number,' . $this->ticket->id,
            'status' => 'nullable|string',
        ];
    }
}
