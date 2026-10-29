<?php

namespace Tests\Feature;

use App\Models\LivestockListing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivestockApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_list_all_livestock(): void
    {
        $response = $this->getJson('/api/livestock');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'count',
                'data' => [
                    '*' => ['id', 'title_en', 'price', 'district', 'type', 'category']
                ]
            ]);
    }

    public function test_can_filter_livestock_by_category(): void
    {
        $response = $this->getJson('/api/livestock?category=merino');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        foreach ($data as $item) {
            $this->assertEquals('merino', $item['category']);
        }
    }

    public function test_can_filter_livestock_by_district(): void
    {
        $response = $this->getJson('/api/livestock?district=Ganderbal');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        foreach ($data as $item) {
            $this->assertStringContainsString('Ganderbal', $item['district']);
        }
    }

    public function test_farmer_can_post_new_listing(): void
    {
        $payload = [
            'title_en' => 'Highland Pure Bakarwali Stud Ram',
            'title_ur' => 'پیر پنجال خالص بکروال مینڈھ',
            'category' => 'bakarwali',
            'district' => 'Shopian',
            'price' => 31000,
            'weight' => '60',
            'spec_en' => '2 Teeth (Doda)',
            'farmer_name' => 'Bashir Ahmad Chopan',
            'phone' => '09419088776',
            'inaph_tag' => '040099881122',
            'desc_en' => 'Bred in Hirpora alpine rangelands.',
        ];

        $response = $this->postJson('/api/livestock', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'title_en' => 'Highland Pure Bakarwali Stud Ram',
                    'district' => 'Shopian',
                    'price' => '31000.00',
                    'type' => 'live',
                ]
            ]);

        $this->assertDatabaseHas('livestock_listings', [
            'title_en' => 'Highland Pure Bakarwali Stud Ram',
            'district' => 'Shopian',
            'inaph_tag' => '040099881122',
        ]);

        $this->assertDatabaseHas('inaph_passports', [
            'tag_no' => '040099881122',
        ]);
    }

    public function test_can_update_listing_price_and_sold_status(): void
    {
        $item = LivestockListing::first();

        $response = $this->putJson("/api/livestock/{$item->id}", [
            'price' => 29500,
            'is_sold' => true,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'price' => '29500.00',
                    'is_sold' => true,
                ]
            ]);

        $this->assertDatabaseHas('livestock_listings', [
            'id' => $item->id,
            'price' => 29500.00,
            'is_sold' => true,
        ]);
    }

    public function test_can_delete_listing(): void
    {
        $item = LivestockListing::create([
            'type' => 'product',
            'category' => 'supplies',
            'title_en' => 'Temporary Shearing Comb',
            'title_ur' => 'عارضی بلیڈ',
            'price' => 500,
            'weight' => '1 Kg',
            'spec_en' => 'Standard',
            'spec_ur' => 'معیاری',
            'district' => 'Srinagar',
            'village_en' => 'Batamaloo',
            'village_ur' => 'بٹہ مالو',
            'farmer_name' => 'Tool Seller',
            'phone' => '09419011111',
            'whatsapp' => '09419011111',
        ]);

        $response = $this->deleteJson("/api/livestock/{$item->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('livestock_listings', ['id' => $item->id]);
    }
}
