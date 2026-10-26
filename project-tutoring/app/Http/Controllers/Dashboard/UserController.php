<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $gurus = User::where('role', UserRole::Guru)->orderBy('nama')->get();
        $siswas = User::where('role', UserRole::Siswa)->orderBy('nama')->get();

        return view('dashboard.users.index', compact('gurus', 'siswas'));
    }

    public function create(): View
    {
        return view('dashboard.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()->route('dashboard.users.index')->with('success', 'Berhasil menambahkan user!');
    }

    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        return view('dashboard.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        $user->update($request->validated());

        return redirect()->route('dashboard.users.index')->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        // Course tidak ikut terhapus otomatis, supaya materi milik Guru tidak hilang tanpa sengaja
        if ($user->courses()->exists()) {
            return back()->withErrors(['error' => "{$user->nama} masih memiliki course. Hapus course-nya terlebih dahulu."]);
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', 'Data user berhasil dihapus');
    }
}
