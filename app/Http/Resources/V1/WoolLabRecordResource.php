<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WoolLabRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sample_code' => $this->sample_code,
            'farmer_name' => $this->farmer_name,
            'flock_tag_reference' => $this->flock_tag_reference,
            'district' => $this->district,
            'micron' => (float) $this->micron,
            'staple_length_cm' => (float) $this->staple_length_cm,
            'clean_yield_pct' => (float) $this->clean_yield_pct,
            'greasy_weight_kg' => (float) $this->greasy_weight_kg,
            'wool_grade' => $this->wool_grade,
            'msp_rate_per_kg' => (float) $this->msp_rate_per_kg,
            'clean_yield_bonus' => (float) $this->clean_yield_bonus,
            'total_payout' => (float) $this->total_payout,
            'certified_by' => $this->certified_by,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
