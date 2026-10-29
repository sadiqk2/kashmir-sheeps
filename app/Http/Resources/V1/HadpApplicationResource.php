<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HadpApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ref_no' => $this->ref_no,
            'beneficiary_name' => $this->beneficiary_name,
            'aadhaar_hash' => $this->aadhaar_hash,
            'phone' => $this->phone,
            'district' => $this->district,
            'target_scheme' => $this->target_scheme,
            'training_status' => $this->training_status,
            'unit_cost' => (float) $this->unit_cost,
            'subsidy_amount' => (float) $this->subsidy_amount,
            'workflow_stage' => $this->workflow_stage,
            'workflow_stage_label' => $this->stage_label,
            'kkg_center_id' => $this->kkg_center_id,
            'vas_inspector_name' => $this->vas_inspector_name,
            'sanction_order_no' => $this->sanction_order_no,
            'disbursed_at' => $this->disbursed_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
