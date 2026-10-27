# EduLearn

Platform kelas daring sederhana: **guru** menyusun kelas berisi materi tertulis dan video YouTube, **siswa** mempelajarinya sesuai ritme masing-masing, dan progres belajar tercatat otomatis.

Awalnya dibuat sebagai tugas Praktikum Pemrograman Web (semester 3, 2023), lalu diperbarui pada 2026: dipindah ke Laravel 13, diperbaiki keamanannya, dirapikan kodenya, dan didesain ulang agar memenuhi WCAG 2.2 AA.

## Fitur

**Siswa**
- Menjelajah dan mencari kelas berdasarkan nama kelas atau nama guru
- Membaca materi dan menonton videonya, dengan navigasi materi sebelumnya/berikutnya
- Melihat progres belajar per kelas (di daftar kelas dan di profil)

**Guru**
- Membuat, mengubah, dan menghapus course miliknya sendiri
- Menulis materi (teks dan link video YouTube) di dalam course-nya
- Ringkasan: jumlah course, materi, dan siswa yang sudah belajar

**Admin**
- Semua kemampuan Guru, untuk semua course
- Mengelola akun Guru dan Siswa

## Teknologi

| | |
|---|---|
| Backend | PHP 8.3+ (diuji di 8.5), Laravel 13 |
| Database | MySQL 8 (development & production), SQLite in-memory (test) |
| Frontend | Blade components, Tailwind CSS 4, Vite 8, Heroicons |
| Font | Fraunces & Public Sans, di-bundle lokal (tanpa CDN) |
| Test | PHPUnit 12 (108 feature test) |

## Menjalankan di komputer sendiri

Prasyarat: PHP 8.3 atau lebih baru (dengan ekstensi `pdo_mysql`, `pdo_sqlite`, `mbstring`, `intl`), Composer 2, Node.js 20+, dan MySQL.

```bash
# 1. Pasang dependency
composer install
npm install

# 2. Siapkan konfigurasi
cp .env.example .env
php artisan key:generate
```

Buka `.env`, lalu sesuaikan koneksi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) dan akun Admin awal (`ADMIN_USERNAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`).

```bash
# 3. Buat tabel & akun Admin
php artisan migrate
php artisan db:seed

# 4. Build aset & jalankan
npm run build
php artisan serve
```

Ingin langsung melihat aplikasi berisi data? Jalankan seeder demo untuk membuat 6 kelas (Matematika, Fisika, Biologi, Kimia, Bahasa Indonesia, Pemrograman Web) dengan 30 materi dan 10 video YouTube. Kelas dibagikan ke akun Guru yang ada, atau ke 3 akun Guru demo jika belum ada Guru sama sekali. Seeder ini aman dijalankan berulang.

```bash
php artisan db:seed --class=DemoContentSeeder
```

Buka <http://localhost:8000> dan masuk dengan akun Admin dari `.env`. Jika `ADMIN_PASSWORD` dikosongkan, `db:seed` membuat password acak dan menampilkannya **sekali** di terminal.

Saat mengubah tampilan, jalankan `npm run dev` di terminal terpisah agar halaman langsung diperbarui.

## Menjalankan test

```bash
php artisan test
```

Test memakai SQLite in-memory, jadi database MySQL tidak tersentuh. Empat test registrasi butuh koneksi internet, karena validasi email memakai `email:dns` (memastikan domain email benar-benar ada).

## Struktur kode

```
app/
├── Enums/UserRole.php              Role Admin / Guru / Siswa
├── Http/
│   ├── Controllers/                Halaman publik, Auth/, Dashboard/
│   ├── Middleware/                 EnsureUserHasRole, SecurityHeaders
│   └── Requests/                   Validasi form
├── Models/                         User, Course, Content (+ Concerns/HasSlug)
└── Policies/                       Siapa boleh mengubah apa
resources/
├── css/app.css                     Design token (warna, font, fokus)
└── views/components/               Layout, form, tombol, kartu course, dll.
lang/id/validation.php              Pesan validasi Bahasa Indonesia
```

## Keamanan

- **Otorisasi lewat Policy.** Guru hanya bisa mengubah course dan materi miliknya. Akun Admin tidak bisa dibuat lewat registrasi dan tidak bisa diubah dari halaman kelola pengguna.
- **Login dibatasi** 5 percobaan per menit.
- **Password** minimal 8 karakter berisi huruf dan angka, disimpan dengan bcrypt.
- **Link video** hanya menerima YouTube; URL embed dibuat ulang oleh server, bukan diambil mentah dari input.
- **Security header** di setiap respons; Content-Security-Policy ketat di production (tanpa skrip inline).
- **Tidak ada aset dari CDN pihak ketiga.**

## Aksesibilitas (WCAG 2.2 AA)

- `lang="id"`, judul unik per halaman, tautan "Lewati ke konten utama"
- Setiap input punya label; pesan error terhubung lewat `aria-describedby` dan `aria-invalid`
- Semua fungsi bisa dipakai dengan keyboard, dengan indikator fokus yang selalu terlihat
- Responsif sampai lebar 320 px, menghormati pengaturan *reduced motion*
- Kontras warna sudah dihitung untuk setiap pasangan yang dipakai:

| Pasangan | Kontras | Minimal |
|---|---|---|
| Teks utama (tinta) di latar kertas | 14.4 : 1 | 4.5 : 1 |
| Teks sekunder di latar kertas | 6.1 : 1 | 4.5 : 1 |
| Teks di tombol utama | 14.4 : 1 | 4.5 : 1 |
| Teks gelap di aksen kuning | 9.4 : 1 | 4.5 : 1 |
| Teks footer di latar gelap | 8.4 : 1 | 4.5 : 1 |
| Pesan error | 6.5 : 1 | 4.5 : 1 |
| Border input | 4.7 : 1 | 3 : 1 |
| Indikator fokus (terang / gelap) | 14.4 : 1 / 9.4 : 1 | 3 : 1 |

## Checklist production

1. `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-anda`, dan `SESSION_SECURE_COOKIE=true`
2. `php artisan key:generate` (sekali saja, saat pertama deploy)
3. `composer install --no-dev --optimize-autoloader`
4. `npm ci && npm run build`
5. `php artisan migrate --force`, lalu `php artisan db:seed --force` untuk akun Admin pertama
6. `php artisan optimize` (cache config, route, dan view)
7. Pastikan folder `storage/` dan `bootstrap/cache/` bisa ditulis oleh web server
8. Arahkan document root web server ke folder `public/`, dan gunakan HTTPS

## Lisensi

MIT
