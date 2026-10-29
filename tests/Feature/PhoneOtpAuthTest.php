<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PhoneOtpAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test sending 6-digit OTP code to phone.
     */
    public function test_can_send_otp_to_phone(): void
    {
        $response = $this->postJson('/api/v1/auth/otp/send', [
            'phone' => '09419011223',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('phone', '09419011223');
        $this->assertNotNull(Cache::get('phone_otp_09419011223'));
    }

    /**
     * Test verifying OTP fails with invalid code.
     */
    public function test_otp_verification_fails_with_invalid_code(): void
    {
        Cache::put('phone_otp_09419011223', '786000', 300);

        $response = $this->postJson('/api/v1/auth/otp/verify', [
            'phone' => '09419011223',
            'otp' => '000000',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
    }

    /**
     * Test verifying OTP authenticates existing user and issues token.
     */
    public function test_otp_verification_authenticates_existing_farmer(): void
    {
        Cache::put('phone_otp_09419011223', '786000', 300);

        $response = $this->postJson('/api/v1/auth/otp/verify', [
            'phone' => '09419011223',
            'otp' => '786000',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.user.phone', '09419011223');
        $this->assertNotEmpty($response->json('data.token'));
    }

    /**
     * Test verifying OTP registers new user if phone does not exist.
     */
    public function test_otp_verification_registers_new_user(): void
    {
        $newPhone = '09419555666';
        Cache::put('phone_otp_' . $newPhone, '786000', 300);

        $response = $this->postJson('/api/v1/auth/otp/verify', [
            'phone' => $newPhone,
            'otp' => '786000',
            'name' => 'Mohammad Yaseen (Gurez Pastoralist)',
            'district' => 'Bandipora',
            'role' => 'farmer',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.user.name', 'Mohammad Yaseen (Gurez Pastoralist)');
        $response->assertJsonPath('data.user.district', 'Bandipora');
        $this->assertDatabaseHas('users', [
            'phone' => $newPhone,
            'name' => 'Mohammad Yaseen (Gurez Pastoralist)',
        ]);
    }
}
