<?php

namespace App\Domain\Identity\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function findByPhone(string $phone): ?User;

    public function create(array $attributes): User;

    public function update(User $user, array $attributes): bool;

    public function getVerifiedSellers(): Collection;

    public function getVerifiedBuyers(): Collection;
}
