<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Akun Admin awal
    |--------------------------------------------------------------------------
    |
    | Dibuat oleh `php artisan db:seed` jika belum ada. Isi lewat file .env.
    | Jika ADMIN_PASSWORD dikosongkan, seeder membuat password acak dan
    | menampilkannya satu kali di terminal.
    |
    */

    'admin' => [
        'nama' => env('ADMIN_NAME', 'Administrator'),
        'username' => env('ADMIN_USERNAME', 'admin'),
        'email' => env('ADMIN_EMAIL', 'admin@edulearn.test'),
        'password' => env('ADMIN_PASSWORD'),
    ],

];
