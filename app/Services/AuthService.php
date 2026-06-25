<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data): array
    {
        $remember = $data['remember_me'] ?? false;

        $ttl = $remember
            ? 60 * 24 * 30
            : config('jwt.ttl');

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (! $token = auth('api')
            ->setTTL($ttl)
            ->attempt($credentials)) {

            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $ttl * 60,
            'user' => new UserResource(
                auth('api')->user()
            ),
        ];
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function refresh(): array
    {
        return [
            'access_token' => auth('api')->refresh(),
            'token_type' => 'Bearer',
        ];
    }

    public function profile(): UserResource
    {
        return new UserResource(
            auth('api')->user()
        );
    }
}
