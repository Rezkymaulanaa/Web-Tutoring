<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $courses = Course::with('user')->withProgressFor($request->user())->latest()->limit(6)->get();

        $stats = [
            'siswa' => User::where('role', UserRole::Siswa)->count(),
            'guru' => User::where('role', UserRole::Guru)->count(),
            'materi' => Content::count(),
        ];

        return view('home', compact('courses', 'stats'));
    }
}
