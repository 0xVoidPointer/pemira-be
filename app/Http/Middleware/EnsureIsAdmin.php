<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('admin');

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! in_array($user->role, [UserRole::Admin, UserRole::SuperAdmin])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
