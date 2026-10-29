<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class SubmitHadpApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'beneficiary_name' => 'required|string|max:255',
            'aadhaar_hash' => 'required|string|max:30',
            'phone' => 'required|string|max:50',
            'district' => 'required|string|max:100',
            'target_scheme' => 'required|string|max:255',
            'training_status' => 'required|string|max:255',
        ];
    }
}
