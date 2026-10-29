<?php

namespace App\Domain\Ordering\Actions;

use App\Domain\Ordering\DTOs\OrderData;
use App\Domain\Ordering\Repositories\OrderRepositoryInterface;
use App\Models\LivestockListing;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class PlaceOrderAction
{
    public function __construct(
        private OrderRepositoryInterface $repository
    ) {}

    public function execute(OrderData $data): Order
    {
        return DB::transaction(function () use ($data) {
            $subtotal = 0;
            foreach ($data->items as $item) {
                $subtotal += ($item->price * $item->qty);
            }

            // Delivery threshold rule: Free delivery above 1499, otherwise 199
            $shippingFee = ($subtotal >= 1499) ? 0.00 : 199.00;
            $totalAmount = $subtotal + $shippingFee;

            $orderNo = 'KS-' . rand(100000, 999999);
            $paymentStatus = match ($data->payment_method) {
                'Instant UPI' => 'verified',
                'KCC Subsidy Voucher' => 'kcc_approved',
                default => 'pending',
            };

            $order = $this->repository->create([
                'order_no' => $orderNo,
                'customer_name' => $data->customer_name,
                'customer_phone' => $data->customer_phone,
                'district' => $data->district,
                'delivery_address' => $data->delivery_address,
                'pin_code' => $data->pin_code,
                'payment_method' => $data->payment_method,
                'payment_status' => $paymentStatus,
                'upi_reference' => $data->upi_reference ?? ($data->payment_method === 'Instant UPI' ? 'UPI' . rand(1000000000, 9999999999) : null),
                'kcc_number' => $data->kcc_number,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'status' => 'Order Confirmed',
                'carrier_vehicle' => 'JK' . rand(10, 99) . '-E-' . rand(1000, 9999) . ' (Livestock Express)',
                'vas_officer_cleared' => 'Dr. Rafiq Ahmad, VAS ' . $data->district,
                'notes' => 'Livestock handled under J&K Sheep Husbandry transit guidelines.',
            ]);

            foreach ($data->items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'livestock_listing_id' => $itemData->id,
                    'title' => $itemData->title,
                    'spec' => $itemData->spec,
                    'inaph_tag' => $itemData->inaph_tag,
                    'unit_price' => $itemData->price,
                    'quantity' => $itemData->qty,
                    'total_price' => $itemData->price * $itemData->qty,
                ]);

                // Deduct live stock
                if ($itemData->id) {
                    $listing = LivestockListing::find($itemData->id);
                    if ($listing && $listing->type === 'live') {
                        $listing->update(['is_sold' => true]);
                    }
                }
            }

            return $order->fresh(['items']);
        });
    }
}
