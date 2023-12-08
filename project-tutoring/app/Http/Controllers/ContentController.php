<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index($courseName) 
    {
        $course = Course::where('course', $courseName)->firstOrFail();
        // Lakukan operasi lain yang diperlukan untuk menampilkan konten

        $courseName = $course->course;
        $deskripsi = $course->deskripsi;
        $pengajar = $course->user->nama;
        $contents = Content::where('course_id', $course->id)->get(); // Mengambil konten untuk course yang dipilih

        return view('content.index', compact('courseName', 'deskripsi', 'contents', 'pengajar'));
    }

    public function showContent($courseName, $judulMateri)
    {
        $course = Course::where('course', $courseName)->firstOrFail();
        $contents = Content::where('course_id', $course->id)->get();
        $pengajar = $course->user->nama;

        if ($judulMateri) {
            $content = Content::where('course_id', $course->id)
                ->where('title', $judulMateri)
                ->firstOrFail();
        } else {
            // Jika tidak ada judulMateri yang diberikan, tampilkan materi pertama
            $content = $contents->first();
        }

        // Memeriksa apakah konten sudah ada dalam content_history untuk pengguna yang sedang mengaksesnya
        if (auth()->check() && auth()->user()->role === 'Siswa') {
            $userId = auth()->user()->id;

            $visitedContent = DB::table('content_history')
                ->where('user_id', $userId)
                ->where('content_id', $content->id)
                ->first();

            if (!$visitedContent) {
                // Jika konten belum ada dalam riwayat, tambahkan ke dalam tabel content_history dengan access_at saat ini
                DB::table('content_history')->insert([
                    'user_id' => $userId,
                    'content_id' => $content->id,
                    'accessed_at' => now()
                ]);
            } else {
                // Jika konten sudah ada dalam riwayat, perbarui access_at ke saat ini tanpa menghitung ulang persentase
                DB::table('content_history')
                    ->where('user_id', $userId)
                    ->where('content_id', $content->id)
                    ->update(['accessed_at' => now()]);
            }
        }

        // Ubah tautan singkat YouTube ke tautan lengkap untuk penggunaan di dalam iframe
        $youtubeLink = $content->youtube_link;
        $youtubeEmbedLink = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $youtubeLink);

        return view('content.show', compact('course', 'contents', 'content', 'youtubeEmbedLink', 'judulMateri', 'pengajar'));
    }

    public function tampil($courseName, $judulMateri)
    {
        $course = Course::where('course', $courseName)->firstOrFail();
        $content = Content::where('course_id', $course->id)->where('title', $judulMateri)->firstOrFail();
        $contents = Content::where('course_id', $course->id)->get();

        // Ubah tautan singkat YouTube ke tautan lengkap untuk penggunaan di dalam iframe
        $youtubeLink = $content->youtube_link;
        $youtubeEmbedLink = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/', $youtubeLink);

        return view('content.show', compact('course', 'contents', 'content', 'youtubeEmbedLink'));
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'link' => 'nullable|url',
            'course' => 'required|exists:courses,id'
        ]);

        // Periksa apakah 'link' atau 'youtube_link' diisi, lalu sesuaikan ke dalam $validatedData
        if ($request->has('link')) {
            $validatedData['youtube_link'] = $request->input('link');
        }

        // Tentukan 'course_id' berdasarkan input dari form
        $validatedData['course_id'] = $validatedData['course'];

        // Dapatkan ID pengguna yang sedang masuk
        $validatedData['user_id'] = Auth::id();

        // Buat konten baru dengan data yang sudah divalidasi
        Content::create($validatedData);

        // Redirect ke halaman yang sesuai setelah konten berhasil ditambahkan
        return redirect()->route('content.show', $validatedData['course_id'])
                        ->with('success', 'Konten berhasil ditambahkan');
    }

    public function edit(Request $request, $contentId) {
        $content = Content::findOrFail($contentId);
        $user = $request->user();
    
        // Mendapatkan daftar kursus yang dimiliki oleh pengguna yang sedang login
        $userCourses = $user->courses->pluck('id')->toArray();
    
        // Memuat konten hanya jika pengguna adalah admin atau memiliki akses ke kursus yang terkait dengan konten
        if ($user && ($user->isAdmin() || in_array($content->course_id, $userCourses))) {
            // Memuat daftar kursus yang dimiliki pengguna untuk opsi select
            $courses = Course::whereIn('id', $userCourses)->get();
            
            return view('dashboard.content.edit', compact('content', 'courses'));
        } else {
            return back()->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit konten ini.']);
        }
    }
    
    

    public function update(Request $request, $id)
    {
        $content = Content::find($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'link' => 'nullable|url',
            'course' => 'required|exists:courses,id'
        ]);

         // Periksa apakah 'link' atau 'youtube_link' diisi, lalu sesuaikan ke dalam $validatedData
         if ($request->has('link')) {
            $validatedData['youtube_link'] = $request->input('link');
        }

        // Tentukan 'course_id' berdasarkan input dari form
        $validatedData['course_id'] = $validatedData['course'];

        // Dapatkan ID pengguna yang sedang masuk
        $validatedData['user_id'] = Auth::id();

        $content->update($validatedData);

        return redirect()->route('content.show')->with('success', 'Konten berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
{
    $content = Content::find($id);
    $user = $request->user();

    // Check if the user is an admin or the content owner before deleting
    if ($user && ($user->isAdmin() || $user->courses->contains('id', $content->course->id))) {
        $content->delete();
        return redirect()->route('content.show')->with('success', 'Materi berhasil dihapus');
    } else {
        return back()->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus materi dari pengajar lain.']);
    }
}

}
