<?php

namespace App\Domain\Ordering\DTOs;

readonly class OrderData
{
    /**
     * @param OrderItemData[] $items
     */
    public function __construct(
        public string $customer_name,
        public string $customer_phone,
        public string $district,
        public string $delivery_address,
        public string $payment_method,
        public ?string $pin_code = null,
        public ?string $kcc_number = null,
        public ?string $upi_reference = null,
        public array $items = []
    ) {}

    public static function fromRequest(array $data): self
    {
        $items = array_map(fn($item) => OrderItemData::fromArray($item), $data['items'] ?? []);

        return new self(
            customer_name: $data['customer_name'],
            customer_phone: $data['customer_phone'],
            district: $data['district'],
            delivery_address: $data['delivery_address'],
            payment_method: $data['payment_method'],
            pin_code: $data['pin_code'] ?? null,
            kcc_number: $data['kcc_number'] ?? null,
            upi_reference: $data['upi_reference'] ?? null,
            items: $items
        );
    }
}
