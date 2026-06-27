<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Exceptions\CannotDeletePaidOrderException;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function index(array $filters): LengthAwarePaginator
    {
        $query = Order::query();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(
            $filters['per_page'] ?? 10
        );
    }

    public function store(int $userId, array $data): Order
    {
        return DB::transaction(function () use ($userId, $data) {

            $order = Order::create([
                'user_id' => $userId,
                'status' => $data['status'] ?? OrderStatus::PENDING,
                'total_amount' => 0,
            ]);

            $this->replaceItems($order, $data['items']);

            return $this->loadRelations($order);
        });
    }

    public function update(Order $order, array $data): Order
    {
        return DB::transaction(function () use ($order, $data) {

            if (isset($data['status'])) {
                $order->update([
                    'status' => $data['status'],
                ]);
            }

            if (isset($data['items'])) {
                $this->replaceItems($order, $data['items']);
            }

            return $this->loadRelations($order);
        });
    }

    public function delete(Order $order): void
    {
        if ($order->payments()->exists()) {
            throw new CannotDeletePaidOrderException;
        }

        $order->delete();
    }

    /**
     * Replace all order items and recalculate order total.
     */
    private function replaceItems(Order $order, array $items): void
    {
        $order->items()->delete();

        $total = 0;

        foreach ($items as $item) {

            $subtotal = $this->calculateSubtotal(
                $item['quantity'],
                $item['price']
            );

            $total += $subtotal;

            $order->items()->create([
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);
        }

        $this->updateOrderTotal($order, $total);
    }

    private function calculateSubtotal(
        int $quantity,
        float|int $price
    ): float {
        return $quantity * $price;
    }

    private function updateOrderTotal(
        Order $order,
        float $total
    ): void {
        $order->update([
            'total_amount' => $total,
        ]);
    }

    private function loadRelations(Order $order): Order
    {
        return $order->load([
            'items',
            'payments',
        ]);
    }
}
