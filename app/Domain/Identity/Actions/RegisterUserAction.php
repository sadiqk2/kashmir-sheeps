<?php

namespace App\Domain\Identity\Actions;

use App\Domain\Identity\DTOs\RegisterUserData;
use App\Domain\Identity\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new user and generate access token.
     *
     * @return array{user: User, token: string}
     */
    public function execute(RegisterUserData $data): array
    {
        // Business logic: if user registers with a certified KKG ID or INAPH code, they get auto-verified
        $isVerified = false;
        if (!empty($data->kkgId) || !empty($data->inaphBreederCode)) {
            $isVerified = true;
        }

        $attributes = [
            'name' => $data->name,
            'email' => strtolower(trim($data->email)),
            'phone' => $data->phone,
            'password' => Hash::make($data->password),
            'role' => $data->role,
            'district' => $data->district,
            'tehsil' => $data->tehsil,
            'village' => $data->village,
            'is_verified' => $isVerified,
            'kkg_id' => $data->kkgId,
            'inaph_breeder_code' => $data->inaphBreederCode,
            'aadhaar_hash' => $data->aadhaarHash,
        ];

        $user = $this->userRepository->create($attributes);

        // Generate Sanctum plain text token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
