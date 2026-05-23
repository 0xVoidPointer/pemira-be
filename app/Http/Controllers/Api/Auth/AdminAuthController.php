<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use Illuminate\Http\JsonResponse;

class AdminAuthController extends Controller
{
    /**
     * Authenticate an admin user and issue a JWT.
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $token = auth('web')->attempt($credentials);

        if (! $token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * Invalidate the current admin token.
     */
    public function logout(): JsonResponse
    {
        auth('web')->logout();

        return response()->json(['message' => 'Logged out']);
    }
}
