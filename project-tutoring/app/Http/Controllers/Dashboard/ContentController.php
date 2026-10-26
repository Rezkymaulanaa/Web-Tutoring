<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ContentController extends Controller
{
    /**
     * Admin melihat semua materi, Guru hanya materi di course miliknya.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $contents = Content::with('course')
            ->when(! $user->isAdmin(), fn (Builder $query) => $query->whereIn('course_id', $user->courses()->select('id')))
            ->latest()
            ->get();

        return view('dashboard.contents.index', compact('contents'));
    }

    public function create(Request $request): View
    {
        $courses = $this->manageableCourses($request->user());

        return view('dashboard.contents.create', compact('courses'));
    }

    public function store(ContentRequest $request): RedirectResponse
    {
        $request->user()->contents()->create($request->validated());

        return redirect()->route('dashboard.contents.index')->with('success', 'Konten berhasil ditambahkan');
    }

    public function edit(Request $request, Content $content): View
    {
        Gate::authorize('update', $content);

        $courses = $this->manageableCourses($request->user());

        return view('dashboard.contents.edit', compact('content', 'courses'));
    }

    public function update(ContentRequest $request, Content $content): RedirectResponse
    {
        Gate::authorize('update', $content);

        // user_id tidak diubah, supaya penulis asli materi tetap tercatat
        $content->update($request->validated());

        return redirect()->route('dashboard.contents.index')->with('success', 'Konten berhasil diperbarui');
    }

    public function destroy(Content $content): RedirectResponse
    {
        Gate::authorize('delete', $content);

        $content->delete();

        return redirect()->route('dashboard.contents.index')->with('success', 'Materi berhasil dihapus');
    }

    /**
     * Course yang bisa dipilih di form: Admin semua course, Guru hanya course miliknya.
     *
     * @return Collection<int, Course>
     */
    private function manageableCourses(User $user): Collection
    {
        return $user->isAdmin() ? Course::orderBy('course')->get() : $user->courses()->orderBy('course')->get();
    }
}
