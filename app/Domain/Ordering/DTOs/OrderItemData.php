<?php

namespace App\Domain\Ordering\DTOs;

readonly class OrderItemData
{
    public function __construct(
        public ?int $id,
        public string $title,
        public float $price,
        public int $qty,
        public ?string $spec = null,
        public ?string $inaph_tag = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'],
            price: (float) $data['price'],
            qty: (int) ($data['qty'] ?? 1),
            spec: $data['spec'] ?? null,
            inaph_tag: $data['inaph_tag'] ?? null
        );
    }
}
