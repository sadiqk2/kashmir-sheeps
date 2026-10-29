<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivestockListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tier = $this->seller_verification_tier ?? 'basic';
        $badge = match ($tier) {
            'aadhaar_inaph' => '🛡️ Aadhaar & INAPH Verified Breeder',
            'aadhaar_only' => '🛡️ Aadhaar Verified Farmer',
            'inaph_only' => '📋 INAPH Registered Breeder',
            'verified_phone' => '✓ Verified Phone Member',
            default => 'Community Seller',
        };

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'seller_verification_tier' => $tier,
            'seller_verified_badge' => $badge,
            'type' => $this->type,
            'category' => $this->category,
            'title_en' => $this->title_en,
            'title_ur' => $this->title_ur,
            'price' => (float) $this->price,
            'price_formatted' => '₹' . number_format($this->price, 2),
            'weight' => $this->weight,
            'spec_en' => $this->spec_en,
            'spec_ur' => $this->spec_ur,
            'district' => $this->district,
            'village_en' => $this->village_en,
            'village_ur' => $this->village_ur,
            'farmer_name' => $this->farmer_name,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'is_qurbani' => $this->is_qurbani,
            'verified' => (bool) $this->verified,
            'rating' => (float) $this->rating,
            'reviews_count' => $this->reviews_count,
            'inaph_tag' => $this->inaph_tag,
            'is_sold' => (bool) $this->is_sold,
            'gallery' => $this->gallery ?? [],
            'desc_en' => $this->desc_en,
            'desc_ur' => $this->desc_ur,
            'passport' => new InaphPassportResource($this->whenLoaded('passport')),
            'seller' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'phone' => $this->user->phone,
                    'district' => $this->user->district,
                    'tehsil' => $this->user->tehsil,
                    'village' => $this->user->village,
                    'is_verified' => $this->user->is_verified,
                    'inaph_breeder_code' => $this->user->inaph_breeder_code,
                    'has_aadhaar' => !empty($this->user->aadhaar_hash),
                ];
            }),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
