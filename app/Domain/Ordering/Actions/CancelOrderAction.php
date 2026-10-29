<?php

namespace App\Domain\Ordering\Actions;

use App\Domain\Ordering\Repositories\OrderRepositoryInterface;
use App\Models\LivestockListing;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CancelOrderAction
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

        if ($order->status === 'Delivered') {
            throw new InvalidArgumentException("Delivered order cannot be cancelled.");
        }

        return DB::transaction(function () use ($order) {
            $this->repository->update($order, ['status' => 'Cancelled']);

            foreach ($order->items as $item) {
                if ($item->livestock_listing_id) {
                    $listing = LivestockListing::find($item->livestock_listing_id);
                    if ($listing) {
                        $listing->update(['is_sold' => false]);
                    }
                }
            }

            return $order->fresh(['items']);
        });
    }
}
