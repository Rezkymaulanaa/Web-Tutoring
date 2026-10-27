<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningController extends Controller
{
    /**
     * Halaman ringkasan course beserta daftar materinya.
     */
    public function course(Course $course): View
    {
        $course->load('user', 'contents');

        return view('courses.show', compact('course'));
    }

    /**
     * Halaman belajar satu materi. Untuk Siswa, materi ini dicatat sebagai sudah dibuka.
     *
     * Materi pertama setiap kelas terbuka sebagai cuplikan gratis; materi lainnya wajib login.
     * Tamu diarahkan ke halaman login, lalu dikembalikan ke materi ini setelah berhasil masuk.
     */
    public function content(Request $request, Course $course, Content $content): View|RedirectResponse
    {
        $course->load('user', 'contents');

        $isPreview = $course->contents->first()?->is($content);

        if (! $request->user() && ! $isPreview) {
            return redirect()->guest(route('login'))
                ->with('status', 'Masuk untuk membuka materi ini. Belum punya akun? Daftar gratis, lalu kamu akan langsung kembali ke materi ini.');
        }

        if ($request->user()?->isSiswa()) {
            $request->user()->viewedContents()->syncWithoutDetaching([
                $content->id => ['accessed_at' => now()],
            ]);
        }

        // Urutan materi mengikuti urutan dibuat, untuk tombol "sebelumnya" & "berikutnya"
        $index = $course->contents->search(fn (Content $item) => $item->is($content));
        $position = $index + 1;
        $previous = $course->contents->get($index - 1);
        $next = $course->contents->get($index + 1);

        return view('courses.content', compact('course', 'content', 'position', 'previous', 'next', 'isPreview'));
    }
}
