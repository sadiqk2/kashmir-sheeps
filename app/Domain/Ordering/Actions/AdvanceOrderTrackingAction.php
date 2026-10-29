<?php

namespace App\Domain\Ordering\Actions;

use App\Domain\Ordering\Repositories\OrderRepositoryInterface;
use App\Domain\Ordering\ValueObjects\OrderStatus;
use App\Models\Order;
use InvalidArgumentException;

class AdvanceOrderTrackingAction
{
    public function __construct(
        private OrderRepositoryInterface $repository
    ) {}

    public function execute(string $orderNo): Order
    {
        $order = $this->repository->findByOrderNo($orderNo);

        if (!$order) {
            throw new InvalidArgumentException("Order #{$orderNo} not found.");
        }

        $currentStatus = OrderStatus::tryFrom($order->status);
        if ($currentStatus && $next = $currentStatus->next()) {
            return $this->repository->update($order, ['status' => $next->value]);
        }

        return $order;
    }
}
