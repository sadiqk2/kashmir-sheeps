<?php

namespace App\Domain\Hadp\Actions;

use App\Domain\Hadp\DTOs\HadpApplicationData;
use App\Domain\Hadp\Repositories\HadpApplicationRepositoryInterface;
use App\Models\HadpApplication;

class SubmitHadpApplicationAction
{
    public function __construct(
        private HadpApplicationRepositoryInterface $repository
    ) {}

    public function execute(HadpApplicationData $data): HadpApplication
    {
        $scheme = $data->target_scheme;
        $unitCost = 500000.00;
        $subsidy = 250000.00; // 50% DBT cap

        if (str_contains($scheme, 'Shearing') || str_contains($scheme, 'Project 27')) {
            $unitCost = 300000.00;
            $subsidy = 150000.00;
        } elseif (str_contains($scheme, 'Fodder') || str_contains($scheme, 'Silage')) {
            $unitCost = 150000.00;
            $subsidy = 75000.00;
        } elseif (str_contains($scheme, 'Ram') || str_contains($scheme, 'Buck')) {
            $unitCost = 40000.00;
            $subsidy = 20000.00;
        }

        $refNo = 'HADP-JK-SHP-' . rand(10000, 99999);

        return $this->repository->create([
            'ref_no' => $refNo,
            'beneficiary_name' => $data->beneficiary_name,
            'aadhaar_hash' => $data->aadhaar_hash,
            'phone' => $data->phone,
            'district' => $data->district,
            'target_scheme' => $scheme,
            'training_status' => $data->training_status,
            'unit_cost' => $unitCost,
            'subsidy_amount' => $subsidy,
            'workflow_stage' => 1,
            'kkg_center_id' => 'KKG-' . strtoupper(substr($data->district, 0, 3)) . '-' . rand(10, 99),
        ]);
    }
}
