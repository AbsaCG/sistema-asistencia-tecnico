<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // seed roles and users
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_registration_and_login()
    {
        $email = 'newuser@example.com';
        $password = 'password';

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertRedirect('/dashboard');

        $this->assertDatabaseHas('users', ['email' => $email]);

        auth()->logout();

        $login = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $login->assertRedirect('/dashboard');
    }

    public function test_logout()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertRedirect('/');
    }
}
