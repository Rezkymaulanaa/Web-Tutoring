<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        $contents = Content::with('course')->latest()->get();

        return view('dashboard.content.index', compact('contents'));
    }

    public function create(Request $request): View
    {
        $courses = $this->manageableCourses($request->user());

        return view('dashboard.content.create', compact('courses'));
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

        return view('dashboard.content.edit', compact('content', 'courses'));
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
