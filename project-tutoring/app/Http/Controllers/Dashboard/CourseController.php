<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Admin melihat semua course, Guru hanya course miliknya.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $courses = Course::with('user')
            ->withCount('contents')
            ->when(! $user->isAdmin(), fn (Builder $query) => $query->whereBelongsTo($user))
            ->latest()
            ->get();

        return view('dashboard.courses.index', compact('courses'));
    }

    public function create(): View
    {
        return view('dashboard.courses.create');
    }

    public function store(CourseRequest $request): RedirectResponse
    {
        $request->user()->courses()->create($request->validated());

        return redirect()->route('dashboard.courses.index')->with('success', 'Berhasil menambahkan course!');
    }

    public function edit(Course $course): View
    {
        Gate::authorize('update', $course);

        return view('dashboard.courses.edit', compact('course'));
    }

    public function update(CourseRequest $request, Course $course): RedirectResponse
    {
        Gate::authorize('update', $course);

        $course->update($request->validated());

        return redirect()->route('dashboard.courses.index')->with('success', 'Data course berhasil diperbarui');
    }

    public function destroy(Course $course): RedirectResponse
    {
        Gate::authorize('delete', $course);

        $course->delete();

        return redirect()->route('dashboard.courses.index')->with('success', 'Course berhasil dihapus');
    }
}
