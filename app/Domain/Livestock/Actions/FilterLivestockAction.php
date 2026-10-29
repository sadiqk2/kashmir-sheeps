<?php

namespace App\Domain\Livestock\Actions;

use App\Domain\Livestock\Repositories\LivestockListingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FilterLivestockAction
{
    public function __construct(
        private LivestockListingRepositoryInterface $repository
    ) {}

    public function execute(array $filters): Collection
    {
        return $this->repository->all($filters);
    }
}
