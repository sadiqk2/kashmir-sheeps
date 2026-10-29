<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreLivestockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|integer|exists:users,id',
            'title_en' => 'required|string|max:255',
            'title_ur' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|string|max:100',
            'spec_en' => 'required|string|max:255',
            'spec_ur' => 'nullable|string|max:255',
            'district' => 'required|string|max:100',
            'farmer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'inaph_tag' => 'nullable|string|max:20',
            'desc_en' => 'nullable|string',
            'desc_ur' => 'nullable|string',
            'photo' => 'nullable|string',
        ];
    }
}
