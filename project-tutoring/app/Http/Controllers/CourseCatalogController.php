<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseCatalogController extends Controller
{
    /**
     * Daftar semua course, bisa dicari lewat ?search=nama course atau nama pengajar.
     */
    public function index(Request $request): View
    {
        $searchTerm = $request->query('search');

        $courses = Course::with('user')
            ->withProgressFor($request->user())
            ->search($searchTerm)
            ->latest()
            ->get();

        return view('kelas', compact('courses', 'searchTerm'));
    }
}
