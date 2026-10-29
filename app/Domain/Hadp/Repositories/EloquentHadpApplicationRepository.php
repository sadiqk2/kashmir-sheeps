<?php

namespace App\Domain\Hadp\Repositories;

use App\Models\HadpApplication;
use Illuminate\Database\Eloquent\Collection;

class EloquentHadpApplicationRepository implements HadpApplicationRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = HadpApplication::orderByDesc('id');

        if (!empty($filters['district'])) {
            $query->where('district', $filters['district']);
        }

        if (!empty($filters['stage'])) {
            $query->where('workflow_stage', $filters['stage']);
        }

        return $query->get();
    }

    public function findByRefNo(string $refNo): ?HadpApplication
    {
        return HadpApplication::where('ref_no', $refNo)->first();
    }

    public function create(array $attributes): HadpApplication
    {
        return HadpApplication::create($attributes);
    }

    public function update(HadpApplication $application, array $attributes): HadpApplication
    {
        $application->update($attributes);
        return $application->fresh();
    }
}
