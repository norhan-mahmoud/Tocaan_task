<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly OrderService $orderService
    ) {}

    public function index(IndexOrderRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $orders = $this->orderService->index($filters);

        return $this->success(
            OrderResource::collection($orders)
        );
    }

    public function show(Order $order): JsonResponse
    {
        return $this->success(
            new OrderResource($order)
        );
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->store(
            auth()->id(),
            $request->validated()
        );

        return $this->success(
            new OrderResource($order),
            'Order created successfully.',
            201
        );
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order = $this->orderService->update(
            $order,
            $request->validated()
        );

        return $this->success(
            new OrderResource($order),
            'Order updated successfully.'
        );
    }

    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->delete($order);

        return $this->success(
            null,
            'Order deleted successfully.'
        );
    }
}
