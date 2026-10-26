<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_render_for_guests(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('register'))->assertOk();
    }

    public function test_guest_can_register_as_siswa(): void
    {
        // Validasi email memakai rule email:dns, jadi domainnya harus bisa di-resolve.
        $response = $this->post(route('register'), [
            'nama' => 'Andi Siswa',
            'username' => 'andisiswa',
            'email' => 'andi.siswa@gmail.com',
            'role' => 'Siswa',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect(route('login'))->assertSessionHas('success');

        $user = User::where('username', 'andisiswa')->first();
        $this->assertNotNull($user);
        $this->assertSame(UserRole::Siswa, $user->role);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    public function test_registration_rejects_duplicate_username(): void
    {
        User::factory()->create(['username' => 'sudahada']);

        $this->post(route('register'), [
            'nama' => 'Orang Lain',
            'username' => 'sudahada',
            'email' => 'orang.lain@gmail.com',
            'role' => 'Siswa',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('username');
    }

    public function test_user_can_login_with_email(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email_or_username' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_username(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email_or_username' => $user->username,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email_or_username' => $user->email,
            'password' => 'salah-password',
        ])->assertSessionHas('loginError');

        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_logged_in_user_cannot_open_register_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('register'))
            ->assertRedirect();
    }

    public function test_logged_in_user_can_view_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.show'))
            ->assertOk()
            ->assertSee($user->nama)
            ->assertSee($user->email);
    }
}
