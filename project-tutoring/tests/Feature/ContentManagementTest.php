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
            ->get(route('content.show'))
            ->assertForbidden();
    }

    public function test_guru_can_view_content_list(): void
    {
        $content = Content::factory()->create();

        $this->actingAs($content->course->user)
            ->get(route('content.show'))
            ->assertOk()
            ->assertSee($content->title);
    }

    public function test_guru_can_create_content_for_own_course(): void
    {
        $course = Course::factory()->create();
        $guru = $course->user;

        $this->actingAs($guru)
            ->get(route('createContent'))
            ->assertOk()
            ->assertSee($course->course);

        $this->actingAs($guru)->post(route('storeContent'), [
            'title' => 'Hukum Newton 1',
            'content' => 'Benda diam tetap diam.',
            'link' => 'https://youtu.be/abcDEF12345',
            'course' => $course->id,
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

        $this->actingAs($course->user)->post(route('storeContent'), [
            'course' => $course->id,
        ])->assertSessionHasErrors(['title', 'content']);
    }

    public function test_guru_can_edit_own_content(): void
    {
        $content = Content::factory()->create();
        $guru = $content->course->user;

        $this->actingAs($guru)
            ->get(route('editContent', ['id' => $content->id]))
            ->assertOk();

        $this->actingAs($guru)->put(route('updateContent', ['id' => $content->id]), [
            'title' => 'Judul Baru',
            'content' => 'Isi baru.',
            'link' => 'https://youtu.be/xyzXYZ78901',
            'course' => $content->course_id,
        ])->assertRedirect(route('content.show'));

        $this->assertSame('Judul Baru', $content->fresh()->title);
    }

    public function test_guru_cannot_open_edit_page_of_other_teachers_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->get(route('editContent', ['id' => $content->id]))
            ->assertForbidden();
    }

    public function test_guru_can_delete_own_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs($content->course->user)
            ->delete(route('destroyContent', ['id' => $content->id]))
            ->assertRedirect(route('content.show'));

        $this->assertModelMissing($content);
    }

    public function test_guru_cannot_delete_other_teachers_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->guru()->create())
            ->delete(route('destroyContent', ['id' => $content->id]))
            ->assertForbidden();

        $this->assertModelExists($content);
    }

    public function test_admin_can_delete_any_content(): void
    {
        $content = Content::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('destroyContent', ['id' => $content->id]));

        $this->assertModelMissing($content);
    }
}
