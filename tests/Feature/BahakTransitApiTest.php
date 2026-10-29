<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BahakTransitApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_list_bahak_transit_logs(): void
    {
        $response = $this->getJson('/api/bahak-transit');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure([
                'success',
                'count',
                'data' => [
                    '*' => ['id', 'permit_no', 'chopan_name', 'route_name', 'total_head_count', 'clearance_status']
                ]
            ]);
    }

    public function test_can_register_new_transhumance_migration_transit_permit(): void
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

        $response = $this->postJson('/api/bahak-transit', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'chopan_name' => 'Mohd Ismail Khatana',
                    'route_name' => 'Peer Ki Gali / Mughal Road',
                    'total_head_count' => 320,
                    'clearance_status' => 'Cleared',
                ]
            ]);

        $this->assertDatabaseHas('bahak_transit_logs', [
            'chopan_name' => 'Mohd Ismail Khatana',
            'total_head_count' => 320,
        ]);
    }
}
