<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LearningTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_page_shows_description_teacher_and_material_list(): void
    {
        $content = Content::factory()->create();
        $course = $content->course;

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee($course->deskripsi)
            ->assertSee($course->user->nama)
            ->assertSee($content->title);
    }

    public function test_course_without_material_shows_empty_message(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.show', $course))
            ->assertOk()
            ->assertSee('belum memiliki materi');
    }

    public function test_unknown_course_returns_404(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get('/courses/tidak-ada')
            ->assertNotFound();
    }

    public function test_material_page_shows_content_and_embedded_video(): void
    {
        $content = Content::factory()->create(['youtube_link' => 'https://youtu.be/abcDEF12345']);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.contents.show', [$content->course, $content]))
            ->assertOk()
            ->assertSee($content->title)
            ->assertSee('https://www.youtube.com/embed/abcDEF12345');
    }

    public function test_opening_material_records_history_for_siswa(): void
    {
        $content = Content::factory()->create();
        $siswa = User::factory()->siswa()->create();
        $url = route('courses.contents.show', [$content->course, $content]);

        $this->actingAs($siswa)->get($url)->assertOk();
        $this->actingAs($siswa)->get($url)->assertOk();

        // Membuka materi yang sama dua kali tetap tercatat satu baris.
        $this->assertDatabaseCount('content_history', 1);
        $this->assertDatabaseHas('content_history', [
            'user_id' => $siswa->id,
            'content_id' => $content->id,
        ]);
    }

    public function test_opening_material_does_not_record_history_for_guru(): void
    {
        $content = Content::factory()->create();

        $this->actingAs($content->course->user)
            ->get(route('courses.contents.show', [$content->course, $content]))
            ->assertOk();

        $this->assertDatabaseCount('content_history', 0);
    }

    public function test_course_list_query_count_does_not_grow_with_number_of_courses(): void
    {
        $siswa = User::factory()->siswa()->create();
        $countQueries = function () use ($siswa): int {
            DB::flushQueryLog();
            DB::enableQueryLog();
            $this->actingAs($siswa)->get(route('courses.index'))->assertOk();

            return count(DB::getQueryLog());
        };

        Content::factory()->count(3)->create();
        $withThreeCourses = $countQueries();

        Content::factory()->count(10)->create();
        $withThirteenCourses = $countQueries();

        $this->assertSame($withThreeCourses, $withThirteenCourses);
    }

    public function test_siswa_sees_progress_per_course(): void
    {
        $course = Course::factory()->create();
        [$opened] = Content::factory()->count(2)->for($course)->create(['user_id' => $course->user_id]);
        $siswa = User::factory()->siswa()->create();

        $this->actingAs($siswa)->get(route('courses.contents.show', [$course, $opened]));

        $this->actingAs($siswa)
            ->get(route('courses.index'))
            ->assertOk()
            ->assertSee('50%');
    }
}
