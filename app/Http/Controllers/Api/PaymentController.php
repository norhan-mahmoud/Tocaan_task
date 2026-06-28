<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayPaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use App\Services\Payments\PaymentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        $payment = $this->paymentService->pay(
            $order,
            $request->validated()
        );

        return $this->success(
            new PaymentResource($payment),
            'Payment initiated successfully.',
            201
        );
    }

    public function verify(Request $request): JsonResponse
    {
        $payment = $this->paymentService->verify(
            $request->all()
        );

        return $this->success(
            new PaymentResource($payment),
            'Payment verified successfully.'
        );
    }
}
