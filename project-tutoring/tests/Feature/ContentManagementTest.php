<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_cannot_open_content_management(): void
    {
        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('dashboard.contents.index'))
            ->assertForbidden();
    }

    public function test_guru_can_view_content_list(): void
    {
        $content = Content::factory()->create();

        $this->actingAs($content->course->user)
            ->get(route('dashboard.contents.index'))
            ->assertOk()
            ->assertSee($content->title);
    }

    public function test_guru_can_create_content_for_own_course(): void
    {
        $course = Course::factory()->create();
        $guru = $course->user;

        $this->actingAs($guru)
            ->get(route('dashboard.contents.create'))
            ->assertOk()
            ->assertSee($course->course);

        $this->actingAs($guru)->post(route('dashboard.contents.store'), [
            'title' => 'Hukum Newton 1',
            'content' => 'Benda diam tetap diam.',
            'youtube_link' => 'https://youtu.be/abcDEF12345',
            'course_id' => $course->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('contents', [
            'title' => 'Hukum Newton 1',
            'course_id' => $course->id,
            'user_id' => $guru->id,
            'youtube_link' => 'https://youtu.be/abcDEF12345',
        ]);
    }

    public function test_content_requires_title_and_body(): void
    {
        $course = Course::factory()->create();

        $this->actingAs($course->user)->post(route('dashboard.contents.store'), [
            'course_id' => $course->id,
        ])->assertSessionHasErrors(['title', 'content']);
    }

    public function test_guru_can_edit_own_content(): void
    {
        $content = Content::factory()->create();
        $guru = $content->course->user;

        $this->actingAs($guru)
            ->get(route('dashboard.contents.edit', $content))
            ->assertOk();

        $this->actingAs($guru)->put(route('dashboard.contents.update', $content), [
            'title' => 'Judul Baru',
            'content' => 'Isi baru.',
            'youtube_link' => 'https://youtu.be/xyzXYZ78901',
            'course_id' => $content->course_id,
        ])->assertRedirect(route('dashboard.contents.index'));

        $this->assertSame('Judul Baru', $content->fresh()->title);
    }

    public function test_guru_cannot_open_edit_page_of_other_teachers_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->get(route('dashboard.contents.edit', $content))
            ->assertForbidden();
    }

    public function test_guru_can_delete_own_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs($content->course->user)
            ->delete(route('dashboard.contents.destroy', $content))
            ->assertRedirect(route('dashboard.contents.index'));

        $this->assertModelMissing($content);
    }

    public function test_guru_cannot_delete_other_teachers_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->delete(route('dashboard.contents.destroy', $content))
            ->assertForbidden();

        $this->assertModelExists($content);
    }

    public function test_admin_can_delete_any_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('dashboard.contents.destroy', $content));

        $this->assertModelMissing($content);
    }
}
