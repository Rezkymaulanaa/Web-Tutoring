<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view("dashboard.course.index", compact("courses"));
    }

    public function create()
    {
        return view('dashboard.course.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',         
        ]);

        $validatedData['user_id'] = Auth::id();

        Course::create($validatedData);

        return redirect('/dashboard/course')->with('success', 'Berhasil menambahkan course!');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('dashboard.course.show', compact('course'));
    }

    public function edit(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $user = $request->user();

        // Periksa apakah pengguna adalah admin atau guru yang membuat course
        if (!$user || !($user->isAdmin() || $course->user_id === $user->id)) {
            return back()->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit course dari pengajar lain.']);
        }

        return view('dashboard.course.edit', compact('course', 'user'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validatedData = $request->validate([
            'course' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $course->update($validatedData);

        return redirect('dashboard/course')->with('success', 'Data course berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $user = $request->user();

        // Periksa apakah pengguna adalah admin atau guru yang membuat course
        if (!$user || !($user->isAdmin() || $course->user_id === $user->id)) {
            return back()->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus course dari pengajar lain.']);
        }

        $course->delete();

        return redirect('/dashboard/course')->with('success', 'Course berhasil dihapus');
    }

    public function kelas()
    {
        // Mendapatkan semua course
        $courses = DB::table('courses')
            ->join('users', 'courses.user_id', '=', 'users.id')
            ->select('courses.*', 'users.nama as pengajar_nama')
            ->get();

        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Jika pengguna sedang login, hitung progressnya pada setiap course
        if ($user) {
            foreach ($courses as $course) {
                $completedContents = DB::table('content_history')
                ->join('contents', 'content_history.content_id', '=', 'contents.id')
                ->where('contents.course_id', $course->id)
                ->where('content_history.user_id', $user->id)
                ->count();

                $totalContents = DB::table('contents')
                ->where('course_id', $course->id)
                ->count();

                $progress = ($totalContents > 0) ? ($completedContents / $totalContents) * 100 : 0;
                $course->userProgress = round($progress);
            }
        }

        // Batasi deskripsi menjadi 20 kata
        $courses->each(function ($course) {
            $course->short_description = Str::limit($course->deskripsi, 200);
        });

        return view("kelas", compact("courses"));
    }


    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        if (empty($searchTerm)) {
            return redirect()->route('courses.index');
        }

        $courses = Course::join('users', 'courses.user_id', '=', 'users.id')
        ->where('courses.course', 'like', '%' . $searchTerm . '%')
        ->orWhere('users.nama', 'like', '%' . $searchTerm . '%')
        ->select('courses.*', 'users.nama as pengajar_nama')
        ->get();

        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Jika pengguna sedang login, hitung progressnya pada setiap course
        if ($user) {
            foreach ($courses as $course) {
                $completedContents = DB::table('content_history')
                ->join('contents', 'content_history.content_id', '=', 'contents.id')
                ->where('contents.course_id', $course->id)
                ->where('content_history.user_id', $user->id)
                ->count();

                $totalContents = DB::table('contents')
                ->where('course_id', $course->id)
                ->count();

                $progress = ($totalContents > 0) ? ($completedContents / $totalContents) * 100 : 0;
                $course->userProgress = round($progress);
            }
        }

        return view('kelas', compact('courses', 'searchTerm'));
    }

    public function populer()
    {
        // Mendapatkan semua course
        $courses = DB::table('courses')
            ->join('users', 'courses.user_id', '=', 'users.id')
            ->select('courses.*', 'users.nama as pengajar_nama')
            ->get();

        // Mendapatkan pengguna yang sedang login
        $user = auth()->user();

        // Jika pengguna sedang login, hitung progressnya pada setiap course
        if ($user) {
            foreach ($courses as $course) {
                $completedContents = DB::table('content_history')
                ->join('contents', 'content_history.content_id', '=', 'contents.id')
                ->where('contents.course_id', $course->id)
                ->where('content_history.user_id', $user->id)
                ->count();

                $totalContents = DB::table('contents')
                ->where('course_id', $course->id)
                ->count();

                $progress = ($totalContents > 0) ? ($completedContents / $totalContents) * 100 : 0;
                $course->userProgress = round($progress);
            }
        }

        // Batasi deskripsi menjadi 20 kata
        $courses->each(function ($course) {
            $course->short_description = Str::limit($course->deskripsi, 200);
        });

        return view("home", compact("courses"));
    }

}
