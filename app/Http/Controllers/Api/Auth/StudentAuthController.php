<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StudentLoginRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class StudentAuthController extends Controller
{
    /**
     * Authenticate a student (by email or NIM) and issue a JWT via HttpOnly cookie.
     */
    public function login(StudentLoginRequest $request): JsonResponse
    {
        $identifier = $request->string('identifier')->toString();
        $password = $request->string('password')->toString();

        $student = Student::query()
            ->where('email', $identifier)
            ->orWhere('nim', $identifier)
            ->first();

        if (! $student || ! Hash::check($password, $student->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = auth('api')->login($student);

        $cookie = $this->makeAuthCookie($token);

        return response()->json(['message' => 'Authenticated'])->withCookie($cookie);
    }

    /**
     * Invalidate the current student token and clear the auth cookie.
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        $cookie = Cookie::create('jwt_token')
            ->withValue('')
            ->withExpires(time() - 3600)
            ->withPath('/api')
            ->withSecure(app()->environment('production'))
            ->withHttpOnly(true)
            ->withSameSite('None');

        return response()->json(['message' => 'Logged out'])->withCookie($cookie);
    }

    /**
     * Create the HttpOnly auth cookie containing the JWT.
     */
    private function makeAuthCookie(string $token): Cookie
    {
        $ttlMinutes = (int) config('jwt.ttl', 60);

        return Cookie::create('jwt_token')
            ->withValue($token)
            ->withExpires(time() + ($ttlMinutes * 60))
            ->withPath('/api')
            ->withSecure(app()->environment('production'))
            ->withHttpOnly()
            ->withSameSite('None');
    }
}
