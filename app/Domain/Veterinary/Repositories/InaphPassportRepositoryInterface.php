<?php

namespace App\Domain\Veterinary\Repositories;

use App\Models\InaphPassport;
use Illuminate\Database\Eloquent\Collection;

interface InaphPassportRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findByTagNo(string $tagNo): ?InaphPassport;

    public function create(array $attributes): InaphPassport;

    public function firstOrCreate(array $attributes, array $values = []): InaphPassport;
}
