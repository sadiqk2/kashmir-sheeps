<?php

namespace Tests\Feature;

use Tests\TestCase;

class ClinicalDiagnosisApiTest extends TestCase
{
    public function test_can_diagnose_enterotoxaemia_and_provide_protocol(): void
    {
        $payload = [
            'symptoms' => ['sudden_death', 'convulsions', 'bloody_diarrhea']
        ];

        $response = $this->postJson('/api/clinical/diagnose', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'helpline' => '1962 (J&K 24x7 Mobile Veterinary Ambulance)',
            ]);

        $findings = $response->json('findings');
        $this->assertNotEmpty($findings);
        $this->assertEquals('Enterotoxaemia (ETV / Pulpy Kidney Disease)', $findings[0]['disease_en']);
        $this->assertEquals('Critical Emergency', $findings[0]['severity']);
    }

    public function test_can_diagnose_sheep_pox(): void
    {
        $payload = [
            'symptoms' => ['pox_lesions', 'high_fever']
        ];

        $response = $this->postJson('/api/clinical/diagnose', $payload);

        $response->assertStatus(200);
        $findings = $response->json('findings');
        $this->assertStringContainsString('Sheep Pox', $findings[0]['disease_en']);
    }

    public function test_can_calculate_weight_based_drug_dosage(): void
    {
        // 40 kg sheep, Fenbendazole (7.5 mg/kg -> 3.0 ml)
        $response = $this->postJson('/api/clinical/dosage', [
            'weight_kg' => 40,
            'drug' => 'fenbendazole'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'animal_weight_kg' => 40,
                'calculation' => [
                    'volume_ml' => 3.0,
                    'route' => 'Oral Drench (after morning feed)',
                ]
            ]);
    }
}
