<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Mengisi kelas & materi contoh supaya aplikasi terlihat lengkap saat dicoba.
 * Jalankan: php artisan db:seed --class=DemoContentSeeder
 *
 * Kelas dibagikan bergiliran ke akun Guru yang sudah ada. Jika belum ada Guru sama sekali,
 * seeder membuat akun Guru demo. Aman dijalankan berulang: data yang sama tidak dibuat dua kali.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $courses = require database_path('seeders/data/demo-courses.php');
        $teachers = $this->teachers();

        foreach ($courses as $index => $data) {
            $teacher = $teachers[$index % $teachers->count()];

            $course = Course::updateOrCreate(
                ['course' => $data['course']],
                [
                    'deskripsi' => $data['deskripsi'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'user_id' => $teacher->id,
                ],
            );

            foreach ($data['contents'] as $content) {
                $course->contents()->updateOrCreate(
                    ['title' => $content['title']],
                    [
                        'content' => $content['content'],
                        'youtube_link' => $content['youtube_link'],
                        'user_id' => $teacher->id,
                    ],
                );
            }
        }

        $this->command?->info(count($courses).' kelas demo siap, dibagikan ke '.$teachers->count().' guru.');
    }

    /**
     * @return Collection<int, User>
     */
    private function teachers(): Collection
    {
        $teachers = User::where('role', UserRole::Guru)->orderBy('id')->get();

        if ($teachers->isNotEmpty()) {
            return $teachers;
        }

        return collect([
            ['nama' => 'Rina Wulandari', 'username' => 'rina.guru'],
            ['nama' => 'Dimas Pratama', 'username' => 'dimas.guru'],
            ['nama' => 'Sari Lestari', 'username' => 'sari.guru'],
        ])->map(fn (array $guru) => User::create([
            ...$guru,
            'email' => $guru['username'].'@edulearn.test',
            'role' => UserRole::Guru,
            // Akun demo: password acak, dapat diatur ulang oleh Admin bila dibutuhkan
            'password' => Str::password(16, symbols: false),
        ]));
    }
}
