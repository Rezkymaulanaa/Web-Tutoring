<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'role' => ['required', Rule::in(User::ASSIGNABLE_ROLES)],
            'password' => ['required', 'max:255', Password::defaults()],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk');
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return view('dashboard.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email:dns|unique:users,email,' . $user->id,
            'role' => ['required', Rule::in(User::ASSIGNABLE_ROLES)],
        ]);

        $user->update($validatedData);

        return redirect('/dashboard/user')->with('success', 'Data user berhasil diperbarui');
    }


    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        // Course tidak ikut terhapus otomatis, supaya materi milik Guru tidak hilang tanpa sengaja
        if ($user->courses()->exists()) {
            return back()->withErrors(['error' => "{$user->nama} masih memiliki course. Hapus course-nya terlebih dahulu."]);
        }

        $user->delete();

        return redirect('/dashboard/user')->with('success', 'Data user berhasil dihapus');
    }
}
