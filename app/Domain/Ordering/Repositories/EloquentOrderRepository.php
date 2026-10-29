<?php

namespace App\Domain\Ordering\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = Order::with('items')->orderByDesc('id');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['phone'])) {
            $query->where('customer_phone', 'like', '%' . $filters['phone'] . '%');
        }

        return $query->get();
    }

    public function findByOrderNo(string $orderNo): ?Order
    {
        return Order::with('items')->where('order_no', $orderNo)->first();
    }

    public function create(array $attributes): Order
    {
        return Order::create($attributes);
    }

    public function update(Order $order, array $attributes): Order
    {
        $order->update($attributes);
        return $order->fresh(['items']);
    }
}
