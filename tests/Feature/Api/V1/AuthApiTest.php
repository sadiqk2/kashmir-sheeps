<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_buyer(): void
    {
        $payload = [
            'name' => 'Bashir Ahmad Reshi',
            'email' => 'bashir.reshi@gmail.com',
            'password' => 'secret12345',
            'phone' => '09419011122',
            'role' => 'buyer',
            'district' => 'Budgam',
            'tehsil' => 'Chadoora',
            'village' => 'Wathora',
        ];

        $response = $this->postJson('/api/v1/auth/register', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'name' => 'Bashir Ahmad Reshi',
                        'email' => 'bashir.reshi@gmail.com',
                        'role' => 'buyer',
                        'role_label' => 'Verified Buyer / Consumer',
                        'district' => 'Budgam',
                        'is_verified' => false,
                    ],
                ],
            ]);

        $this->assertNotEmpty($response->json('data.token'));
        $this->assertDatabaseHas('users', ['email' => 'bashir.reshi@gmail.com']);
    }

    public function test_farmer_with_kkg_id_is_auto_verified(): void
    {
        $payload = [
            'name' => 'Mohammad Shafi Lone',
            'email' => 'shafi.farmer@kashmirsheeps.in',
            'password' => 'secret12345',
            'phone' => '09419077665',
            'role' => 'farmer',
            'district' => 'Ganderbal',
            'kkg_id' => 'KKG-GAN-KANG-05',
        ];

        $response = $this->postJson('/api/v1/auth/register', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'name' => 'Mohammad Shafi Lone',
                        'role' => 'farmer',
                        'is_verified' => true,
                        'kkg_id' => 'KKG-GAN-KANG-05',
                    ],
                ],
            ]);
    }

    public function test_user_registration_requires_valid_email_and_password(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test Farmer',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        User::create([
            'name' => 'Ghulam Rasool Mir',
            'email' => 'ghulam.mir@kashmirsheeps.in',
            'password' => bcrypt('password123'),
            'role' => 'seller',
            'is_verified' => true,
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'login' => 'ghulam.mir@kashmirsheeps.in',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'email' => 'ghulam.mir@kashmirsheeps.in',
                        'role' => 'seller',
                    ],
                ],
            ]);

        $this->assertNotEmpty($response->json('data.token'));
    }

    public function test_login_fails_with_invalid_password(): void
    {
        User::create([
            'name' => 'Ghulam Rasool Mir',
            'email' => 'ghulam.mir@kashmirsheeps.in',
            'password' => bcrypt('password123'),
            'role' => 'seller',
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'login' => 'ghulam.mir@kashmirsheeps.in',
            'password' => 'wrong-pass',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_fetch_profile(): void
    {
        $user = User::create([
            'name' => 'Suhail Ahmad Bhat',
            'email' => 'suhail@example.com',
            'password' => bcrypt('password123'),
            'role' => 'buyer',
            'district' => 'Srinagar',
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $user->id,
                    'email' => 'suhail@example.com',
                    'district' => 'Srinagar',
                ],
            ]);
    }

    public function test_verified_sellers_list(): void
    {
        User::create([
            'name' => 'Mattan Stud Breeder',
            'email' => 'mattan@sheep.in',
            'password' => bcrypt('secret'),
            'role' => 'seller',
            'is_verified' => true,
        ]);

        $response = $this->getJson('/api/v1/users/sellers');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertGreaterThanOrEqual(1, count($response->json('data')));
    }
}
