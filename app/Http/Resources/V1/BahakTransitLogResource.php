<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BahakTransitLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'permit_no' => $this->permit_no,
            'chopan_name' => $this->chopan_name,
            'chopan_id' => $this->chopan_id,
            'phone' => $this->phone,
            'route_name' => $this->route_name,
            'ewe_count' => $this->ewe_count,
            'ram_count' => $this->ram_count,
            'lamb_count' => $this->lamb_count,
            'total_head_count' => $this->total_head_count,
            'dipping_cert_no' => $this->dipping_cert_no,
            'checkpost_name' => $this->checkpost_name,
            'transit_date' => $this->transit_date?->toDateString(),
            'clearance_status' => $this->clearance_status,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
