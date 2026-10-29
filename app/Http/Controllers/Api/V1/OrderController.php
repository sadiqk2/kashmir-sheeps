<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Ordering\Actions\AdvanceOrderTrackingAction;
use App\Domain\Ordering\Actions\CancelOrderAction;
use App\Domain\Ordering\Actions\PlaceOrderAction;
use App\Domain\Ordering\DTOs\OrderData;
use App\Domain\Ordering\Repositories\OrderRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreOrderRequest;
use App\Http\Resources\V1\OrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepositoryInterface $repository,
        private PlaceOrderAction $placeOrderAction,
        private CancelOrderAction $cancelOrderAction,
        private AdvanceOrderTrackingAction $advanceTrackingAction
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $this->repository->all($request->all());

        return response()->json([
            'status' => 'success',
            'success' => true,
            'count' => $orders->count(),
            'data' => OrderResource::collection($orders),
            'meta' => [
                'version' => 'v1',
                'timestamp' => now()->toIso8601String(),
            ],
        ]);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $dto = OrderData::fromRequest($request->validated());
        $order = $this->placeOrderAction->execute($dto);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => "Order #{$order->order_no} booked successfully.",
            'order_no' => $order->order_no,
            'data' => new OrderResource($order),
        ], 201);
    }

    public function show(string $orderNo): JsonResponse
    {
        $order = $this->repository->findByOrderNo($orderNo);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'data' => new OrderResource($order),
        ]);
    }

    public function cancel(string $orderNo): JsonResponse
    {
        try {
            $order = $this->cancelOrderAction->execute($orderNo);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => "Order #{$order->order_no} has been cancelled and stock restored.",
                'data' => new OrderResource($order),
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function advanceTracking(string $orderNo): JsonResponse
    {
        try {
            $order = $this->advanceTrackingAction->execute($orderNo);

            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => "Order #{$order->order_no} status updated to {$order->status}.",
                'data' => new OrderResource($order),
            ]);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}
