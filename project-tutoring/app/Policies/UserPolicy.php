<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Halaman kelola user hanya untuk akun Guru dan Siswa. Akun Admin (termasuk diri sendiri)
     * tidak bisa diubah atau dihapus dari sini, supaya Admin tidak terkunci dari aplikasinya.
     */
    public function update(User $user, User $target): bool
    {
        return $user->isAdmin() && ! $target->isAdmin();
    }

    public function delete(User $user, User $target): bool
    {
        return $this->update($user, $target);
    }
}
