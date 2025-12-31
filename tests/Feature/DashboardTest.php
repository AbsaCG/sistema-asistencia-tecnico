<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class DashboardTest extends TestCase
{
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin role and user
        $adminRole = Role::where('slug', 'admin')->first() ?? Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
    }

    public function test_dashboard_returns_200_for_authenticated_user()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dashboard_shows_stats()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('stats.totalStudents')
            ->has('stats.presentToday')
            ->has('stats.absentToday')
            ->has('stats.totalCareers')
            ->has('stats.attendancePercentage')
        );
    }

    public function test_dashboard_includes_recent_activity()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertInertia(fn ($page) => $page
            ->has('recentActivity')
        );
    }

    public function test_dashboard_redirects_unauthenticated_user()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_dashboard_has_pending_justifications()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertInertia(fn ($page) => $page
            ->has('pendingJustifications')
        );
    }
}
