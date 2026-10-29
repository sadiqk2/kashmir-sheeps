<?php

namespace App\Domain\Veterinary\Actions;

class DiagnoseSymptomsAction
{
    public function execute(array $symptoms): array
    {
        $normalized = array_map('strtolower', $symptoms);
        $matches = [];

        // 1. Enterotoxaemia (ETV)
        if (
            in_array('sudden_death', $normalized) ||
            in_array('convulsions', $normalized) ||
            in_array('bloody_diarrhea', $normalized) ||
            in_array('frothing', $normalized)
        ) {
            $matches[] = [
                'disease_en' => 'Enterotoxaemia (ETV / Pulpy Kidney Disease)',
                'disease_ur' => 'انٹیرو ٹاکسیمیا (پیٹ کا زہر / گردہ کی خرابی)',
                'severity' => 'Critical Emergency',
                'causative_agent' => 'Clostridium perfringens Type D toxin',
                'triage_score' => 95,
                'immediate_actions' => [
                    'Immediately withhold all concentrate feed and lush green clover pasture.',
                    'Administer Clostridium perfringens hyperimmune serum or broad-spectrum penicillin under VAS supervision.',
                    'Emergency vaccination of the remaining unaffected flock.',
                ],
                'prevention' => 'Annual pre-monsoon and autumn booster vaccination with ETV vaccine (Dept of Sheep Husbandry).',
            ];
        }

        // 2. Sheep Pox (Kari)
        if (
            in_array('pox_lesions', $normalized) ||
            in_array('high_fever', $normalized) ||
            in_array('nodules_face', $normalized)
        ) {
            $matches[] = [
                'disease_en' => 'Sheep Pox (*Kari*)',
                'disease_ur' => 'بھیڑ کی چیچک (کری)',
                'severity' => 'High Contagious Risk',
                'causative_agent' => 'Capripoxvirus',
                'triage_score' => 85,
                'immediate_actions' => [
                    'Strict isolation of infected sheep into dry, warm shelter away from main flock.',
                    'Apply antiseptic boroglycerine or povidone-iodine on oral and skin crusts.',
                    'Provide soft gruel (barley/wheat bran) to facilitate swallowing.',
                    'Administer Long Acting Enrofloxacin / Oxytetracycline to prevent secondary bacterial pneumonia.',
                ],
                'prevention' => 'Cell culture Sheep Pox vaccine 0.5 ml subcutaneous annually before spring.',
            ];
        }

        // 3. Fascioliasis / Liver Fluke (Rok)
        if (
            in_array('bottle_jaw', $normalized) ||
            in_array('pale_gums', $normalized) ||
            in_array('edema', $normalized) ||
            in_array('weakness', $normalized)
        ) {
            $matches[] = [
                'disease_en' => 'Fascioliasis (*Liver Fluke / Rok*)',
                'disease_ur' => 'جگر کا کیڑا (روک / ورم گل)',
                'severity' => 'Moderate - Chronic Debilitating',
                'causative_agent' => 'Fasciola gigantica & Fasciola hepatica',
                'triage_score' => 75,
                'immediate_actions' => [
                    'Drench immediately with Oxyclozanide (10 mg/kg) or Triclabendazole (10 mg/kg) for immature flukes.',
                    'Administer oral iron-tonic (Feritas / Sharkoferrol) to combat severe anemia.',
                    'Move grazing away from water-logged marshy banks containing snail intermediate hosts (*Lymnaea*).',
                ],
                'prevention' => 'Strategic autumn & post-winter flock deworming schedule.',
            ];
        }

        // 4. Chillai Kalan Acute Bronchopneumonia
        if (
            in_array('coughing', $normalized) ||
            in_array('nasal_discharge', $normalized) ||
            in_array('shivering', $normalized) ||
            in_array('hypothermia', $normalized)
        ) {
            $matches[] = [
                'disease_en' => 'Chillai Kalan Acute Bronchopneumonia & Lamb Hypothermia',
                'disease_ur' => 'چلہ کلاں کی شدید نمونیا و سردی لگنا',
                'severity' => 'High Risk in Sub-Zero Weather',
                'causative_agent' => 'Mannheimia haemolytica & exposure to freezing drafts',
                'triage_score' => 90,
                'immediate_actions' => [
                    'Move lamb to warm dry stall with thick dry paddy straw bedding (*Kashmiri Dael*).',
                    'Administer warm colostrum or glucose solution orally.',
                    'Inject Oxytetracycline Long Acting (20 mg/kg I.M.) and Flunixin Meglumine for fever.',
                ],
                'prevention' => 'Stall insulation, avoiding wet floors, and colostrum intake within 2 hours of birth.',
            ];
        }

        // 5. Contagious Foot Rot
        if (
            in_array('limping', $normalized) ||
            in_array('foot_rot', $normalized) ||
            in_array('foul_smell', $normalized)
        ) {
            $matches[] = [
                'disease_en' => 'Contagious Foot Rot (*Khur Pakka*)',
                'disease_ur' => 'کھر پکنا / پاؤں کی سڑن',
                'severity' => 'Moderate - Mobility Restricting',
                'causative_agent' => 'Dichelobacter nodosus & Fusobacterium necrophorum',
                'triage_score' => 70,
                'immediate_actions' => [
                    'Careful paring of dead hoof horn without inducing bleeding.',
                    'Walk entire flock through 10% Zinc Sulphate or 5% Copper Sulphate foot-bath for 5 minutes.',
                    'Keep hooves on dry ground; spray with Oxytetracycline purple aerosol.',
                ],
                'prevention' => 'Regular seasonal hoof trimming and pasture drainage.',
            ];
        }

        if (empty($matches)) {
            $matches[] = [
                'disease_en' => 'Non-Specific General Ruminant Distress',
                'disease_ur' => 'عام جانوروں کی ناہمواری',
                'severity' => 'Routine Observation',
                'causative_agent' => 'Dietary change, seasonal stress, or mild parasitemia',
                'triage_score' => 40,
                'immediate_actions' => [
                    'Provide clean fresh warm water with electrolytes.',
                    'Administer oral probiotics and liver extract.',
                    'Contact local Tehsil Veterinary Assistant Surgeon for physical thermometer check.',
                ],
                'prevention' => 'Balanced stall feeding with meadow hay and UMMB lick blocks.',
            ];
        }

        return $matches;
    }
}
