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
        $response = $this->withSession(['user_role' => 'admin'])->get('/');

        $response->assertStatus(200);
        $response->assertSee('Business Command Center');
        $response->assertSee('CEO Daily Brief');
    }

    public function test_the_ceo_dashboard_requires_an_admin_session(): void
    {
        $this->get('/')->assertRedirect('/login');

        $this->withSession(['user_role' => 'teacher'])
            ->get('/')
            ->assertRedirect('/schedule-editor');
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
