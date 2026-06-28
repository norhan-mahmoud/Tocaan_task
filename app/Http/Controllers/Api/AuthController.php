<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Login a user and return a JWT token.
     *
     * @bodyParam email string required The email of the user. Example: test@example.com
     * @bodyParam password string required The password of the user. Example: password
     *
     * @response {
     * "success": true,
     * "message": "Logged in successfully.",
     * "data": {
     * "access_token": "ey********",
     * "token_type": "Bearer",
     * "expires_in": 3600,
     * "user": {
     * "id": 1,
     * "name": null,
     * "email": "test@example.com"
     * }
     * }
     * }
     *
     */
    public function login(LoginRequest $request): JsonResponse
    {

        return $this->success(
            $this->authService->login(
                $request->validated()
            ),
            'Logged in successfully.'
        );
    }
    /**
     * @authentication Bearer
     * @response {
     * "success": true,
     * "message": "Logged out successfully.",
     * "data": null
     * }
    */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success(
            null,
            'Logged out successfully.'
        );
    }
    /***
     * @authentication Bearer
     * @response {
     * "success": true,
     * "message": "Token refreshed successfully.",
     * "data": {
     * "access_token": "ey********",
     * "token_type": "Bearer",
     * "expires_in": 3600,
     * "user": {
     * "id": 1,
     * "name": null,
     * "email": "",
     * }
     * }
     * }
     *
    */
    public function refresh(): JsonResponse
    {
        return $this->success(
            $this->authService->refresh(),
            'Token refreshed successfully.'
        );
    }
    /**
     * @authentication Bearer
     * @response {
     * "success": true,
     * "message": "Profile retrieved successfully.",
     * "data": {
     * "id": 1,
     * "first_name": "Test",
     * "last_name": "Last Name",
     * "email": "",
     * "phone_number": "1234567890",
     * "addresses": [
     * {
     * "id": 1,
     * "city": "Cairo",
     * "country": "Egypt",
     * "building": "Building 1",
     * "floor": "1",
     * "street": "Street 1",
     * "apartment": "101",
     * "user_id": 1,
     * "created_at": "2024-06-19T12:00:00.000000Z",
     * "updated_at": "2024-06-19T12:00:00.000000Z"
     * }
     * ]
     * }
     * }
     * }
     * @response 401 {
     * "success": false,
     * "message": "Unauthenticated.",
     * "data": null
     * }    
    */
    public function profile(): JsonResponse
    {

        return $this->success(
            $this->authService->profile(),
            'Profile retrieved successfully.'
        );
    }
}
