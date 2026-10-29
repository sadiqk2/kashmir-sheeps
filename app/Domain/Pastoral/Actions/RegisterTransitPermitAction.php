<?php

namespace App\Domain\Pastoral\Actions;

use App\Domain\Pastoral\DTOs\BahakTransitData;
use App\Domain\Pastoral\Repositories\BahakTransitRepositoryInterface;
use App\Models\BahakTransitLog;

class RegisterTransitPermitAction
{
    public function __construct(
        private BahakTransitRepositoryInterface $repository
    ) {}

    public function execute(BahakTransitData $data): BahakTransitLog
    {
        $total = $data->ewe_count + $data->ram_count + $data->lamb_count;
        $permitNo = 'BAHAK-JK-2026-' . rand(1000, 9999);

        return $this->repository->create([
            'permit_no' => $permitNo,
            'chopan_name' => $data->chopan_name,
            'chopan_id' => $data->chopan_id,
            'phone' => $data->phone,
            'route_name' => $data->route_name,
            'ewe_count' => $data->ewe_count,
            'ram_count' => $data->ram_count,
            'lamb_count' => $data->lamb_count,
            'total_head_count' => $total,
            'dipping_cert_no' => $data->dipping_cert_no,
            'checkpost_name' => $data->checkpost_name,
            'transit_date' => $data->transit_date,
            'clearance_status' => 'Cleared',
        ]);
    }
}
