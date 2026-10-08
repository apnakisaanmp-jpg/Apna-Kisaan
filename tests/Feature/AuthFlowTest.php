<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_navigation_exposes_login_and_registration(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('register'));

        $this->get(route('register'))
            ->assertOk()
            ->assertSee(route('login'));
    }

    public function test_guest_can_register_and_is_signed_in(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'किसान',
            'email' => 'farmer@example.com',
            'mobile' => '9876543210',
            'password' => 'secure-pass-123',
            'password_confirmation' => 'secure-pass-123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'किसान',
            'email' => 'farmer@example.com',
            'role' => 'user',
        ]);
        $this->assertTrue(Hash::check('secure-pass-123', User::where('email', 'farmer@example.com')->firstOrFail()->password));
    }

    public function test_registered_user_can_log_in(): void
    {
        User::create([
            'name' => 'किसान',
            'email' => 'farmer@example.com',
            'password' => 'secure-pass-123',
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->post(route('login.store'), [
            'email' => 'farmer@example.com',
            'password' => 'secure-pass-123',
            'remember' => '1',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    public function test_registration_shows_hindi_password_confirmation_error(): void
    {
        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'किसान',
                'email' => 'farmer@example.com',
                'password' => 'secure-pass-123',
                'password_confirmation' => 'different-pass',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors([
                'password' => 'दोनों पासवर्ड एक जैसे नहीं हैं।',
            ]);

        $this->assertGuest();
    }
}
