<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLivestockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:50',
            'is_sold' => 'nullable|boolean',
        ];
    }
}
