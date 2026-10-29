<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class LogBahakTransitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chopan_name' => 'required|string|max:255',
            'chopan_id' => 'required|string|max:50',
            'phone' => 'required|string|max:50',
            'route_name' => 'required|string|max:255',
            'ewe_count' => 'required|integer|min:0',
            'ram_count' => 'required|integer|min:0',
            'lamb_count' => 'required|integer|min:0',
            'dipping_cert_no' => 'required|string|max:100',
            'checkpost_name' => 'required|string|max:100',
            'transit_date' => 'required|date',
        ];
    }
}
