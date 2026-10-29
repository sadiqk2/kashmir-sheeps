<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['nullable', 'string', 'in:buyer,seller,farmer,veterinarian,admin'],
            'district' => ['nullable', 'string', 'max:100'],
            'tehsil' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:150'],
            'kkg_id' => ['nullable', 'string', 'max:50'],
            'inaph_breeder_code' => ['nullable', 'string', 'max:50'],
            'aadhaar_hash' => ['nullable', 'string', 'max:50'],
        ];
    }
}
