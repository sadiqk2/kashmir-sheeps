<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'district' => 'required|string|max:100',
            'delivery_address' => 'required|string',
            'pin_code' => 'nullable|string|max:10',
            'payment_method' => 'required|string',
            'kcc_number' => 'nullable|string|max:30',
            'upi_reference' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|integer',
            'items.*.title' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.spec' => 'nullable|string',
            'items.*.inaph_tag' => 'nullable|string',
        ];
    }
}
