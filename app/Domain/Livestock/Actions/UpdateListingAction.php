<?php

namespace App\Domain\Livestock\Actions;

use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use App\Models\LivestockListing;

class UpdateListingAction
{
    public function __construct(
        private LivestockListingRepositoryInterface $repository
    ) {}

    public function execute(LivestockListing $listing, array $attributes): LivestockListing
    {
        return $this->repository->update($listing, $attributes);
    }
}
