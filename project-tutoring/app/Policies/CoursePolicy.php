<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Admin boleh mengelola semua course, Guru hanya course miliknya sendiri.
     * Aturan yang sama dipakai untuk menambah atau memindahkan materi ke course tersebut.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->isAdmin() || $course->user_id === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $this->update($user, $course);
    }
}
