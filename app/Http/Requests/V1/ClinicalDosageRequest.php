<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ClinicalDosageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight_kg' => 'required|numeric|min:2|max:150',
            'drug' => 'required|string',
        ];
    }
}
