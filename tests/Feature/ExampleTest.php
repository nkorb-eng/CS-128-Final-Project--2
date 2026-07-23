<?php

namespace Tests\Feature;

use App\Models\Signup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_customer_can_sign_up_and_log_in_with_a_hashed_password(): void
    {
        $this->post(route('signup'), [
            'Username' => 'Test Guest',
            'Email' => 'guest@example.test',
            'Password' => 'correct horse battery staple',
            'Password_confirmation' => 'correct horse battery staple',
        ])->assertRedirect(route('home'))
            ->assertSessionHas('usermail', 'guest@example.test');

        $user = Signup::where('Email', 'guest@example.test')->firstOrFail();
        $this->assertTrue(Hash::check('correct horse battery staple', $user->Password));

        $this->post(route('logout'));

        $this->post(route('login.user'), [
            'Email' => 'guest@example.test',
            'Password' => 'correct horse battery staple',
        ])->assertRedirect(route('home'))
            ->assertSessionHas('usermail', 'guest@example.test');
    }

    public function test_google_login_routes_are_registered(): void
    {
        $this->assertNotSame('', route('google.redirect'));
        $this->assertNotSame('', route('google.callback'));
    }

    public function test_google_login_starts_only_from_its_configured_local_address(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect' => 'http://127.0.0.1:8000/auth/google/callback',
        ]);

        $this->get('http://127.0.0.1:8000/auth/google/redirect')
            ->assertRedirectContains('accounts.google.com');

        $this->get('http://hotel.test/auth/google/redirect')
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');
    }
}
