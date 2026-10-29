<?php

namespace App\Domain\Pastoral\Actions;

use App\Domain\Pastoral\DTOs\WoolLabData;
use App\Domain\Pastoral\Repositories\WoolLabRepositoryInterface;
use App\Models\WoolLabRecord;

class AnalyzeWoolAction
{
    public function __construct(
        private WoolLabRepositoryInterface $repository
    ) {}

    public function execute(WoolLabData $data): array
    {
        $micron = $data->micron;
        $cleanYield = $data->clean_yield_pct;
        $greasyWt = $data->greasy_weight_kg;

        // HADP Project 27 Classification
        if ($micron < 19.5) {
            $grade = 'Superfine Merino Grade A (Premium Apparel)';
            $baseMsp = 340.00;
            $bonus = ($cleanYield >= 60) ? 95.00 : 50.00;
        } elseif ($micron <= 22.5) {
            $grade = 'Fine Merino Grade B (Worsted Suitings)';
            $baseMsp = 280.00;
            $bonus = ($cleanYield >= 58) ? 60.00 : 30.00;
        } elseif ($micron <= 26.0) {
            $grade = 'Medium Crossbred Grade C (Pheran Tweeds & Blankets)';
            $baseMsp = 210.00;
            $bonus = ($cleanYield >= 55) ? 35.00 : 15.00;
        } else {
            $grade = 'Bakarwali Coarse Grade D (Handmade Rugs & Namdas)';
            $baseMsp = 140.00;
            $bonus = ($cleanYield >= 50) ? 20.00 : 0.00;
        }

        $cleanWoolKg = round(($greasyWt * $cleanYield) / 100, 2);
        $ratePerKg = $baseMsp + $bonus;
        $totalPayout = round($cleanWoolKg * $ratePerKg, 2);

        $sampleCode = 'WOOL-SKUAST-2026-' . rand(1000, 9999);

        $record = $this->repository->create([
            'sample_code' => $sampleCode,
            'farmer_name' => $data->farmer_name,
            'flock_tag_reference' => $data->flock_tag_reference,
            'district' => $data->district,
            'micron' => $micron,
            'staple_length_cm' => $data->staple_length_cm,
            'clean_yield_pct' => $cleanYield,
            'greasy_weight_kg' => $greasyWt,
            'wool_grade' => $grade,
            'msp_rate_per_kg' => $baseMsp,
            'clean_yield_bonus' => $bonus,
            'total_payout' => $totalPayout,
            'certified_by' => 'SKUAST-K Wool Testing & Quality Certification Division (HADP Project 27)',
        ]);

        return [
            'record' => $record,
            'clean_wool_kg' => $cleanWoolKg,
        ];
    }
}
