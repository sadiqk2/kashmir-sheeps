<?php

namespace App\Domain\Identity\Actions;

use App\Domain\Identity\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticateUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Authenticate user with email/phone & password and generate token.
     *
     * @return array{user: User, token: string}
     * @throws ValidationException
     */
    public function execute(string $login, string $password): array
    {
        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? $this->userRepository->findByEmail(strtolower(trim($login)))
            : $this->userRepository->findByPhone(trim($login));

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials do not match our records.')],
            ]);
        }

        // Generate Sanctum plain text token
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
