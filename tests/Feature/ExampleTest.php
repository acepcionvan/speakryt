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
        $this->get('/dashboard')->assertRedirect('/login');

        $this->withSession(['user_role' => 'teacher'])
            ->get('/dashboard')
            ->assertRedirect('/schedule-editor');
    }

    public function test_login_rejects_unknown_accounts(): void
    {
        $this->post('/login', [
            'email' => 'random@example.com',
            'password' => 'anything',
        ])->assertSessionHasErrors('email');
    }

    public function test_login_accepts_configured_admin_password(): void
    {
        putenv('SPEAKRYT_ADMIN_PASSWORD=SecureTestPassword123!');

        try {
            $this->post('/login', [
                'email' => 'vanacepcion@gmail.com',
                'password' => 'SecureTestPassword123!',
            ])
                ->assertRedirect('/dashboard')
                ->assertSessionHas('user_role', 'admin');
        } finally {
            putenv('SPEAKRYT_ADMIN_PASSWORD');
        }
    }

    public function test_user_management_requires_an_admin_session(): void
    {
        $this->get('/user-management')->assertRedirect('/login');

        $this->withSession(['user_role' => 'teacher'])
            ->get('/user-management')
            ->assertRedirect('/schedule-editor');

        $this->withSession(['user_role' => 'admin'])
            ->get('/user-management')
            ->assertOk()
            ->assertSee('User Accounts');
    }
}
