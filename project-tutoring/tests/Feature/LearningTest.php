<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_page_shows_description_teacher_and_material_list(): void
    {
        $content = Content::factory()->create();
        $course = $content->course;

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('content.index', $course))
            ->assertOk()
            ->assertSee($course->deskripsi)
            ->assertSee($course->user->nama)
            ->assertSee($content->title);
    }

    public function test_course_without_material_shows_empty_message(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('content.index', $course))
            ->assertOk()
            ->assertSee('belum memiliki materi');
    }

    public function test_unknown_course_returns_404(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get('/content/tidak-ada')
            ->assertNotFound();
    }

    public function test_material_page_shows_content_and_embedded_video(): void
    {
        $content = Content::factory()->create(['youtube_link' => 'https://youtu.be/abcDEF12345']);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('show.content', [$content->course, $content]))
            ->assertOk()
            ->assertSee($content->title)
            ->assertSee('https://www.youtube.com/embed/abcDEF12345');
    }

    public function test_opening_material_records_history_for_siswa(): void
    {
        $content = Content::factory()->create();
        $siswa = User::factory()->siswa()->create();
        $url = route('show.content', [$content->course, $content]);

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
            ->get(route('show.content', [$content->course, $content]))
            ->assertOk();

        $this->assertDatabaseCount('content_history', 0);
    }

    public function test_siswa_sees_progress_per_course(): void
    {
        $course = Course::factory()->create();
        [$opened] = Content::factory()->count(2)->for($course)->create(['user_id' => $course->user_id]);
        $siswa = User::factory()->siswa()->create();

        $this->actingAs($siswa)->get(route('show.content', [$course, $opened]));

        $this->actingAs($siswa)
            ->get(route('courses.index'))
            ->assertOk()
            ->assertSee('50%');
    }
}
