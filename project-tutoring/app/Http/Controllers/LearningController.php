<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
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

        return view('content.index', compact('course'));
    }

    /**
     * Halaman belajar satu materi. Untuk Siswa, materi ini dicatat sebagai sudah dibuka.
     */
    public function content(Request $request, Course $course, Content $content): View
    {
        $course->load('user', 'contents');

        if ($request->user()?->isSiswa()) {
            $request->user()->viewedContents()->syncWithoutDetaching([
                $content->id => ['accessed_at' => now()],
            ]);
        }

        return view('content.show', compact('course', 'content'));
    }
}
