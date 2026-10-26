<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductionReadinessTest extends TestCase
{
    use RefreshDatabase;

    // --- Akun Admin awal ---

    public function test_seeder_creates_admin_from_configuration(): void
    {
        config([
            'edulearn.admin.username' => 'kepala',
            'edulearn.admin.email' => 'kepala@sekolah.test',
            'edulearn.admin.password' => 'RahasiaKuat2026',
        ]);

        $this->seed();

        $admin = User::where('username', 'kepala')->firstOrFail();
        $this->assertSame(UserRole::Admin, $admin->role);
        $this->assertSame('kepala@sekolah.test', $admin->email);
        $this->assertTrue(Hash::check('RahasiaKuat2026', $admin->password));
    }

    public function test_seeder_never_uses_the_old_default_password(): void
    {
        config(['edulearn.admin.password' => null]);

        $this->seed();

        $admin = User::where('role', UserRole::Admin)->firstOrFail();
        $this->assertFalse(Hash::check('admin123', $admin->password));
    }

    public function test_running_seeder_twice_does_not_duplicate_or_reset_admin(): void
    {
        config(['edulearn.admin.password' => 'PasswordPertama1']);
        $this->seed();

        config(['edulearn.admin.password' => 'PasswordKedua2']);
        $this->seed();

        $this->assertSame(1, User::where('role', UserRole::Admin)->count());
        $this->assertTrue(Hash::check('PasswordPertama1', User::where('role', UserRole::Admin)->first()->password));
    }

    // --- Security header ---

    public function test_responses_include_security_headers(): void
    {
        $this->get(route('home'))
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy');
    }

    public function test_content_security_policy_is_sent_in_production(): void
    {
        $this->app['env'] = 'production';

        $csp = $this->get(route('home'))->headers->get('Content-Security-Policy');

        $this->assertNotNull($csp);
        $this->assertStringContainsString("default-src 'self'", $csp);
        $this->assertStringContainsString("frame-ancestors 'self'", $csp);
        $this->assertStringContainsString('https://www.youtube.com', $csp);
        $this->assertStringNotContainsString("script-src 'self' 'unsafe-inline'", $csp);
    }
}
