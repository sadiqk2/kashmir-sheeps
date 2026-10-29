<?php

namespace App\Domain\Livestock\Repositories;

use App\Models\LivestockListing;
use Illuminate\Database\Eloquent\Collection;

interface LivestockListingRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findById(int $id): ?LivestockListing;

    public function create(array $attributes): LivestockListing;

    public function update(LivestockListing $listing, array $attributes): LivestockListing;

    public function delete(LivestockListing $listing): bool;
}
