<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'min:10', 'max:15'],
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
