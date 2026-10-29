<?php

namespace App\Domain\Pastoral\Repositories;

use App\Models\BahakTransitLog;
use Illuminate\Database\Eloquent\Collection;

class EloquentBahakTransitRepository implements BahakTransitRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = BahakTransitLog::orderByDesc('id');

        if (!empty($filters['route'])) {
            $query->where('route_name', 'like', '%' . $filters['route'] . '%');
        }

        return $query->get();
    }

    public function findByPermitNo(string $permitNo): ?BahakTransitLog
    {
        return BahakTransitLog::where('permit_no', $permitNo)->first();
    }

    public function create(array $attributes): BahakTransitLog
    {
        return BahakTransitLog::create($attributes);
    }
}
