<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InaphPassportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tag_no' => $this->tag_no,
            'livestock_listing_id' => $this->livestock_listing_id,
            'breed' => $this->breed,
            'genotype' => $this->genotype,
            'sex' => $this->sex,
            'dob' => $this->dob?->toDateString(),
            'teeth' => $this->teeth,
            'sire_line' => $this->sire_line,
            'dam_line' => $this->dam_line,
            'rfid_frequency' => $this->rfid_frequency,
            'etv_vaccination_date' => $this->etv_vaccination_date?->toDateString(),
            'pox_vaccination_date' => $this->pox_vaccination_date?->toDateString(),
            'ppr_vaccination_date' => $this->ppr_vaccination_date?->toDateString(),
            'fmd_vaccination_date' => $this->fmd_vaccination_date?->toDateString(),
            'deworming_date' => $this->deworming_date?->toDateString(),
            'deworming_drug' => $this->deworming_drug,
            'vet_officer' => $this->vet_officer,
            'fitness_cert_no' => $this->fitness_cert_no,
            'owner_name' => $this->owner_name,
            'district' => $this->district,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
