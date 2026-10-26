<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BugFixTest extends TestCase
{
    use RefreshDatabase;

    // --- Database: foreign key & unique index ---

    public function test_course_with_learning_history_can_be_deleted(): void
    {
        $content = Content::factory()->create();
        $this->openMaterial(User::factory()->siswa()->create(), $content);

        $this->actingAs($content->course->user)
            ->delete(route('dashboard.courses.destroy', $content->course))
            ->assertRedirect(route('dashboard.courses.index'));

        $this->assertModelMissing($content->course);
        $this->assertDatabaseCount('content_history', 0);
    }

    public function test_siswa_with_learning_history_can_be_deleted(): void
    {
        $siswa = User::factory()->siswa()->create();
        $this->openMaterial($siswa, Content::factory()->create());

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('dashboard.users.destroy', $siswa))
            ->assertRedirect(route('dashboard.users.index'));

        $this->assertModelMissing($siswa);
    }

    public function test_guru_who_still_owns_courses_is_not_deleted(): void
    {
        $course = Course::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('dashboard.users.destroy', $course->user))
            ->assertSessionHasErrors('error');

        $this->assertModelExists($course->user);
    }

    public function test_username_is_unique_in_database(): void
    {
        User::factory()->create(['username' => 'kembar']);

        $this->expectException(UniqueConstraintViolationException::class);
        User::factory()->create(['username' => 'kembar']);
    }

    public function test_learning_history_is_unique_per_user_and_content(): void
    {
        $content = Content::factory()->create();
        $siswa = User::factory()->siswa()->create();
        $row = ['user_id' => $siswa->id, 'content_id' => $content->id, 'accessed_at' => now()];
        DB::table('content_history')->insert($row);

        $this->expectException(UniqueConstraintViolationException::class);
        DB::table('content_history')->insert($row);
    }

    // --- URL memakai slug ---

    public function test_course_and_material_urls_use_slugs(): void
    {
        $course = Course::factory()->create(['course' => 'Matematika Dasar']);
        $content = Content::factory()->for($course)->create([
            'user_id' => $course->user_id,
            'title' => 'Bab 1: Bilangan Bulat',
        ]);

        $this->assertSame(url('/courses/matematika-dasar'), route('courses.show', $course));
        $this->assertSame(
            url('/courses/matematika-dasar/bab-1-bilangan-bulat'),
            route('courses.contents.show', [$course, $content]),
        );

        $siswa = User::factory()->siswa()->create();
        $this->actingAs($siswa)->get('/courses/matematika-dasar')->assertOk()->assertSee('Bab 1: Bilangan Bulat');
        $this->actingAs($siswa)->get('/courses/matematika-dasar/bab-1-bilangan-bulat')->assertOk();
    }

    public function test_courses_with_same_name_get_different_slugs(): void
    {
        $first = Course::factory()->create(['course' => 'Biologi']);
        $second = Course::factory()->create(['course' => 'Biologi']);

        $this->assertSame('biologi', $first->slug);
        $this->assertSame('biologi-2', $second->slug);
    }

    public function test_same_material_title_is_allowed_in_different_courses(): void
    {
        $a = Content::factory()->create(['title' => 'Pengenalan']);
        $b = Content::factory()->create(['title' => 'Pengenalan']);

        $this->assertSame('pengenalan', $a->slug);
        $this->assertSame('pengenalan', $b->slug);
    }

    public function test_material_from_another_course_is_not_found(): void
    {
        $content = Content::factory()->create();
        $otherCourse = Course::factory()->create();

        $this->actingAs(User::factory()->siswa()->create())
            ->get("/courses/{$otherCourse->slug}/{$content->slug}")
            ->assertNotFound();
    }

    public function test_renaming_course_updates_its_slug(): void
    {
        $course = Course::factory()->create(['course' => 'Nama Lama']);

        $course->update(['course' => 'Nama Baru']);

        $this->assertSame('nama-baru', $course->fresh()->slug);
    }

    // --- Halaman & form ---

    public function test_pages_start_with_doctype(): void
    {
        $content = Content::factory()->create();
        $siswa = User::factory()->siswa()->create();

        foreach ([route('login'), route('register')] as $url) {
            $this->assertStringStartsWith('<!DOCTYPE html>', ltrim($this->get($url)->getContent()), $url);
        }

        foreach ([route('profile.show'), route('courses.show', $content->course), route('courses.contents.show', [$content->course, $content])] as $url) {
            $this->assertStringStartsWith('<!DOCTYPE html>', ltrim($this->actingAs($siswa)->get($url)->getContent()), $url);
        }
    }

    public function test_login_form_has_no_fake_social_login_buttons(): void
    {
        $this->get(route('login'))->assertDontSee('Or With')->assertDontSee('Google');
        $this->get(route('register'))->assertDontSee('Or With')->assertDontSee('Google');
    }

    public function test_remember_me_keeps_user_logged_in(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email_or_username' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ])->assertCookie(Auth::guard()->getRecallerName());
    }

    public function test_material_without_video_can_be_saved(): void
    {
        $course = Course::factory()->create();

        $this->actingAs($course->user)
            ->get(route('dashboard.contents.create'))
            ->assertDontSee('id="link" placeholder="Masukkan link youtube" autocomplete="off" required', false);

        $this->actingAs($course->user)->post(route('dashboard.contents.store'), [
            'title' => 'Tanpa Video',
            'content' => 'Hanya teks.',
            'course_id' => $course->id,
        ])->assertRedirect(route('dashboard.contents.index'));

        $this->assertDatabaseHas('contents', ['title' => 'Tanpa Video', 'youtube_link' => null]);
    }

    public function test_material_text_keeps_line_breaks(): void
    {
        $content = Content::factory()->create(['content' => "Baris pertama\nBaris kedua"]);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.contents.show', [$content->course, $content]))
            ->assertSee('Baris pertama<br />', false);
    }

    public function test_dashboard_does_not_reference_missing_files(): void
    {
        $this->actingAs(User::factory()->guru()->create())
            ->get(route('dashboard'))
            ->assertDontSee('/css/dashboard.css')
            ->assertDontSee('/js/dashboard.js')
            ->assertDontSee('color-modes.js');
    }

    private function openMaterial(User $user, Content $content): void
    {
        $this->actingAs($user)->get(route('courses.contents.show', [$content->course, $content]))->assertOk();
    }
}
