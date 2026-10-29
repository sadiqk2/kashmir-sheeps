<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterInaphPassportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag_no' => 'required|string|size:12|unique:inaph_passports,tag_no',
            'breed' => 'required|string|max:255',
            'genotype' => 'nullable|string|max:255',
            'sex' => 'required|string',
            'dob' => 'nullable|date',
            'teeth' => 'required|string',
            'sire_line' => 'nullable|string',
            'dam_line' => 'nullable|string',
            'etv_vaccination_date' => 'nullable|date',
            'pox_vaccination_date' => 'nullable|date',
            'deworming_date' => 'nullable|date',
            'deworming_drug' => 'nullable|string',
            'vet_officer' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'district' => 'required|string|max:100',
        ];
    }
}
