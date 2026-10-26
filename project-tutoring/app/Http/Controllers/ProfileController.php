<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $courses = $user->courses;

        return view('profile.index', compact('user', 'associatedUsers', 'courses'));
    }
}
