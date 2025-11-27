<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'payment_date' => 'nullable|date',
        ];
    }
}
