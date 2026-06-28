<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayPaymentRequest;
use App\Http\Requests\VerfyPaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Services\Payments\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
/**
 * @group Payments management
 * APIs for managing payments
*/
class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PaymentService $paymentService
    ) {}

    public function pay(
        Order $order,
        PayPaymentRequest $request
    ): JsonResponse {

        $order->loadMissing('user.addresses');

        $user = $order->user;

        if (! $user) {
            abort(404, 'User not found.');
        }

        if (! $user->addresses->count()) {
            abort(422, 'The user must have an address before initiating payment.');
        }

        $address = $user->addresses->first();

        $payment = $this->paymentService->pay(
            $order,
            array_merge(
                $request->validated(),
                [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,

                    'city' => $address->city,
                    'country' => $address->country,
                    'building' => $address->building,
                    'floor' => $address->floor,
                    'apartment' => $address->apartment,
                    'street' => $address->street,
                ]
            )
        );

        return $this->success(
            new PaymentResource($payment),
            'Payment initiated successfully.',
            201
        );
    }

    public function verify(

        VerfyPaymentRequest $request,

    ): JsonResponse {

        $payment = $this->paymentService->verify(
            $request->validated()
        );

        return $this->success(
            new PaymentResource($payment),
            'Payment verified successfully.'
        );
    }
}
