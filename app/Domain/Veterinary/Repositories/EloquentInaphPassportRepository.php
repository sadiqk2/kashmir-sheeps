<?php

namespace App\Domain\Veterinary\Repositories;

use App\Models\InaphPassport;
use Illuminate\Database\Eloquent\Collection;

class EloquentInaphPassportRepository implements InaphPassportRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = InaphPassport::with('listing')->orderByDesc('id');

        if (!empty($filters['tag'])) {
            $query->where('tag_no', 'like', '%' . $filters['tag'] . '%');
        }

        if (!empty($filters['district'])) {
            $query->where('district', $filters['district']);
        }

        return $query->get();
    }

    public function findByTagNo(string $tagNo): ?InaphPassport
    {
        return InaphPassport::with('listing')->where('tag_no', $tagNo)->first();
    }

    public function create(array $attributes): InaphPassport
    {
        return InaphPassport::create($attributes);
    }

    public function firstOrCreate(array $attributes, array $values = []): InaphPassport
    {
        return InaphPassport::firstOrCreate($attributes, $values);
    }
}
