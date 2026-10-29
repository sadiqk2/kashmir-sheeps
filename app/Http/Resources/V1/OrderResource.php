<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_no' => $this->order_no,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'district' => $this->district,
            'delivery_address' => $this->delivery_address,
            'pin_code' => $this->pin_code,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'upi_reference' => $this->upi_reference,
            'kcc_number' => $this->kcc_number,
            'subtotal' => (float) $this->subtotal,
            'shipping_fee' => (float) $this->shipping_fee,
            'total_amount' => (float) $this->total_amount,
            'status' => $this->status,
            'carrier_vehicle' => $this->carrier_vehicle,
            'vas_officer_cleared' => $this->vas_officer_cleared,
            'notes' => $this->notes,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
