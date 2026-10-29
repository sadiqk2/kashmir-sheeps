<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class AnalyzeWoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'farmer_name' => 'required|string|max:255',
            'flock_tag_reference' => 'nullable|string|max:50',
            'district' => 'required|string|max:100',
            'micron' => 'required|numeric|min:14|max:45',
            'staple_length_cm' => 'required|numeric|min:2|max:20',
            'clean_yield_pct' => 'required|numeric|min:30|max:85',
            'greasy_weight_kg' => 'required|numeric|min:0.5|max:1000',
        ];
    }
}
