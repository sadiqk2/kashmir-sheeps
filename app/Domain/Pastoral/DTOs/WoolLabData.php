<?php

namespace App\Domain\Pastoral\DTOs;

readonly class WoolLabData
{
    public function __construct(
        public string $farmer_name,
        public string $district,
        public float $micron,
        public float $staple_length_cm,
        public float $clean_yield_pct,
        public float $greasy_weight_kg,
        public ?string $flock_tag_reference = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            farmer_name: $data['farmer_name'],
            district: $data['district'],
            micron: (float) $data['micron'],
            staple_length_cm: (float) $data['staple_length_cm'],
            clean_yield_pct: (float) $data['clean_yield_pct'],
            greasy_weight_kg: (float) $data['greasy_weight_kg'],
            flock_tag_reference: $data['flock_tag_reference'] ?? null
        );
    }
}
