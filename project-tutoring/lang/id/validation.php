<?php

/*
 * Pesan validasi Bahasa Indonesia untuk aturan yang dipakai di aplikasi ini.
 * Aturan lain otomatis memakai pesan bahasa Inggris (fallback_locale).
 */
return [

    'after' => ':Attribute harus setelah :date.',
    'date' => ':Attribute bukan tanggal yang valid.',
    'email' => ':Attribute harus berupa alamat email yang valid.',
    'enum' => ':Attribute yang dipilih tidak valid.',
    'exists' => ':Attribute yang dipilih tidak valid.',
    'max' => [
        'string' => ':Attribute maksimal :max karakter.',
    ],
    'min' => [
        'string' => ':Attribute minimal :min karakter.',
    ],
    'password' => [
        'letters' => ':Attribute harus berisi minimal satu huruf.',
        'mixed' => ':Attribute harus berisi minimal satu huruf besar dan satu huruf kecil.',
        'numbers' => ':Attribute harus berisi minimal satu angka.',
        'symbols' => ':Attribute harus berisi minimal satu simbol.',
        'uncompromised' => ':Attribute ini pernah bocor di internet. Silakan pilih :attribute lain.',
    ],
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':Attribute wajib diisi.',
    'string' => ':Attribute harus berupa teks.',
    'unique' => ':Attribute ini sudah dipakai.',
    'url' => ':Attribute harus berupa URL yang valid.',

    'attributes' => [
        'nama' => 'nama lengkap',
        'username' => 'username',
        'email' => 'email',
        'email_or_username' => 'email atau username',
        'role' => 'tipe akun',
        'password' => 'password',
        'course' => 'nama course',
        'course_id' => 'course',
        'deskripsi' => 'deskripsi',
        'start_date' => 'tanggal mulai',
        'end_date' => 'tanggal selesai',
        'title' => 'judul materi',
        'content' => 'isi materi',
        'youtube_link' => 'link YouTube',
    ],

];
