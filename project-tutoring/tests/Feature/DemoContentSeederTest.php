<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoContentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeds_courses_with_materials_for_existing_teachers(): void
    {
        $teachers = User::factory()->guru()->count(2)->create();

        $this->seed(DemoContentSeeder::class);

        $this->assertSame(6, Course::count());
        $this->assertSame(30, Content::count());
        $this->assertSame(0, User::where('role', UserRole::Guru)->count() - 2, 'Tidak boleh membuat guru baru');
        $this->assertEqualsCanonicalizing(
            $teachers->pluck('id')->all(),
            Course::distinct()->pluck('user_id')->all(),
        );
    }

    public function test_creates_demo_teachers_when_none_exist(): void
    {
        $this->seed(DemoContentSeeder::class);

        $this->assertSame(3, User::where('role', UserRole::Guru)->count());
        $this->assertSame(6, Course::count());
    }

    public function test_running_twice_does_not_duplicate_data(): void
    {
        $this->seed(DemoContentSeeder::class);
        $this->seed(DemoContentSeeder::class);

        $this->assertSame(6, Course::count());
        $this->assertSame(30, Content::count());
    }

    public function test_material_is_written_by_the_course_teacher_and_videos_are_valid(): void
    {
        $this->seed(DemoContentSeeder::class);

        Content::with('course')->get()->each(function (Content $content) {
            $this->assertSame($content->course->user_id, $content->user_id);

            if ($content->youtube_link) {
                $this->assertMatchesRegularExpression(Content::YOUTUBE_PATTERN, $content->youtube_link);
                $this->assertNotNull($content->youtube_embed_url);
            }
        });

        $this->assertSame(10, Content::whereNotNull('youtube_link')->count());
    }

    public function test_seeded_pages_render(): void
    {
        $this->seed(DemoContentSeeder::class);
        $course = Course::where('course', 'Fisika: Gerak Lurus')->firstOrFail();
        $content = $course->contents->first();

        $this->get(route('courses.show', $course))->assertOk()->assertSee('Gerak Lurus Beraturan (GLB)');
        $this->get(route('courses.contents.show', [$course, $content]))
            ->assertOk()
            ->assertSee('Perpindahannya: √(4² + 3²) = √25 = 5 meter', false);
    }
}
