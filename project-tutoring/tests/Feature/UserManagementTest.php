<?php

namespace Tests\Feature;

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
            ->get(route('user'))
            ->assertOk()
            ->assertSee($guru->nama)
            ->assertSee($siswa->nama);
    }

    public function test_guru_and_siswa_cannot_manage_users(): void
    {
        $this->actingAs(User::factory()->guru()->create())->get(route('user'))->assertForbidden();
        $this->actingAs(User::factory()->siswa()->create())->get(route('user'))->assertForbidden();
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('create'))->assertOk();

        $this->actingAs($admin)->post(route('store'), [
            'nama' => 'Guru Baru',
            'username' => 'gurubaru',
            'email' => 'guru.baru@gmail.com',
            'role' => 'Guru',
            'password' => 'rahasia123',
        ])->assertRedirect('/dashboard/user');

        $this->assertDatabaseHas('users', ['username' => 'gurubaru', 'role' => 'Guru']);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->siswa()->create(['email' => 'lama@gmail.com']);

        $this->actingAs($admin)->get(route('edit', $user))->assertOk();

        $this->actingAs($admin)->put(route('update', $user), [
            'nama' => 'Nama Diperbarui',
            'username' => $user->username,
            'email' => 'lama@gmail.com',
            'role' => 'Guru',
        ])->assertRedirect('/dashboard/user');

        $user->refresh();
        $this->assertSame('Nama Diperbarui', $user->nama);
        $this->assertSame('Guru', $user->role);
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->siswa()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->delete(route('destroy', $user))
            ->assertRedirect('/dashboard/user');

        $this->assertModelMissing($user);
    }
}
