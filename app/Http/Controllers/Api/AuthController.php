<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function login(LoginRequest $request)
    {
        return response()->json(
            $this->authService->login(
                $request->validated()
            )
        );
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function refresh()
    {
        return response()->json(
            $this->authService->refresh()
        );
    }

    public function profile()
    {
        return response()->json(
            $this->authService->profile()
        );
    }
}
