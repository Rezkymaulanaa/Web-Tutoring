<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_cannot_create_admin_account(): void
    {
        $this->post(route('register'), [
            'nama' => 'Penyusup',
            'username' => 'penyusup',
            'email' => 'penyusup@gmail.com',
            'role' => 'Admin',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['username' => 'penyusup']);
    }

    public function test_registration_requires_password_with_letters_and_numbers(): void
    {
        $this->post(route('register'), [
            'nama' => 'Andi',
            'username' => 'andisiswa',
            'email' => 'andi@gmail.com',
            'role' => 'Siswa',
            'password' => 'hanyahuruf',
        ])->assertSessionHasErrors('password');
    }

    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email_or_username' => $user->email, 'password' => 'salah']);
        }

        $this->post('/login', ['email_or_username' => $user->email, 'password' => 'password'])
            ->assertTooManyRequests();

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_protected_pages(): void
    {
        foreach (['profile.show', 'dashboard.courses.index', 'dashboard.contents.index', 'dashboard.users.index'] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }

    public function test_guru_cannot_update_other_teachers_course(): void
    {
        $course = Course::factory()->create(['course' => 'Asli']);

        $this->actingAs(User::factory()->guru()->create())->put(route('dashboard.courses.update', $course), [
            'course' => 'Diretas',
            'deskripsi' => 'Diretas.',
            'start_date' => '2024-01-01',
            'end_date' => '2024-02-01',
        ])->assertForbidden();

        $this->assertSame('Asli', $course->fresh()->course);
    }

    public function test_guru_cannot_update_other_teachers_content(): void
    {
        $content = Content::factory()->create(['title' => 'Asli']);

        $this->actingAs(User::factory()->guru()->create())->put(route('dashboard.contents.update', $content), [
            'title' => 'Diretas',
            'content' => 'Diretas.',
            'course_id' => $content->course_id,
        ])->assertForbidden();

        $this->assertSame('Asli', $content->fresh()->title);
    }

    public function test_guru_cannot_add_content_to_other_teachers_course(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->guru()->create())->post(route('dashboard.contents.store'), [
            'title' => 'Sisipan',
            'content' => 'Sisipan.',
            'course_id' => $course->id,
        ])->assertForbidden();

        $this->assertDatabaseMissing('contents', ['title' => 'Sisipan']);
    }

    public function test_guru_cannot_move_own_content_into_other_teachers_course(): void
    {
        $content = Content::factory()->create();
        $otherCourse = Course::factory()->create();

        $this->actingAs($content->course->user)->put(route('dashboard.contents.update', $content), [
            'title' => $content->title,
            'content' => $content->content,
            'course_id' => $otherCourse->id,
        ])->assertForbidden();

        $this->assertSame($content->course_id, $content->fresh()->course_id);
    }

    public function test_admin_editing_content_keeps_original_author(): void
    {
        $content = Content::factory()->create();
        $author = $content->user_id;

        $this->actingAs(User::factory()->admin()->create())->put(route('dashboard.contents.update', $content), [
            'title' => 'Diperbaiki Admin',
            'content' => 'Isi.',
            'course_id' => $content->course_id,
        ])->assertRedirect(route('dashboard.contents.index'));

        $this->assertSame($author, $content->fresh()->user_id);
    }

    public function test_content_link_must_be_a_youtube_video(): void
    {
        $course = Course::factory()->create();

        $this->actingAs($course->user)->post(route('dashboard.contents.store'), [
            'title' => 'Materi',
            'content' => 'Isi.',
            'youtube_link' => 'https://situs-phishing.example.com/login',
            'course_id' => $course->id,
        ])->assertSessionHasErrors('youtube_link');
    }

    public function test_youtube_watch_links_are_embedded(): void
    {
        $content = Content::factory()->create([
            'youtube_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ&t=10s',
        ]);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.contents.show', [$content->course, $content]))
            ->assertOk()
            ->assertSee('https://www.youtube.com/embed/dQw4w9WgXcQ');
    }

    public function test_admin_cannot_promote_user_to_admin(): void
    {
        $user = User::factory()->siswa()->create(['email' => 'siswa@gmail.com']);

        $this->actingAs(User::factory()->admin()->create())->put(route('dashboard.users.update', $user), [
            'nama' => $user->nama,
            'username' => $user->username,
            'email' => 'siswa@gmail.com',
            'role' => 'Admin',
        ])->assertSessionHasErrors('role');

        $this->assertSame(UserRole::Siswa, $user->fresh()->role);
    }

    public function test_admin_accounts_cannot_be_edited_or_deleted_from_user_management(): void
    {
        $otherAdmin = User::factory()->admin()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('dashboard.users.edit', $otherAdmin))->assertForbidden();
        $this->actingAs($admin)->delete(route('dashboard.users.destroy', $otherAdmin))->assertForbidden();
        $this->actingAs($admin)->delete(route('dashboard.users.destroy', $admin))->assertForbidden();

        $this->assertModelExists($otherAdmin);
        $this->assertModelExists($admin);
    }
}
