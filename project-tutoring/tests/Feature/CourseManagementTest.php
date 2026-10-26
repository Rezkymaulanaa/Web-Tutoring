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

    public function test_siswa_cannot_open_dashboard(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('dashboard'))
            ->assertForbidden();
    }

    public function test_guest_is_redirected_to_login_from_dashboard(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_siswa_cannot_open_course_management(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('dashboard.courses.index'))
            ->assertForbidden();
    }

    public function test_guru_sees_only_own_courses_in_dashboard(): void
    {
        $own = Course::factory()->create(['course' => 'Course Milik Sendiri']);
        $other = Course::factory()->create(['course' => 'Course Guru Lain']);

        $this->actingAs($own->user)
            ->get(route('dashboard.courses.index'))
            ->assertOk()
            ->assertSee($own->course)
            ->assertDontSee($other->course);
    }

    public function test_admin_sees_all_courses_in_dashboard(): void
    {
        $courses = Course::factory()->count(2)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('dashboard.courses.index'))
            ->assertOk()
            ->assertSee($courses[0]->course)
            ->assertSee($courses[1]->course);
    }

    public function test_guru_can_create_course(): void
    {
        $guru = User::factory()->guru()->create();

        $this->actingAs($guru)->get(route('dashboard.courses.create'))->assertOk();

        $this->actingAs($guru)->post(route('dashboard.courses.store'), [
            'course' => 'Fisika Dasar',
            'deskripsi' => 'Belajar hukum Newton.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ])->assertRedirect(route('dashboard.courses.index'));

        $this->assertDatabaseHas('courses', [
            'course' => 'Fisika Dasar',
            'user_id' => $guru->id,
        ]);
    }

    public function test_course_end_date_must_be_after_start_date(): void
    {
        $this->actingAs(User::factory()->guru()->create())->post(route('dashboard.courses.store'), [
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
            ->get(route('dashboard.courses.edit', $course))
            ->assertOk();

        $this->actingAs($guru)->put(route('dashboard.courses.update', $course), [
            'course' => 'Nama Baru',
            'deskripsi' => 'Deskripsi baru.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ])->assertRedirect(route('dashboard.courses.index'));

        $this->assertSame('Nama Baru', $course->fresh()->course);
    }

    public function test_guru_cannot_open_edit_page_of_other_teachers_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->get(route('dashboard.courses.edit', $course))
            ->assertForbidden();
    }

    public function test_guru_can_delete_own_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs($course->user)
            ->delete(route('dashboard.courses.destroy', $course))
            ->assertRedirect(route('dashboard.courses.index'));

        $this->assertModelMissing($course);
    }

    public function test_guru_cannot_delete_other_teachers_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->delete(route('dashboard.courses.destroy', $course))
            ->assertForbidden();

        $this->assertModelExists($course);
    }

    public function test_admin_can_delete_any_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('dashboard.courses.destroy', $course));

        $this->assertModelMissing($course);
    }
}
