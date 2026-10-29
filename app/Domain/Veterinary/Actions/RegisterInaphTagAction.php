<?php

namespace App\Domain\Veterinary\Actions;

use App\Domain\Veterinary\DTOs\InaphPassportData;
use App\Domain\Veterinary\Repositories\InaphPassportRepositoryInterface;
use App\Models\InaphPassport;

class RegisterInaphTagAction
{
    public function __construct(
        private InaphPassportRepositoryInterface $repository
    ) {}

    public function execute(InaphPassportData $data): InaphPassport
    {
        return $this->repository->create([
            'tag_no' => $data->tag_no,
            'breed' => $data->breed,
            'genotype' => $data->genotype ?? 'Kashmir Merino Certified Breed',
            'sex' => $data->sex,
            'dob' => $data->dob ?? now()->subMonths(18)->toDateString(),
            'teeth' => $data->teeth,
            'sire_line' => $data->sire_line ?? 'Govt Breeding Ram',
            'dam_line' => $data->dam_line ?? 'Pastoral Ewe Line',
            'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
            'etv_vaccination_date' => $data->etv_vaccination_date ?? now()->subMonths(2)->toDateString(),
            'pox_vaccination_date' => $data->pox_vaccination_date ?? now()->subMonths(4)->toDateString(),
            'deworming_date' => $data->deworming_date ?? now()->subMonth()->toDateString(),
            'deworming_drug' => $data->deworming_drug ?? 'Fenbendazole 10% (SKUAST Protocol)',
            'vet_officer' => $data->vet_officer ?? 'Dr. M. A. Lone, VAS J&K Sheep Husbandry',
            'fitness_cert_no' => 'JK-VET-FIT-2026-' . rand(100, 999),
            'owner_name' => $data->owner_name,
            'district' => $data->district,
        ]);
    }
}
