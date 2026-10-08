<?php

namespace Tests\Feature;

use App\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomeSliderImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_slider_uses_the_requested_image_for_all_six_slides(): void
    {
        Cache::flush();
        Http::fake([
            'https://farmer.in/api/open/prices.json' => Http::response([
                'commodities' => [],
                'source' => 'test-feed',
            ]),
        ]);

        Slider::create([
            'title' => 'Existing slide one',
            'image' => 'assets/images/old-slide-one.png',
            'link_url' => '/about',
            'alt_text' => 'पहली स्लाइड',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Slider::create([
            'title' => 'Existing slide two',
            'image' => 'assets/images/old-slide-two.png',
            'link_url' => '/services',
            'alt_text' => 'दूसरी स्लाइड',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertOk()
            ->assertSee('पहली स्लाइड')
            ->assertSee('दूसरी स्लाइड');

        $html = $response->getContent();
        $this->assertSame(6, substr_count($html, 'ChatGPT Image Sep 9, 2026, 12_15_07 AM.png'));
        $this->assertStringNotContainsString('old-slide-one.png', $html);
        $this->assertStringNotContainsString('old-slide-two.png', $html);
    }
}
