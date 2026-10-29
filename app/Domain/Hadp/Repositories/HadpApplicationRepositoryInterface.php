<?php

namespace App\Domain\Hadp\Repositories;

use App\Models\HadpApplication;
use Illuminate\Database\Eloquent\Collection;

interface HadpApplicationRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findByRefNo(string $refNo): ?HadpApplication;

    public function create(array $attributes): HadpApplication;

    public function update(HadpApplication $application, array $attributes): HadpApplication;
}
