<?php

namespace App\Domain\Pastoral\Repositories;

use App\Models\WoolLabRecord;
use Illuminate\Database\Eloquent\Collection;

class EloquentWoolLabRepository implements WoolLabRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = WoolLabRecord::orderByDesc('id');

        if (!empty($filters['district'])) {
            $query->where('district', $filters['district']);
        }

        return $query->get();
    }

    public function findBySampleCode(string $sampleCode): ?WoolLabRecord
    {
        return WoolLabRecord::where('sample_code', $sampleCode)->first();
    }

    public function create(array $attributes): WoolLabRecord
    {
        return WoolLabRecord::create($attributes);
    }
}
