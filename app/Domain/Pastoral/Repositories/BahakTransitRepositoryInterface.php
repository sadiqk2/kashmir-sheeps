<?php

namespace App\Domain\Pastoral\Repositories;

use App\Models\BahakTransitLog;
use Illuminate\Database\Eloquent\Collection;

interface BahakTransitRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findByPermitNo(string $permitNo): ?BahakTransitLog;

    public function create(array $attributes): BahakTransitLog;
}
