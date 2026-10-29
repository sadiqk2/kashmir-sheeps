<?php

namespace App\Domain\Livestock\DTOs;

readonly class ListingData
{
    public function __construct(
        public string $title_en,
        public ?string $title_ur,
        public string $category,
        public float $price,
        public string $weight,
        public string $spec_en,
        public ?string $spec_ur,
        public string $district,
        public string $farmer_name,
        public string $phone,
        public ?string $whatsapp = null,
        public ?string $inaph_tag = null,
        public ?string $desc_en = null,
        public ?string $desc_ur = null,
        public ?string $photo = null,
        public ?array $gallery = null,
        public ?string $type = null,
        public ?int $user_id = null,
        public ?string $seller_verification_tier = null,
    ) {}

    public static function fromRequest(array $data, ?int $userId = null): self
    {
        $isLive = in_array($data['category'] ?? '', ['merino', 'bakarwali', 'qurbani']);
        $whatsapp = $data['whatsapp'] ?? preg_replace('/[^0-9]/', '', $data['phone'] ?? '');

        return new self(
            title_en: $data['title_en'],
            title_ur: $data['title_ur'] ?? $data['title_en'],
            category: $data['category'],
            price: (float) $data['price'],
            weight: str_ends_with($data['weight'] ?? '', 'Kg') ? $data['weight'] : ($data['weight'] ?? '50') . ' Kg',
            spec_en: $data['spec_en'],
            spec_ur: $data['spec_ur'] ?? $data['spec_en'],
            district: $data['district'],
            farmer_name: $data['farmer_name'],
            phone: $data['phone'],
            whatsapp: $whatsapp,
            inaph_tag: $data['inaph_tag'] ?? null,
            desc_en: $data['desc_en'] ?? 'Direct livestock from shepherd flock in Kashmir.',
            desc_ur: $data['desc_ur'] ?? 'براہ راست کشمیری فارمر کا مال۔',
            photo: $data['photo'] ?? null,
            gallery: $data['gallery'] ?? null,
            type: $data['type'] ?? ($isLive ? 'live' : 'product'),
            user_id: $userId ?? ($data['user_id'] ?? null),
            seller_verification_tier: $data['seller_verification_tier'] ?? null,
        );
    }
}
