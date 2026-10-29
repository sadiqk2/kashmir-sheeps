<?php

namespace App\Domain\Veterinary\Actions;

use App\Domain\Veterinary\Repositories\InaphPassportRepositoryInterface;
use App\Models\InaphPassport;

class SearchInaphTagAction
{
    public function __construct(
        private InaphPassportRepositoryInterface $repository
    ) {}

    public function execute(string $tagNo): ?InaphPassport
    {
        return $this->repository->findByTagNo($tagNo);
    }
}
