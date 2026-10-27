<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserInterfaceTest extends TestCase
{
    use RefreshDatabase;

    // --- Aksesibilitas (WCAG 2.2) ---

    public function test_pages_declare_indonesian_language_and_have_skip_link(): void
    {
        foreach ([route('home'), route('courses.index'), route('login'), route('register')] as $url) {
            $this->get($url)
                ->assertSee('<html lang="id"', false)
                ->assertSee('href="#main"', false)
                ->assertSee('id="main"', false);
        }
    }

    public function test_each_page_has_its_own_title(): void
    {
        $course = Course::factory()->create(['course' => 'Fisika Dasar']);

        $this->get(route('courses.index'))->assertSee('<title>Daftar Kelas · EduLearn</title>', false);
        $this->get(route('login'))->assertSee('<title>Masuk · EduLearn</title>', false);
        $this->get(route('courses.show', $course))->assertSee('<title>Fisika Dasar · EduLearn</title>', false);
    }

    public function test_form_fields_have_labels_connected_to_inputs(): void
    {
        $this->get(route('login'))
            ->assertSee('for="email_or_username"', false)
            ->assertSee('id="email_or_username"', false)
            ->assertSee('for="password"', false)
            ->assertSee('id="password"', false);
    }

    public function test_validation_errors_are_announced_and_linked_to_their_field(): void
    {
        $this->from(route('register'))->post(route('register'), [])->assertRedirect(route('register'));

        $this->get(route('register'))
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('aria-describedby="nama-error"', false)
            ->assertSee('id="nama-error"', false)
            ->assertSee('Nama lengkap wajib diisi.');
    }

    public function test_video_iframe_has_a_title(): void
    {
        $content = Content::factory()->create(['title' => 'Hukum Newton']);

        $this->get(route('courses.contents.show', [$content->course, $content]))
            ->assertSee('title="Video materi: Hukum Newton"', false);
    }

    public function test_current_material_is_marked_in_navigation(): void
    {
        $content = Content::factory()->create();

        $this->get(route('courses.contents.show', [$content->course, $content]))
            ->assertSee('aria-current="page"', false);
    }

    public function test_no_assets_are_loaded_from_external_cdns(): void
    {
        $this->get(route('home'))
            ->assertDontSee('cdn.jsdelivr.net')
            ->assertDontSee('unpkg.com')
            ->assertDontSee('cdnjs.cloudflare.com');
    }

    public function test_error_pages_are_in_indonesian(): void
    {
        $this->get('/halaman-yang-tidak-ada')->assertNotFound()->assertSee('Halaman tidak ditemukan');

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('dashboard'))
            ->assertForbidden()
            ->assertSee('Akses ditolak');
    }

    // --- Fitur baru ---

    public function test_home_shows_real_statistics(): void
    {
        User::factory()->siswa()->count(3)->create();
        Content::factory()->count(2)->create(); // sekaligus membuat 2 guru

        $this->get(route('home'))
            ->assertSeeInOrder(['3', 'Siswa terdaftar'])
            ->assertSeeInOrder(['2', 'Guru bergabung'])
            ->assertSeeInOrder(['2', 'Materi tersedia']);
    }

    public function test_material_page_links_to_previous_and_next_material(): void
    {
        $course = Course::factory()->create();
        [$first, $second, $third] = Content::factory()->count(3)->for($course)->create(['user_id' => $course->user_id]);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.contents.show', [$course, $second]))
            ->assertOk()
            ->assertSee('Materi 2 dari 3')
            ->assertSee(route('courses.contents.show', [$course, $first]), false)
            ->assertSee(route('courses.contents.show', [$course, $third]), false);
    }

    public function test_dashboard_shows_real_statistics_for_guru(): void
    {
        $content = Content::factory()->create();
        $guru = $content->course->user;
        $siswa = User::factory()->siswa()->create();
        $this->actingAs($siswa)->get(route('courses.contents.show', [$content->course, $content]));

        $this->actingAs($guru)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeInOrder(['Course saya', '1'])
            ->assertSeeInOrder(['Siswa yang belajar', '1'])
            ->assertDontSee('Sales this week');
    }

    public function test_siswa_profile_lists_courses_in_progress(): void
    {
        $course = Course::factory()->create(['course' => 'Kimia Dasar']);
        [$opened] = Content::factory()->count(4)->for($course)->create(['user_id' => $course->user_id]);
        $siswa = User::factory()->siswa()->create();
        $this->actingAs($siswa)->get(route('courses.contents.show', [$course, $opened]));

        $this->actingAs($siswa)
            ->get(route('profile.show'))
            ->assertSee('Kelas yang sedang saya ikuti')
            ->assertSee('Kimia Dasar')
            ->assertSee('25%');
    }
}
