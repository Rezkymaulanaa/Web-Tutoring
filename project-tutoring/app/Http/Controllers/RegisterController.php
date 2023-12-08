<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
            'role' => 'required|string',
            'password' => 'required|min:8|max:255'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk');
    }

    public function edit(User $user)
    {
        return view('dashboard.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email:dns|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);

        $user->update($validatedData);

        return redirect('/dashboard/user')->with('success', 'Data user berhasil diperbarui');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/dashboard/user')->with('success', 'Data user berhasil dihapus');
    }
}
