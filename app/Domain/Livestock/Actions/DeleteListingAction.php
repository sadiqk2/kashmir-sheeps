<?php

namespace App\Domain\Livestock\Actions;

use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use App\Models\LivestockListing;

class DeleteListingAction
{
    public function __construct(
        private LivestockListingRepositoryInterface $repository
    ) {}

    public function execute(LivestockListing $listing): bool
    {
        return $this->repository->delete($listing);
    }
}
