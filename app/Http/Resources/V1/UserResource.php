<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'role_label' => match($this->role) {
                'seller' => 'Registered Livestock Breeder & Seller',
                'farmer' => 'HADP Certified Pastoralist & Sheep Farmer',
                'veterinarian' => 'Veterinary Assistant Surgeon (VAS)',
                'admin' => 'Department Director / Admin',
                default => 'Verified Buyer / Consumer',
            },
            'district' => $this->district,
            'tehsil' => $this->tehsil,
            'village' => $this->village,
            'is_verified' => (bool) $this->is_verified,
            'kkg_id' => $this->kkg_id,
            'inaph_breeder_code' => $this->inaph_breeder_code,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
