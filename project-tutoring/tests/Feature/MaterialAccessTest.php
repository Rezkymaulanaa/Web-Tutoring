<?php

namespace Tests\Feature;

use App\Models\Content;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialAccessTest extends TestCase
{
    use RefreshDatabase;

    private Course $course;

    private Content $first;

    private Content $second;

    protected function setUp(): void
    {
        parent::setUp();

        $this->course = Course::factory()->create();
        [$this->first, $this->second] = Content::factory()->count(3)->for($this->course)->create(['user_id' => $this->course->user_id]);
    }

    public function test_guest_can_open_the_first_material_as_free_preview(): void
    {
        $this->get(route('courses.contents.show', [$this->course, $this->first]))
            ->assertOk()
            ->assertSee($this->first->title)
            ->assertSee('cuplikan gratis');
    }

    public function test_guest_opening_other_materials_directly_is_sent_to_login(): void
    {
        $this->get(route('courses.contents.show', [$this->course, $this->second]))
            ->assertRedirect(route('login'));

        $this->get(route('login'))->assertSee('Masuk untuk membuka materi ini');
    }

    public function test_after_login_guest_returns_to_the_material_they_wanted(): void
    {
        $siswa = User::factory()->siswa()->create();
        $url = route('courses.contents.show', [$this->course, $this->second]);

        $this->get($url)->assertRedirect(route('login'));

        $this->post('/login', ['email_or_username' => $siswa->email, 'password' => 'password'])
            ->assertRedirect($url);
    }

    public function test_logged_in_users_can_open_every_material(): void
    {
        foreach ([User::factory()->siswa()->create(), User::factory()->guru()->create(), User::factory()->admin()->create()] as $user) {
            $this->actingAs($user)
                ->get(route('courses.contents.show', [$this->course, $this->second]))
                ->assertOk()
                ->assertSee($this->second->title);
        }
    }

    public function test_course_page_tells_guests_which_materials_are_locked(): void
    {
        $this->get(route('courses.show', $this->course))
            ->assertOk()
            ->assertSee('Gratis')
            ->assertSee('perlu masuk', false);

        $this->actingAs(User::factory()->siswa()->create())
            ->get(route('courses.show', $this->course))
            ->assertDontSee('perlu masuk', false);
    }

    public function test_preview_page_invites_guest_to_continue_after_login(): void
    {
        $this->get(route('courses.contents.show', [$this->course, $this->first]))
            ->assertSee('Masuk untuk lanjut');
    }
}
