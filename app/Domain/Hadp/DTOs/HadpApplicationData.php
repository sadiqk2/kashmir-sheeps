<?php

namespace App\Domain\Hadp\DTOs;

readonly class HadpApplicationData
{
    public function __construct(
        public string $beneficiary_name,
        public string $aadhaar_hash,
        public string $phone,
        public string $district,
        public string $target_scheme,
        public string $training_status
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            beneficiary_name: $data['beneficiary_name'],
            aadhaar_hash: $data['aadhaar_hash'],
            phone: $data['phone'],
            district: $data['district'],
            target_scheme: $data['target_scheme'],
            training_status: $data['training_status']
        );
    }
}
