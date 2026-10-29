<?php

namespace App\Domain\Pastoral\DTOs;

readonly class BahakTransitData
{
    public function __construct(
        public string $chopan_name,
        public string $chopan_id,
        public string $phone,
        public string $route_name,
        public int $ewe_count,
        public int $ram_count,
        public int $lamb_count,
        public string $dipping_cert_no,
        public string $checkpost_name,
        public string $transit_date
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            chopan_name: $data['chopan_name'],
            chopan_id: $data['chopan_id'],
            phone: $data['phone'],
            route_name: $data['route_name'],
            ewe_count: (int) $data['ewe_count'],
            ram_count: (int) $data['ram_count'],
            lamb_count: (int) $data['lamb_count'],
            dipping_cert_no: $data['dipping_cert_no'],
            checkpost_name: $data['checkpost_name'],
            transit_date: $data['transit_date']
        );
    }
}
