<?php

namespace Tests\Feature;

use App\Models\LivestockListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifiedSellerLockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test creating a listing linked to an Aadhaar + INAPH verified user.
     */
    public function test_listing_inherits_aadhaar_and_inaph_verified_breeder_tier(): void
    {
        $seller = User::create([
            'name' => 'Ghulam Rasool Mir Test',
            'email' => 'ghulam.test@kashmirsheeps.in',
            'password' => bcrypt('password123'),
            'phone' => '09419123456',
            'role' => 'seller',
            'district' => 'Anantnag',
            'tehsil' => 'Mattan',
            'village' => 'Highland Farm',
            'inaph_breeder_code' => 'JK-BREED-TEST-001',
            'aadhaar_hash' => 'XXXX-XXXX-9999',
            'is_verified' => true,
        ]);

        $payload = [
            'user_id' => $seller->id,
            'title_en' => 'Pure Kashmir Merino Ram (Test Lineage)',
            'category' => 'merino',
            'price' => 32000,
            'weight' => '60 Kg',
            'spec_en' => '2 Teeth (Doda)',
            'district' => 'Anantnag',
            'farmer_name' => $seller->name,
            'phone' => $seller->phone,
            'inaph_tag' => '040099998888',
        ];

        $response = $this->postJson('/api/v1/livestock', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.user_id', $seller->id);
        $response->assertJsonPath('data.seller_verification_tier', 'aadhaar_inaph');
        $response->assertJsonPath('data.seller_verified_badge', '🛡️ Aadhaar & INAPH Verified Breeder');
        $response->assertJsonPath('data.verified', true);
    }

    /**
     * Test creating a listing linked to an Aadhaar-only verified user.
     */
    public function test_listing_inherits_aadhaar_only_verified_farmer_tier(): void
    {
        $seller = User::create([
            'name' => 'Bashir Orchardist',
            'email' => 'bashir.orchard@kashmirsheeps.in',
            'password' => bcrypt('password123'),
            'phone' => '09419987654',
            'role' => 'farmer',
            'district' => 'Shopian',
            'aadhaar_hash' => 'XXXX-XXXX-5555',
            'is_verified' => true,
        ]);

        $payload = [
            'user_id' => $seller->id,
            'title_en' => 'Screened Apple Orchard Sheep Manure (500 Kg)',
            'category' => 'fertilizer',
            'price' => 4500,
            'weight' => '500 Kg',
            'spec_en' => 'Tractor Trolley Load',
            'district' => 'Shopian',
            'farmer_name' => $seller->name,
            'phone' => $seller->phone,
        ];

        $response = $this->postJson('/api/v1/livestock', $payload);

        $response->assertStatus(201);
        $response->assertJsonPath('data.seller_verification_tier', 'aadhaar_only');
        $response->assertJsonPath('data.seller_verified_badge', '🛡️ Aadhaar Verified Farmer');
    }

    /**
     * Test sell modal markup contains seller identity banner & price guidance.
     */
    public function test_frontend_has_seller_verification_banner_and_decision_guidance(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="sellVerificationBanner"', false);
        $response->assertSee('id="sellPriceGuidance"', false);
        $response->assertSee('id="priceGuidanceText"', false);
    }
}
