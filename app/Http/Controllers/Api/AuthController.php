<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {

        return $this->success(
            $this->authService->login(
                $request->validated()
            ),
            'Logged in successfully.'
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success(
            null,
            'Logged out successfully.'
        );
    }

    public function refresh(): JsonResponse
    {
        return $this->success(
            $this->authService->refresh(),
            'Token refreshed successfully.'
        );
    }

    public function profile(): JsonResponse
    {

        return $this->success(
            $this->authService->profile(),
            'Profile retrieved successfully.'
        );
    }
}
