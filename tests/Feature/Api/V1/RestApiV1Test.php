<?php

namespace Tests\Feature\Api\V1;

use App\Models\LivestockListing;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestApiV1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_v1_livestock_index_returns_rest_envelope(): void
    {
        $response = $this->getJson('/api/v1/livestock');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'meta' => [
                    'version' => 'v1',
                ],
            ])
            ->assertJsonStructure([
                'status',
                'count',
                'data' => [
                    '*' => ['id', 'title_en', 'price', 'price_formatted', 'district', 'category']
                ],
                'meta' => ['version', 'timestamp']
            ]);
    }

    public function test_v1_orders_post_and_get_lifecycle(): void
    {
        $listing = LivestockListing::first();

        $payload = [
            'customer_name' => 'DDD Test Buyer',
            'customer_phone' => '09419099881',
            'district' => 'Shopian',
            'delivery_address' => 'Hirpora',
            'payment_method' => 'Cash on Delivery',
            'items' => [
                [
                    'id' => $listing->id,
                    'title' => $listing->title_en,
                    'price' => $listing->price,
                    'qty' => 1,
                    'spec' => $listing->spec_en,
                    'inaph_tag' => $listing->inaph_tag,
                ]
            ]
        ];

        $postRes = $this->postJson('/api/v1/orders', $payload);
        $postRes->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'customer_name' => 'DDD Test Buyer',
                    'district' => 'Shopian',
                    'status' => 'Order Confirmed',
                ]
            ]);

        $orderNo = $postRes->json('order_no');

        // Check GET /api/v1/orders/{orderNo}
        $getRes = $this->getJson("/api/v1/orders/{$orderNo}");
        $getRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'order_no' => $orderNo,
                    'customer_name' => 'DDD Test Buyer',
                ]
            ]);
    }

    public function test_v1_hadp_subsidies_lifecycle(): void
    {
        $payload = [
            'beneficiary_name' => 'DDD HADP Beneficiary',
            'aadhaar_hash' => 'XXXX-XXXX-1122',
            'phone' => '09419112233',
            'district' => 'Pulwama',
            'target_scheme' => 'Project 24: Commercial 50-Ewe Sheep Farm',
            'training_status' => 'Daksh Kisan Certified',
        ];

        $res = $this->postJson('/api/v1/hadp', $payload);
        $res->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'beneficiary_name' => 'DDD HADP Beneficiary',
                    'workflow_stage' => 1,
                    'workflow_stage_label' => 'Application Submitted (KKG Intake)',
                ]
            ]);

        $refNo = $res->json('ref_no');

        // Advance stage
        $advRes = $this->postJson("/api/v1/hadp/{$refNo}/advance-stage");
        $advRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'workflow_stage' => 2,
                    'workflow_stage_label' => 'Technical Scrutiny (Tehsil VAS Verified)',
                ]
            ]);
    }

    public function test_v1_inaph_registry_and_search(): void
    {
        $payload = [
            'tag_no' => '040011223344',
            'breed' => 'Kashmir Merino Stud',
            'sex' => 'Ram / Male',
            'teeth' => '2 Teeth (Doda)',
            'owner_name' => 'Pastoral Farmer',
            'district' => 'Ganderbal',
        ];

        $postRes = $this->postJson('/api/v1/inaph', $payload);
        $postRes->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'tag_no' => '040011223344',
                    'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
                ]
            ]);

        $getRes = $this->getJson('/api/v1/inaph/040011223344');
        $getRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'tag_no' => '040011223344',
                ]
            ]);
    }

    public function test_v1_clinical_diagnosis_and_dosage(): void
    {
        $diagRes = $this->postJson('/api/v1/clinical/diagnose', [
            'symptoms' => ['sudden_death', 'convulsions']
        ]);
        $diagRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'helpline' => '1962 (J&K 24x7 Mobile Veterinary Ambulance)',
            ]);

        $doseRes = $this->postJson('/api/v1/clinical/dosage', [
            'weight_kg' => 40,
            'drug' => 'fenbendazole'
        ]);
        $doseRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'calculation' => [
                    'volume_ml' => 3.0,
                ]
            ]);
    }

    public function test_v1_wool_lab_analysis(): void
    {
        $payload = [
            'farmer_name' => 'Ghulam Hassan Mir',
            'district' => 'Ganderbal',
            'micron' => 18.5,
            'staple_length_cm' => 8.0,
            'clean_yield_pct' => 64.0,
            'greasy_weight_kg' => 4.0,
        ];

        $res = $this->postJson('/api/v1/wool-lab/analyze', $payload);
        $res->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'wool_grade' => 'Superfine Merino Grade A (Premium Apparel)',
                ]
            ]);
    }

    public function test_v1_bahak_transit_registration(): void
    {
        $payload = [
            'chopan_name' => 'Mohd Ismail Khatana',
            'chopan_id' => 'CHP-PUL-012',
            'phone' => '09419088221',
            'route_name' => 'Peer Ki Gali / Mughal Road',
            'ewe_count' => 200,
            'ram_count' => 25,
            'lamb_count' => 95,
            'dipping_cert_no' => 'DIP-HIRPORA-2026-402',
            'checkpost_name' => 'Hirpora Wildlife Gate',
            'transit_date' => '2026-10-29',
        ];

        $res = $this->postJson('/api/v1/bahak-transit', $payload);
        $res->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'total_head_count' => 320,
                    'clearance_status' => 'Cleared',
                ]
            ]);
    }
}
