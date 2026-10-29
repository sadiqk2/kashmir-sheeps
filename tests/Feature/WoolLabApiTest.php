<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WoolLabApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_analyze_superfine_merino_wool(): void
    {
        $payload = [
            'farmer_name' => 'Ghulam Hassan Mir',
            'district' => 'Ganderbal',
            'micron' => 18.2,
            'staple_length_cm' => 8.0,
            'clean_yield_pct' => 65.0,
            'greasy_weight_kg' => 4.0,
        ];

        $response = $this->postJson('/api/wool-lab/analyze', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'farmer_name' => 'Ghulam Hassan Mir',
                    'micron' => '18.2',
                    'wool_grade' => 'Superfine Merino Grade A (Premium Apparel)',
                    'msp_rate_per_kg' => '340.00',
                    'clean_yield_bonus' => '95.00',
                ]
            ]);

        $this->assertDatabaseHas('wool_lab_records', [
            'farmer_name' => 'Ghulam Hassan Mir',
            'wool_grade' => 'Superfine Merino Grade A (Premium Apparel)',
        ]);
    }

    public function test_can_list_past_wool_lab_records(): void
    {
        $response = $this->getJson('/api/wool-lab');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'count',
                'data' => [
                    '*' => ['id', 'sample_code', 'farmer_name', 'micron', 'wool_grade', 'total_payout']
                ]
            ]);
    }
}
