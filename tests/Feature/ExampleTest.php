<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Master English, Without the Premium Price');
        $response->assertSee('Personalized English Lessons');
    }

    public function test_the_admin_dashboard_returns_a_successful_response_for_admins(): void
    {
        $response = $this->withSession(['user_role' => 'admin'])->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Business Command Center');
        $response->assertSee('CEO Daily Brief');
    }

    public function test_the_ceo_dashboard_requires_an_admin_session(): void
    {
        $this->get('/dashboard')->assertRedirect('/portal/login');

        $this->withSession(['user_role' => 'teacher'])
            ->get('/dashboard')
            ->assertRedirect('/portal/dashboard');
    }

    public function test_old_login_route_redirects_to_student_login(): void
    {
        $this->get('/login')->assertRedirect('/students/login');
    }

    public function test_portal_login_rejects_unknown_accounts(): void
    {
        $this->post('/portal/login', [
            'email' => 'random@example.com',
            'password' => 'anything',
        ])->assertSessionHasErrors('email');
    }

    public function test_portal_login_accepts_configured_admin_password(): void
    {
        putenv('SPEAKRYT_ADMIN_PASSWORD=SecureTestPassword123!');

        try {
            $this->post('/portal/login', [
                'email' => 'vanacepcion@gmail.com',
                'password' => 'SecureTestPassword123!',
            ])
                ->assertRedirect('/dashboard')
                ->assertSessionHas('user_role', 'admin');
        } finally {
            putenv('SPEAKRYT_ADMIN_PASSWORD');
        }
    }

    public function test_student_login_accepts_configured_student_password(): void
    {
        putenv('SPEAKRYT_STUDENT_PASSWORD=StudentPassword123!');

        try {
            $this->post('/students/login', [
                'email' => 'alex.thompson@email.com',
                'password' => 'StudentPassword123!',
            ])
                ->assertRedirect('/student/dashboard')
                ->assertSessionHas('user_role', 'student');
        } finally {
            putenv('SPEAKRYT_STUDENT_PASSWORD');
        }
    }

    public function test_student_dashboard_uses_student_login(): void
    {
        $this->get('/student/dashboard')->assertRedirect('/students/login');
    }

    public function test_user_management_requires_an_admin_session(): void
    {
        $this->get('/user-management')->assertRedirect('/portal/login');

        $this->withSession(['user_role' => 'teacher'])
            ->get('/user-management')
            ->assertRedirect('/portal/dashboard');

        $this->withSession(['user_role' => 'admin'])
            ->get('/user-management')
            ->assertOk()
            ->assertSee('User Accounts');
    }
}
