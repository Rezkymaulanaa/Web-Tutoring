<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();

        // Daftar sesama Guru atau sesama Siswa (Admin tidak menampilkan siapa pun)
        $associatedUsers = $user->isAdmin()
            ? collect()
            : User::where('role', $user->role)->whereKeyNot($user->id)->orderBy('nama')->get();

        // Siswa: kelas yang sudah pernah dibuka materinya, lengkap dengan progres
        $learningCourses = $user->isSiswa()
            ? Course::with('user')
                ->withProgressFor($user)
                ->whereHas('contents.viewers', fn (Builder $query) => $query->whereKey($user->id))
                ->get()
            : collect();

        $courses = $user->courses()->orderBy('course')->get();

        return view('profile.show', compact('user', 'associatedUsers', 'learningCourses', 'courses'));
    }
}
