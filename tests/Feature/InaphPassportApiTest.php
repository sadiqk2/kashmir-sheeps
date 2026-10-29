<?php

namespace Tests\Feature;

use App\Models\InaphPassport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InaphPassportApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_search_inaph_passport_by_12_digit_rfid_tag(): void
    {
        $passport = InaphPassport::first();

        $response = $this->getJson("/api/inaph/{$passport->tag_no}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'tag_no' => $passport->tag_no,
                    'breed' => $passport->breed,
                    'rfid_frequency' => '134.2 kHz ISO 11784/11785 FDX-B',
                ]
            ]);
    }

    public function test_returns_404_on_unknown_tag(): void
    {
        $response = $this->getJson('/api/inaph/999999999999');

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_can_register_new_inaph_ear_tag(): void
    {
        $payload = [
            'tag_no' => '040088776655',
            'breed' => 'Kashmir Merino Stud',
            'sex' => 'Ram / Male',
            'teeth' => '2 Teeth (Doda)',
            'owner_name' => 'Ghulam Nabi Reshi',
            'district' => 'Bandipora',
        ];

        $response = $this->postJson('/api/inaph', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'tag_no' => '040088776655',
                    'breed' => 'Kashmir Merino Stud',
                    'owner_name' => 'Ghulam Nabi Reshi',
                ]
            ]);

        $this->assertDatabaseHas('inaph_passports', [
            'tag_no' => '040088776655',
            'owner_name' => 'Ghulam Nabi Reshi',
        ]);
    }
}
