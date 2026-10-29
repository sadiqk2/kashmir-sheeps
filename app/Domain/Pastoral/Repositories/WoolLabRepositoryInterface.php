<?php

namespace App\Domain\Pastoral\Repositories;

use App\Models\WoolLabRecord;
use Illuminate\Database\Eloquent\Collection;

interface WoolLabRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findBySampleCode(string $sampleCode): ?WoolLabRecord;

    public function create(array $attributes): WoolLabRecord;
}
