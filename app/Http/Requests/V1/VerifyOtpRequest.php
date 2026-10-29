<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'otp' => ['required', 'string', 'min:4', 'max:8'],
            'name' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:buyer,seller,farmer,veterinarian'],
            'district' => ['nullable', 'string', 'max:100'],
            'tehsil' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
            'aadhaar_hash' => ['nullable', 'string', 'max:50'],
            'inaph_breeder_code' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function normalizedPhone(): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string) $this->input('phone'));
        if (str_starts_with($clean, '91') && strlen($clean) === 12) {
            $clean = '0' . substr($clean, 2);
        }
        return $clean;
    }
}
