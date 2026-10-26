<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContentController extends Controller
{
    public function index(Course $course)
    {
        $pengajar = $course->user->nama;
        $contents = $course->contents; // Mengambil konten untuk course yang dipilih

        return view('content.index', compact('course', 'contents', 'pengajar'));
    }

    public function showContent(Course $course, Content $content)
    {
        $contents = $course->contents;
        $pengajar = $course->user->nama;

        // Catat riwayat belajar Siswa: tambah baris baru, atau perbarui waktu akses jika sudah pernah dibuka
        if (auth()->check() && auth()->user()->role === 'Siswa') {
            DB::table('content_history')->updateOrInsert(
                ['user_id' => auth()->id(), 'content_id' => $content->id],
                ['accessed_at' => now()],
            );
        }

        $youtubeEmbedLink = $content->youtube_embed_url;

        return view('content.show', compact('course', 'contents', 'content', 'youtubeEmbedLink', 'pengajar'));
    }

    public function show()
    {
        $contents = Content::with('course')->get();
        return view('dashboard.content.index', compact('contents'));
    }

    public function create()
    {
        $courses = auth()->user()->courses;
        return view('dashboard.content.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->rules());

        // Materi hanya boleh ditambahkan ke course milik sendiri (kecuali Admin)
        Gate::authorize('update', Course::findOrFail($validatedData['course']));

        Content::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'youtube_link' => $validatedData['link'] ?? null,
            'course_id' => $validatedData['course'],
            'user_id' => Auth::id(),
        ]);

        // Redirect ke halaman yang sesuai setelah konten berhasil ditambahkan
        return redirect()->route('content.show')->with('success', 'Konten berhasil ditambahkan');
    }

    public function edit(Request $request, $contentId)
    {
        $content = Content::findOrFail($contentId);
        $user = $request->user();

        Gate::authorize('update', $content);

        // Pilihan course: Admin melihat semua course, Guru hanya course miliknya
        $courses = $user->isAdmin() ? Course::all() : $user->courses;

        return view('dashboard.content.edit', compact('content', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $content = Content::findOrFail($id);

        Gate::authorize('update', $content);

        $validatedData = $request->validate($this->rules());

        // Jika materi dipindah ke course lain, course tujuan juga harus milik sendiri
        Gate::authorize('update', Course::findOrFail($validatedData['course']));

        // user_id tidak diubah, supaya penulis asli materi tetap tercatat
        $content->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'youtube_link' => $validatedData['link'] ?? null,
            'course_id' => $validatedData['course'],
        ]);

        return redirect()->route('content.show')->with('success', 'Konten berhasil diperbarui');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        Gate::authorize('delete', $content);

        $content->delete();

        return redirect()->route('content.show')->with('success', 'Materi berhasil dihapus');
    }

    /**
     * Aturan validasi untuk menyimpan dan memperbarui materi.
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'link' => ['nullable', 'url', 'regex:'.Content::YOUTUBE_PATTERN],
            'course' => ['required', 'exists:courses,id'],
        ];
    }
}
