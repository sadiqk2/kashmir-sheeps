<?php

namespace App\Domain\Veterinary\DTOs;

readonly class InaphPassportData
{
    public function __construct(
        public string $tag_no,
        public string $breed,
        public string $sex,
        public string $teeth,
        public string $owner_name,
        public string $district,
        public ?string $genotype = null,
        public ?string $dob = null,
        public ?string $sire_line = null,
        public ?string $dam_line = null,
        public ?string $etv_vaccination_date = null,
        public ?string $pox_vaccination_date = null,
        public ?string $deworming_date = null,
        public ?string $deworming_drug = null,
        public ?string $vet_officer = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            tag_no: $data['tag_no'],
            breed: $data['breed'],
            sex: $data['sex'],
            teeth: $data['teeth'],
            owner_name: $data['owner_name'],
            district: $data['district'],
            genotype: $data['genotype'] ?? 'Kashmir Merino Certified Breed',
            dob: $data['dob'] ?? null,
            sire_line: $data['sire_line'] ?? null,
            dam_line: $data['dam_line'] ?? null,
            etv_vaccination_date: $data['etv_vaccination_date'] ?? null,
            pox_vaccination_date: $data['pox_vaccination_date'] ?? null,
            deworming_date: $data['deworming_date'] ?? null,
            deworming_drug: $data['deworming_drug'] ?? null,
            vet_officer: $data['vet_officer'] ?? null
        );
    }
}
