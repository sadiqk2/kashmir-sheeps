<?php

namespace App\Domain\Identity\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByPhone(string $phone): ?User
    {
        return User::where('phone', $phone)->first();
    }

    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    public function update(User $user, array $attributes): bool
    {
        return $user->update($attributes);
    }

    public function getVerifiedSellers(): Collection
    {
        return User::whereIn('role', ['seller', 'farmer'])
            ->where('is_verified', true)
            ->latest()
            ->get();
    }

    public function getVerifiedBuyers(): Collection
    {
        return User::where('role', 'buyer')
            ->where('is_verified', true)
            ->latest()
            ->get();
    }
}
