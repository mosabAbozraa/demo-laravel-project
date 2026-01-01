<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
 if (!Auth::check() || Auth::user()->role !== 'admin') {

        if ($request->expectsJson()) {
            return response()->json(
                ['message' => 'No Access Allowed. Admins only.'],
                403
            );
        }

        abort(403); 
    }

    return $next($request);
    }
}
