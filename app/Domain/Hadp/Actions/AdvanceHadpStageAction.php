<?php

namespace App\Domain\Hadp\Actions;

use App\Domain\Hadp\Repositories\HadpApplicationRepositoryInterface;
use App\Models\HadpApplication;
use InvalidArgumentException;

class AdvanceHadpStageAction
{
    public function __construct(
        private HadpApplicationRepositoryInterface $repository
    ) {}

    public function execute(string $refNo): HadpApplication
    {
        $app = $this->repository->findByRefNo($refNo);

        if (!$app) {
            throw new InvalidArgumentException("HADP application {$refNo} not found.");
        }

        if ($app->workflow_stage < 5) {
            $newStage = $app->workflow_stage + 1;
            $updates = ['workflow_stage' => $newStage];

            if ($newStage === 2) {
                $updates['vas_inspector_name'] = 'Dr. Z. A. Rather, VAS ' . $app->district;
            } elseif ($newStage === 4) {
                $updates['sanction_order_no'] = 'DSHO/' . strtoupper(substr($app->district, 0, 3)) . '/HADP/2026/' . rand(100, 999);
            } elseif ($newStage === 5) {
                $updates['disbursed_at'] = now();
            }

            return $this->repository->update($app, $updates);
        }

        return $app;
    }
}
