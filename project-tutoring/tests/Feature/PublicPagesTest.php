<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_lists_courses(): void
    {
        $course = Course::factory()->create();

        $this->get('/')
            ->assertOk()
            ->assertSee($course->course);
    }

    public function test_courses_page_lists_courses_with_teacher_name(): void
    {
        $guru = User::factory()->guru()->create(['nama' => 'Budi Pengajar']);
        $course = Course::factory()->for($guru)->create();

        $this->get(route('courses.index'))
            ->assertOk()
            ->assertSee($course->course)
            ->assertSee('Budi Pengajar');
    }

    public function test_search_finds_course_by_name(): void
    {
        Course::factory()->create(['course' => 'Matematika Dasar']);
        Course::factory()->create(['course' => 'Biologi Sel']);

        $this->get(route('courses.index', ['search' => 'Matematika']))
            ->assertOk()
            ->assertSee('Matematika Dasar')
            ->assertDontSee('Biologi Sel');
    }

    public function test_search_finds_course_by_teacher_name(): void
    {
        $guru = User::factory()->guru()->create(['nama' => 'Siti Rahma']);
        Course::factory()->for($guru)->create(['course' => 'Kimia Organik']);

        $this->get(route('courses.index', ['search' => 'Siti']))
            ->assertOk()
            ->assertSee('Kimia Organik');
    }

    public function test_search_without_match_shows_empty_message(): void
    {
        Course::factory()->create();

        $this->get(route('courses.index', ['search' => 'tidak-ada-yang-cocok']))
            ->assertOk()
            ->assertSee('does not exist');
    }

    public function test_empty_search_shows_all_courses(): void
    {
        $course = Course::factory()->create();

        $this->get(route('courses.index', ['search' => '']))
            ->assertOk()
            ->assertSee($course->course);
    }
}
