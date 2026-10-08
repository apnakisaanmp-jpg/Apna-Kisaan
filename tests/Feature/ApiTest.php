<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_login_profile_and_logout_use_bearer_tokens(): void
    {
        $registration = $this->postJson('/api/register', [
            'name' => 'किसान',
            'email' => 'api-farmer@example.com',
            'mobile' => '9876543210',
            'password' => 'secure-pass-123',
            'password_confirmation' => 'secure-pass-123',
        ]);

        $registration->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', 'api-farmer@example.com')
            ->assertJsonMissingPath('data.user.password');
        $token = $registration->json('data.token');

        $this->getJson('/api/profile', ['Authorization' => 'Bearer '.$token])
            ->assertOk()
            ->assertJsonPath('data.name', 'किसान');

        $this->postJson('/api/logout', [], ['Authorization' => 'Bearer '.$token])
            ->assertOk();
        $this->getJson('/api/profile', ['Authorization' => 'Bearer '.$token])
            ->assertUnauthorized();
    }

    public function test_login_rejects_disabled_accounts(): void
    {
        User::create([
            'name' => 'Disabled farmer',
            'email' => 'disabled@example.com',
            'password' => 'secure-pass-123',
            'role' => 'user',
            'is_active' => false,
        ]);

        $this->postJson('/api/login', [
            'email' => 'disabled@example.com',
            'password' => 'secure-pass-123',
        ])->assertForbidden()
            ->assertJsonPath('success', false);
    }

    public function test_price_api_search_filter_sort_and_paginate_live_feed_data(): void
    {
        Cache::flush();
        Http::fake([
            'https://farmer.in/api/open/prices.json' => Http::response([
                'source' => 'test-feed',
                'attribution' => 'Test feed',
                'updated' => '2026-10-08T10:00:00Z',
                'commodities' => [
                    [
                        'name' => 'Wheat',
                        'hindi' => 'गेहूं',
                        'category' => 'cereal',
                        'min' => 2000,
                        'max' => 2500,
                        'price' => 2300,
                        'trend' => 'up',
                        'unit' => 'quintal',
                        'major_states' => ['Madhya Pradesh'],
                        'updated' => '2026-10-08',
                    ],
                    [
                        'name' => 'Tomato',
                        'hindi' => 'टमाटर',
                        'category' => 'vegetable',
                        'min' => 1000,
                        'max' => 1800,
                        'price' => 1500,
                        'trend' => 'down',
                        'unit' => 'quintal',
                        'major_states' => ['Madhya Pradesh'],
                        'updated' => '2026-10-08',
                    ],
                    [
                        'name' => 'Soybean',
                        'hindi' => 'सोयाबीन',
                        'category' => 'oilseed',
                        'min' => 4000,
                        'max' => 5000,
                        'price' => 4500,
                        'trend' => 'up',
                        'unit' => 'quintal',
                        'major_states' => ['Madhya Pradesh'],
                        'updated' => '2026-10-08',
                    ],
                ],
            ], 200),
        ]);

        $this->getJson('/api/mandi-bhav?q=wheat&is_mp=1&min_price=2000')
            ->assertOk()
            ->assertJsonPath('source', 'test-feed')
            ->assertJsonPath('meta.is_fallback', false)
            ->assertJsonPath('total', 1)
            ->assertJsonPath('records.0.commodity', 'गेहूं');

        $this->getJson('/api/prices/crop?trend=up&sort=modal_price&order=desc&per_page=1&page=1')
            ->assertOk()
            ->assertJsonPath('total', 2)
            ->assertJsonPath('meta.per_page', 1)
            ->assertJsonPath('meta.last_page', 2)
            ->assertJsonPath('records.0.commodity_en', 'Soybean');
    }

    public function test_price_api_validates_filter_and_page_size(): void
    {
        $this->getJson('/api/mandi-bhav?min_price=5000&max_price=1000')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['max_price']);

        $this->getJson('/api/mandi-bhav?per_page=101')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['per_page']);
    }

    public function test_public_form_apis_require_conditional_fields_and_accept_valid_buyer(): void
    {
        $this->postJson('/api/farmer-registrations', [
            'type' => 'farmer',
            'name' => 'किसान',
            'mobile' => '9876543210',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['district', 'main_crop']);

        $this->postJson('/api/farmer-registrations', [
            'type' => 'buyer',
            'name' => 'खरीदार',
            'mobile' => '9876543210',
            'business_type' => 'थोक व्यापारी',
            'city' => 'भोपाल',
            'required_crop' => 'टमाटर',
            'required_quantity' => 20,
        ])->assertCreated()
            ->assertJsonPath('data.type', 'buyer');
    }

    public function test_authenticated_user_can_create_and_list_only_their_inquiries(): void
    {
        $user = User::create([
            'name' => 'किसान',
            'email' => 'inquiry@example.com',
            'password' => 'secure-pass-123',
            'role' => 'user',
            'is_active' => true,
        ]);
        $token = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secure-pass-123',
        ])->assertOk()->json('data.token');

        $this->postJson('/api/my/inquiries', [
            'subject' => 'परिवहन',
            'message' => 'मेरी बुकिंग की जानकारी दें।',
        ], ['Authorization' => 'Bearer '.$token])
            ->assertCreated()
            ->assertJsonPath('data.subject', 'परिवहन');

        $this->getJson('/api/my/inquiries', ['Authorization' => 'Bearer '.$token])
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }
}
