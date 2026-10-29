<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\LivestockListing;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Order::with('items')->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('phone')) {
            $query->where('customer_phone', 'like', '%' . $request->phone . '%');
        }

        $orders = $query->get();

        return response()->json([
            'success' => true,
            'count' => $orders->count(),
            'data' => $orders,
        ]);
    }

    /**
     * Store a newly created order from checkout.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'district' => 'required|string|max:100',
            'delivery_address' => 'required|string',
            'pin_code' => 'nullable|string|max:10',
            'payment_method' => 'required|string', // 'Cash on Delivery', 'Instant UPI', 'KCC Subsidy Voucher'
            'kcc_number' => 'nullable|string|max:30',
            'upi_reference' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|integer',
            'items.*.title' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.spec' => 'nullable|string',
            'items.*.inaph_tag' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated) {
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }

            // Delivery charge rule: Free delivery above 1499, otherwise 199
            $shippingFee = ($subtotal >= 1499) ? 0.00 : 199.00;
            $totalAmount = $subtotal + $shippingFee;

            $orderNo = 'KS-' . rand(100000, 999999);
            $paymentStatus = match ($validated['payment_method']) {
                'Instant UPI' => 'verified',
                'KCC Subsidy Voucher' => 'kcc_approved',
                default => 'pending',
            };

            $order = Order::create([
                'order_no' => $orderNo,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'district' => $validated['district'],
                'delivery_address' => $validated['delivery_address'],
                'pin_code' => $validated['pin_code'] ?? null,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'upi_reference' => $validated['upi_reference'] ?? ($validated['payment_method'] === 'Instant UPI' ? 'UPI' . rand(1000000000, 9999999999) : null),
                'kcc_number' => $validated['kcc_number'] ?? null,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total_amount' => $totalAmount,
                'status' => 'Order Confirmed',
                'carrier_vehicle' => 'JK' . rand(10, 99) . '-E-' . rand(1000, 9999) . ' (Livestock Express)',
                'vas_officer_cleared' => 'Dr. Rafiq Ahmad, VAS ' . $validated['district'],
                'notes' => 'Livestock handled under J&K Sheep Husbandry transit guidelines.',
            ]);

            foreach ($validated['items'] as $itemData) {
                $listingId = $itemData['id'] ?? null;

                OrderItem::create([
                    'order_id' => $order->id,
                    'livestock_listing_id' => $listingId,
                    'title' => $itemData['title'],
                    'spec' => $itemData['spec'] ?? null,
                    'inaph_tag' => $itemData['inaph_tag'] ?? null,
                    'unit_price' => $itemData['price'],
                    'quantity' => $itemData['qty'],
                    'total_price' => $itemData['price'] * $itemData['qty'],
                ]);

                // If this is a live animal, mark as sold
                if ($listingId) {
                    $listing = LivestockListing::find($listingId);
                    if ($listing && $listing->type === 'live') {
                        $listing->update(['is_sold' => true]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_no} booked successfully.",
                'order_no' => $order->order_no,
                'data' => $order->load('items'),
            ], 201);
        });
    }

    /**
     * Display the specified order with items.
     */
    public function show(string $orderNo): JsonResponse
    {
        $order = Order::with('items')->where('order_no', $orderNo)->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $order]);
    }

    /**
     * Cancel an active order.
     */
    public function cancel(string $orderNo): JsonResponse
    {
        $order = Order::with('items')->where('order_no', $orderNo)->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        if ($order->status === 'Delivered') {
            return response()->json(['success' => false, 'message' => 'Delivered order cannot be cancelled.'], 400);
        }

        return DB::transaction(function () use ($order) {
            $order->update(['status' => 'Cancelled']);

            // Restore live stock
            foreach ($order->items as $item) {
                if ($item->livestock_listing_id) {
                    $listing = LivestockListing::find($item->livestock_listing_id);
                    if ($listing) {
                        $listing->update(['is_sold' => false]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_no} has been cancelled and stock restored.",
                'data' => $order,
            ]);
        });
    }

    /**
     * Advance tracking timeline status (simulation).
     */
    public function advanceTracking(string $orderNo): JsonResponse
    {
        $order = Order::where('order_no', $orderNo)->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $stages = [
            'Order Confirmed' => 'Veterinary Health Cleared',
            'Veterinary Health Cleared' => 'In Transit',
            'In Transit' => 'Delivered',
        ];

        if (isset($stages[$order->status])) {
            $order->update(['status' => $stages[$order->status]]);
        }

        return response()->json([
            'success' => true,
            'message' => "Order #{$order->order_no} status updated to {$order->status}.",
            'data' => $order,
        ]);
    }
}
