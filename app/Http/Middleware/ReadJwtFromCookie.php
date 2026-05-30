<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReadJwtFromCookie
{
    /**
     * Read the JWT from the HttpOnly cookie and inject it into the Authorization header.
     *
     * This allows Tymon's JWT guard to authenticate the request transparently.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->bearerToken() && $request->cookie('jwt_token')) {
            $request->headers->set('Authorization', 'Bearer '.$request->cookie('jwt_token'));
        }

        return $next($request);
    }
}
