<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StudentLoginRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    /**
     * Authenticate a student (by email or NIM) and issue a JWT.
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

        $token = auth('student')->login($student);

        return response()->json(['token' => $token]);
    }

    /**
     * Invalidate the current student token.
     */
    public function logout(): JsonResponse
    {
        auth('student')->logout();

        return response()->json(['message' => 'Logged out']);
    }
}
