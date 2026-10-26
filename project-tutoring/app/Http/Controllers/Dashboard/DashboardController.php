<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $stats = $user->isAdmin() ? [
            ['label' => 'Siswa', 'value' => User::where('role', UserRole::Siswa)->count()],
            ['label' => 'Guru', 'value' => User::where('role', UserRole::Guru)->count()],
            ['label' => 'Course', 'value' => Course::count()],
            ['label' => 'Materi', 'value' => Content::count()],
        ] : [
            ['label' => 'Course saya', 'value' => $user->courses()->count()],
            ['label' => 'Materi saya', 'value' => Content::whereIn('course_id', $user->courses()->select('id'))->count()],
            ['label' => 'Siswa yang belajar', 'value' => $this->studentCount($user)],
            ['label' => 'Materi dibuka', 'value' => $this->viewCount($user)],
        ];

        $recentCourses = Course::with('user')
            ->withCount('contents')
            ->when(! $user->isAdmin(), fn (Builder $query) => $query->whereBelongsTo($user))
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentCourses'));
    }

    /**
     * Jumlah siswa berbeda yang pernah membuka materi di course milik Guru ini.
     */
    private function studentCount(User $guru): int
    {
        return $this->historyOfCoursesOwnedBy($guru)->distinct()->count('content_history.user_id');
    }

    /**
     * Total berapa kali materi milik Guru ini dibuka siswa (satu kali per siswa per materi).
     */
    private function viewCount(User $guru): int
    {
        return $this->historyOfCoursesOwnedBy($guru)->count();
    }

    private function historyOfCoursesOwnedBy(User $guru): \Illuminate\Database\Query\Builder
    {
        return DB::table('content_history')
            ->join('contents', 'contents.id', '=', 'content_history.content_id')
            ->join('courses', 'courses.id', '=', 'contents.course_id')
            ->where('courses.user_id', $guru->id);
    }
}
