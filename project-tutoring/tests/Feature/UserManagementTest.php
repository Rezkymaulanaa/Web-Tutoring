<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_list(): void
    {
        $guru = User::factory()->guru()->create();
        $siswa = User::factory()->siswa()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('dashboard.users.index'))
            ->assertOk()
            ->assertSee($guru->nama)
            ->assertSee($siswa->nama);
    }

    public function test_guru_and_siswa_cannot_manage_users(): void
    {
        $this->actingAs(User::factory()->guru()->create())->get(route('dashboard.users.index'))->assertForbidden();
        $this->actingAs(User::factory()->siswa()->create())->get(route('dashboard.users.index'))->assertForbidden();
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('dashboard.users.create'))->assertOk();

        $this->actingAs($admin)->post(route('dashboard.users.store'), [
            'nama' => 'Guru Baru',
            'username' => 'gurubaru',
            'email' => 'guru.baru@gmail.com',
            'role' => 'Guru',
            'password' => 'rahasia123',
        ])->assertRedirect(route('dashboard.users.index'));

        $this->assertDatabaseHas('users', ['username' => 'gurubaru', 'role' => 'Guru']);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->siswa()->create(['email' => 'lama@gmail.com']);

        $this->actingAs($admin)->get(route('dashboard.users.edit', $user))->assertOk();

        $this->actingAs($admin)->put(route('dashboard.users.update', $user), [
            'nama' => 'Nama Diperbarui',
            'username' => $user->username,
            'email' => 'lama@gmail.com',
            'role' => 'Guru',
        ])->assertRedirect(route('dashboard.users.index'));

        $user->refresh();
        $this->assertSame('Nama Diperbarui', $user->nama);
        $this->assertSame(UserRole::Guru, $user->role);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->siswa()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('dashboard.users.destroy', $user))
            ->assertRedirect(route('dashboard.users.index'));

        $this->assertModelMissing($user);
    }
}
