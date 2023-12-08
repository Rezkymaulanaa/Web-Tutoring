<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Content;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseAccessMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $contentId = $request->route('id'); // Ambil ID konten dari rute

        if ($user && ($user->role === 'Admin' || $user->role === 'Guru')) {
            return $next($request);
        }

        // Tambahkan pengecekan jika pengguna yang terautentikasi memiliki content tersebut
        if ($user && $contentId) {
            $content = Content::find($contentId);
            if ($content && $content->user_id === $user->id) {
                return $next($request);
            }
        }

        return abort(403, 'Unauthorized action.');
    }
}

