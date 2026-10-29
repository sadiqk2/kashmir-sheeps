<?php

namespace App\Domain\Veterinary\Actions;

class CalculateDosageAction
{
    public function execute(float $weightKg, string $drug): array
    {
        $normalized = strtolower($drug);

        return match ($normalized) {
            'fenbendazole' => [
                'drug_name' => 'Fenbendazole 10% Oral Suspension',
                'dose_rate' => '7.5 mg / kg live weight',
                'volume_ml' => round(($weightKg * 7.5) / 100, 1),
                'route' => 'Oral Drench (after morning feed)',
                'indication' => 'Roundworms, lungworms, and stomach nematodes',
                'withdrawal' => 'Milk: 3 days, Meat: 14 days',
            ],
            'oxyclozanide' => [
                'drug_name' => 'Oxyclozanide 3.4% Flukicide Suspension',
                'dose_rate' => '10 mg / kg live weight',
                'volume_ml' => round(($weightKg * 10) / 34, 1),
                'route' => 'Oral Drench',
                'indication' => 'Adult Liver Fluke (*Fasciola*) & Amphistomes',
                'withdrawal' => 'Milk: 4 days, Meat: 28 days',
            ],
            'oxytetracycline' => [
                'drug_name' => 'Oxytetracycline 200 mg/ml Long Acting (L.A.)',
                'dose_rate' => '20 mg / kg live weight',
                'volume_ml' => round(($weightKg * 20) / 200, 1),
                'route' => 'Deep Intramuscular (Neck muscle)',
                'indication' => 'Pneumonia, Foot Rot, secondary viral bacterial infections',
                'withdrawal' => 'Meat: 21 days',
            ],
            'meloxicam' => [
                'drug_name' => 'Meloxicam 5 mg/ml Anti-Inflammatory Injection',
                'dose_rate' => '0.5 mg / kg live weight',
                'volume_ml' => round(($weightKg * 0.5) / 5, 1),
                'route' => 'Subcutaneous / Intramuscular',
                'indication' => 'Fever reduction, pain management in limping, mastitis, trauma',
                'withdrawal' => 'Meat: 5 days',
            ],
            default => [
                'drug_name' => 'Broad Spectrum Mineral Drench',
                'dose_rate' => '1 ml / 5 kg live weight',
                'volume_ml' => round($weightKg / 5, 1),
                'route' => 'Oral',
                'indication' => 'General metabolic support',
                'withdrawal' => 'None',
            ],
        };
    }
}
