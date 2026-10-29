<?php

namespace App\Domain\Identity\DTOs;

class RegisterUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $phone = null,
        public readonly string $role = 'buyer',
        public readonly ?string $district = null,
        public readonly ?string $tehsil = null,
        public readonly ?string $village = null,
        public readonly ?string $kkgId = null,
        public readonly ?string $inaphBreederCode = null,
        public readonly ?string $aadhaarHash = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            phone: $data['phone'] ?? null,
            role: $data['role'] ?? 'buyer',
            district: $data['district'] ?? null,
            tehsil: $data['tehsil'] ?? null,
            village: $data['village'] ?? null,
            kkgId: $data['kkg_id'] ?? null,
            inaphBreederCode: $data['inaph_breeder_code'] ?? null,
            aadhaarHash: $data['aadhaar_hash'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'role' => $this->role,
            'district' => $this->district,
            'tehsil' => $this->tehsil,
            'village' => $this->village,
            'kkg_id' => $this->kkgId,
            'inaph_breeder_code' => $this->inaphBreederCode,
            'aadhaar_hash' => $this->aadhaarHash,
        ], fn ($val) => $val !== null);
    }
}
