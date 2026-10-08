<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            ['title' => 'किसानों के लिए एक ही प्लेटफॉर्म',           'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_42 AM.png', 'link_url' => '/services',      'alt_text' => 'किसानों के लिए एक ही प्लेटफॉर्म | अपना किसान',                               'sort_order' => 1, 'is_active' => true],
            ['title' => 'मध्य प्रदेश का अपना किसान',                  'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_07 AM.png', 'link_url' => '/about',         'alt_text' => 'मध्य प्रदेश का अपना किसान — आपकी फसल, आपका सही बाजार',                       'sort_order' => 2, 'is_active' => true],
            ['title' => 'लाइव मंडी भाव',                               'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_22_32 AM.png', 'link_url' => '/mandi-bhav',    'alt_text' => 'अपना किसान — लाइव मंडी भाव',                                                   'sort_order' => 3, 'is_active' => true],
            ['title' => 'सब्जी बाजार जानकारी',                        'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_25_22 AM.png', 'link_url' => '/vegetable-price', 'alt_text' => 'अपना किसान — सब्जी बाजार',                                                   'sort_order' => 4, 'is_active' => true],
            ['title' => 'परिवहन सहायता',                              'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_27_30 AM.png', 'link_url' => '/transport',     'alt_text' => 'अपना किसान — परिवहन सेवा',                                                     'sort_order' => 5, 'is_active' => true],
            ['title' => 'किसान संपर्क',                               'image' => 'assets/images/ChatGPT Image Sep 8, 2026, 11_23_27 PM.png', 'link_url' => '/farmer-connect', 'alt_text' => 'अपना किसान — किसान और खेत',                                                   'sort_order' => 6, 'is_active' => true],
            ['title' => 'कृषि जानकारी',                               'image' => 'assets/images/ChatGPT Image Sep 8, 2026, 11_56_46 PM.png', 'link_url' => '/information',   'alt_text' => 'अपना किसान — सब्जी बाजार',                                                     'sort_order' => 7, 'is_active' => true],
            ['title' => 'आज ही जुड़ें',                                'image' => 'assets/images/ChatGPT Image Sep 8, 2026, 11_31_14 PM.png', 'link_url' => '/contact',       'alt_text' => 'अपना किसान — इंदौर, मध्य प्रदेश',                                             'sort_order' => 8, 'is_active' => true],
            ['title' => 'फसल भाव देखें',                              'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_42 AM.png', 'link_url' => '/crop-price',    'alt_text' => 'अपना किसान — फसल भाव मध्य प्रदेश',                                           'sort_order' => 9, 'is_active' => true],
            ['title' => 'सही बाजार से सही दाम',                       'image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_07 AM.png', 'link_url' => '/about',         'alt_text' => 'अपना किसान — मध्य प्रदेश के किसानों का भरोसेमंद साथी',                      'sort_order' => 10, 'is_active' => true],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(['title' => $slider['title']], $slider);
        }
    }
}
