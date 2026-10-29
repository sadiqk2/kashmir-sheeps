<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'livestock_listing_id' => $this->livestock_listing_id,
            'title' => $this->title,
            'spec' => $this->spec,
            'inaph_tag' => $this->inaph_tag,
            'unit_price' => (float) $this->unit_price,
            'quantity' => $this->quantity,
            'total_price' => (float) $this->total_price,
        ];
    }
}
