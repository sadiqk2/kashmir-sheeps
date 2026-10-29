<?php

namespace App\Domain\Livestock\Repositories;

use App\Models\LivestockListing;
use Illuminate\Database\Eloquent\Collection;

class EloquentLivestockListingRepository implements LivestockListingRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = LivestockListing::with('passport');

        if (!empty($filters['type']) && $filters['type'] !== 'all') {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['district']) && $filters['district'] !== 'all') {
            $query->where('district', 'like', '%' . $filters['district'] . '%');
        }

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('title_en', 'like', "%{$s}%")
                  ->orWhere('title_ur', 'like', "%{$s}%")
                  ->orWhere('spec_en', 'like', "%{$s}%")
                  ->orWhere('district', 'like', "%{$s}%")
                  ->orWhere('farmer_name', 'like', "%{$s}%")
                  ->orWhere('inaph_tag', 'like', "%{$s}%");
            });
        }

        if (isset($filters['qurbani']) && filter_var($filters['qurbani'], FILTER_VALIDATE_BOOLEAN)) {
            $query->where('is_qurbani', true);
        }

        $sort = $filters['sort'] ?? 'featured';
        switch ($sort) {
            case 'low':
                $query->orderBy('price', 'asc');
                break;
            case 'high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderByDesc('id');
                break;
        }

        return $query->get();
    }

    public function findById(int $id): ?LivestockListing
    {
        return LivestockListing::with('passport')->find($id);
    }

    public function create(array $attributes): LivestockListing
    {
        return LivestockListing::create($attributes);
    }

    public function update(LivestockListing $listing, array $attributes): LivestockListing
    {
        $listing->update($attributes);
        return $listing->fresh();
    }

    public function delete(LivestockListing $listing): bool
    {
        return $listing->delete();
    }
}
