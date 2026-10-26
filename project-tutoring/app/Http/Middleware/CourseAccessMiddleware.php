<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseAccessMiddleware
{
    /**
     * Hanya Admin dan Guru yang boleh membuka halaman kelola course dan materi.
     * Siapa yang boleh mengubah course/materi tertentu diatur oleh CoursePolicy dan ContentPolicy.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ($user->role === 'Admin' || $user->role === 'Guru')) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
