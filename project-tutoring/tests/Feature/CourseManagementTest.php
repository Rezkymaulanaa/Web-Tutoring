<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_is_available_for_guru_and_admin(): void
    {
        $this->actingAs(User::factory()->guru()->create())->get(route('dashboard'))->assertOk();
        $this->actingAs(User::factory()->admin()->create())->get(route('dashboard'))->assertOk();
    }

    public function test_siswa_is_redirected_away_from_dashboard(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('dashboard'))
            ->assertRedirect('/');
    }

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_siswa_cannot_open_course_management(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('course.index'))
            ->assertForbidden();
    }

    public function test_guru_can_view_course_list(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->get(route('course.index'))
            ->assertOk()
            ->assertSee($course->course);
    }

    public function test_guru_can_create_course(): void
    {
        $guru = User::factory()->guru()->create();

        $this->actingAs($guru)->get(route('createCourse'))->assertOk();

        $this->actingAs($guru)->post(route('storeCourse'), [
            'course' => 'Fisika Dasar',
            'deskripsi' => 'Belajar hukum Newton.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ])->assertRedirect('/dashboard/course');

        $this->assertDatabaseHas('courses', [
            'course' => 'Fisika Dasar',
            'user_id' => $guru->id,
        ]);
    }

    public function test_course_end_date_must_be_after_start_date(): void
    {
        $this->actingAs(User::factory()->guru()->create())->post(route('storeCourse'), [
            'course' => 'Fisika Dasar',
            'deskripsi' => 'Belajar hukum Newton.',
            'start_date' => '2024-02-01',
            'end_date' => '2024-01-01',
        ])->assertSessionHasErrors('end_date');
    }

    public function test_guru_can_edit_own_course(): void
    {
        $course = Course::factory()->create();
        $guru = $course->user;

        $this->actingAs($guru)
            ->get(route('editCourse', $course))
            ->assertOk();

        $this->actingAs($guru)->put(route('updateCourse', $course), [
            'course' => 'Nama Baru',
            'deskripsi' => 'Deskripsi baru.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ])->assertRedirect('dashboard/course');

        $this->assertSame('Nama Baru', $course->fresh()->course);
    }

    public function test_guru_cannot_open_edit_page_of_other_teachers_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->get(route('editCourse', $course))
            ->assertForbidden();
    }

    public function test_guru_can_delete_own_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs($course->user)
            ->delete(route('destroyCourse', $course))
            ->assertRedirect('/dashboard/course');

        $this->assertModelMissing($course);
    }

    public function test_guru_cannot_delete_other_teachers_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->delete(route('destroyCourse', $course))
            ->assertForbidden();

        $this->assertModelExists($course);
    }

    public function test_admin_can_delete_any_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('destroyCourse', $course));

        $this->assertModelMissing($course);
    }
}
