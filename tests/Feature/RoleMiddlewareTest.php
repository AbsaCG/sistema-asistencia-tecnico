<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_admin_can_access_settings()
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $this->actingAs($admin);

        $response = $this->get('/settings/system');
        $response->assertStatus(200);
    }

    public function test_teacher_cannot_access_settings()
    {
        $teacher = User::where('email', 'ana@example.com')->first();
        $this->actingAs($teacher);

        $response = $this->get('/settings/system');
        $response->assertStatus(403);
    }

    public function test_teacher_can_access_attendance()
    {
        $teacher = User::where('email', 'ana@example.com')->first();
        $this->actingAs($teacher);

        $response = $this->get('/attendance');
        $response->assertStatus(200);
    }

    public function test_parent_cannot_access_students()
    {
        $parent = User::where('email', 'padre@example.com')->first();
        $this->actingAs($parent);

        $response = $this->get('/students');
        $response->assertStatus(403);
    }
}
