<?php

namespace Tests\Feature\Payments;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_create_payment()
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'id' => 9998,
            'user_id' => $user->id,
            'status' => OrderStatus::CONFIRMED,
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/orders/$order->id/pay", [
                'payment_method' => 'visa',
            ]);
        $response->assertStatus(201);
    }

    public function test_verify_payment_successfully()
    {
        $user = User::factory()->create();

        $order = Order::factory()->create([
            'id' => 9128,
            'user_id' => $user->id,
            'status' => OrderStatus::CONFIRMED,
        ]);

        Payment::factory()->create([
            'order_id' => $order->id,
            'status' => 'pending',
            'transaction_id' => '1234567890',
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/orders/paymob/verify-payment", [
                'obj' => [
                    'id' => '1234567890',
                    'payment_method' => 'visa',
                    'success' => true,
                    'data' => [
                        'captured' => true,
                    ],
                ],
            ]);



        $response->assertOk();
    }
}
