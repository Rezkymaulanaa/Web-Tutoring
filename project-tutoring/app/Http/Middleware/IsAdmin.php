<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Pengecekan apakah pengguna adalah admin
        if ($request->user() && $request->user()->role === 'Admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
