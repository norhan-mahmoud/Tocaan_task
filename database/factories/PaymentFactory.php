<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'transaction_id' => $this->faker->uuid(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'paid_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'gateway'=>'paymob',
            'payment_method' => 'visa',
        ];
    }
}
