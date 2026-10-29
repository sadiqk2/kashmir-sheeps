<?php

namespace App\Domain\Ordering\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function all(array $filters = []): Collection;

    public function findByOrderNo(string $orderNo): ?Order;

    public function create(array $attributes): Order;

    public function update(Order $order, array $attributes): Order;
}
