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
/**
 * @group Orders management
 *
 * APIs for managing orders
*/
class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly OrderService $orderService
    ) {}

    //scribe
    /**
     * Display a listing of the orders.
     *
     * @queryParam status string Filter orders by status. Example: pending
     * @queryParam per_page integer Number of orders to return per page min 10 to 100. Example: 10
     *
     * @bodyParam
     *
    *response 401 {
    *   "message": "Unauthenticated."
    *}
    */
    public function index(IndexOrderRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $orders = $this->orderService->index($filters);

        return $this->success(
            OrderResource::collection($orders)
        );
    }

    /**
     * Display the specified order.
     *
     * @urlParam order int required The ID of the order. Example: 1
     *response 404 {
     *   "message": "No query results for model [App\\Models\\Order] 1"
     *}
     */
    public function show(Order $order): JsonResponse
    {
        return $this->success(
            new OrderResource($order)
        );
    }

    /**
     * Create a new order.
     *
     *
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "items": [],
     *     "total_amount": 100.00,
     *     "status": "pending"
     *   }
     * }
     */
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
