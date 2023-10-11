<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();
        // $this->withoutVite();
        $this->user = User::factory()->create();
    }

    public function test_Home_page_load_properly(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_page_display_properly()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_dashboard_page_display_properly()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_login_dashboard_page_has_not_data_in_the_table()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('No data available...');
    }

    public function test_login_work_perfectly()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('dashboard');
    }

    public function test_register_page_display_properly()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_register_user_sucessfully()
    {
        $user = [
            'name' => 'Fabien',
            'email' => 'fabien@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'isAdmin' => 0,
        ];
        $response = $this->post('/register', $user);
        $response->assertStatus(302);
        $response->assertRedirect('dashboard');

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);
    }

    public function test_unauthenticate_user_can_not_access_to_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    public function test_only_authenticate_user_can_access_to_dashboard()
    {
        $response = $this->actingAs($this->user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSuccessful();
    }

    public function test_invalid_login_credentials()
    {
        $user = User::factory()->create([
            'email' => 'fabien@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_email_required_work_perfectly()
    {
        $user = User::factory()->create([
            'email' => 'fabien@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['email' => 'The email field is required']);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_required_work_perfectly()
    {
        $user = User::factory()->create([
            'email' => 'fabien@example.com',
            'password' => bcrypt('password'),
        ]);
        $response = $this->post('/login', [
            'email' => 'fabien@example.com',
            'password' => '',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['password' => 'The password field is required.']);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_lenght_validation_name_required_and_password_match_work_properly()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'fabgmail.com',
            'password' => 'pass',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field must be a valid email address.',
            'password' => 'The password must be at least 8 characters.',
            'password' => 'The password field confirmation does not match.',
        ]);

    }
}
