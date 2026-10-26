<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Membuat akun Admin awal dari config/edulearn.php (diisi lewat .env).
     * Aman dijalankan berulang: akun yang sudah ada tidak diubah, termasuk passwordnya.
     */
    public function run(): void
    {
        $config = config('edulearn.admin');

        if (User::where('username', $config['username'])->exists()) {
            $this->command?->info("Akun admin '{$config['username']}' sudah ada, tidak diubah.");

            return;
        }

        $password = $config['password'] ?: Str::password(16, symbols: false);

        User::create([
            'nama' => $config['nama'],
            'username' => $config['username'],
            'email' => $config['email'],
            'role' => UserRole::Admin,
            'password' => $password,
        ]);

        $this->command?->info("Akun admin '{$config['username']}' dibuat.");

        if (! $config['password']) {
            $this->command?->warn("Password admin: {$password}");
            $this->command?->warn('Simpan sekarang. Password ini tidak akan ditampilkan lagi.');
        }
    }
}
