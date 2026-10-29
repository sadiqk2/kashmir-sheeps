<?php

namespace Tests\Feature;

use App\Models\HadpApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HadpApplicationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_list_hadp_applications(): void
    {
        $response = $this->getJson('/api/hadp');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'count',
                'data' => [
                    '*' => ['id', 'ref_no', 'beneficiary_name', 'target_scheme', 'workflow_stage', 'subsidy_amount']
                ]
            ]);
    }

    public function test_can_submit_commercial_sheep_farm_hadp_application(): void
    {
        $payload = [
            'beneficiary_name' => 'Adil Ahmad Magray',
            'aadhaar_hash' => 'XXXX-XXXX-9921',
            'phone' => '09419234567',
            'district' => 'Anantnag',
            'target_scheme' => 'Project 24: Commercial 50-Ewe Sheep Farm',
            'training_status' => 'Completed - Daksh Kisan LMS',
        ];

        $response = $this->postJson('/api/hadp', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'beneficiary_name' => 'Adil Ahmad Magray',
                    'district' => 'Anantnag',
                    'unit_cost' => '500000.00',
                    'subsidy_amount' => '250000.00', // 50% cap
                    'workflow_stage' => 1,
                ]
            ]);

        $refNo = $response->json('ref_no');
        $this->assertNotEmpty($refNo);

        $this->assertDatabaseHas('hadp_applications', [
            'ref_no' => $refNo,
            'beneficiary_name' => 'Adil Ahmad Magray',
        ]);
    }

    public function test_can_advance_hadp_workflow_stage(): void
    {
        $app = HadpApplication::where('workflow_stage', 1)->first();

        // Advance to Stage 2: Tehsil VAS scrutiny
        $res = $this->postJson("/api/hadp/{$app->ref_no}/advance-stage");
        $res->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'workflow_stage' => 2,
                ]
            ]);

        $this->assertEquals(2, $app->fresh()->workflow_stage);
    }
}
