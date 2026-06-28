<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_amount' => 0,
            'status' => $this->faker->randomElement([
                'pending',
                'completed',
                'cancelled',
            ]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {

            $items = OrderItem::factory()
                ->count(rand(1, 5))
                ->create([
                    'order_id' => $order->id,
                ]);

            $order->update([
                'total_amount' => $items->sum('subtotal'),
            ]);
        });
    }
}
