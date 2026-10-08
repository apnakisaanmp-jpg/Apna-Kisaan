<?php

namespace Database\Seeders;

use App\Models\CropCategory;
use App\Models\District;
use App\Models\Faq;
use App\Models\PriceTicker;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\User;
use App\Support\MadhyaPradeshDistricts;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@apnakisaan.in'], [
            'name' => 'Apna Kisaan Admin',
            'mobile' => '6265071588',
            'role' => 'superadmin',
            'password' => Hash::make('Admin@123456'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(['email' => 'user@apnakisaan.in'], [
            'name' => 'Demo Farmer',
            'mobile' => '9876543210',
            'role' => 'user',
            'password' => Hash::make('User@123456'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->seedSettings();
        $this->seedServices();
        $this->seedDistricts();
        $this->seedMarketData();
        $this->seedContent();
    }

    private function seedSettings(): void
    {
        $settings = [
            ['site_name', 'Apna Kisaan', 'general', 'text', 'Website Name'],
            ['site_tagline', 'आपकी फसल, आपका सही बाजार।', 'general', 'text', 'Tagline'],
            ['site_description', 'मध्य प्रदेश के किसानों के लिए मंडी भाव, सब्जी बाजार, किसान संपर्क और परिवहन सहायता।', 'general', 'textarea', 'Description'],
            ['logo', 'assets/images/अपना.किसान.png', 'general', 'image', 'Logo'],
            ['contact_phone', '+91 626 507 1588', 'contact', 'text', 'Phone'],
            ['contact_email', 'apnakisaan.mp@gmail.com', 'contact', 'text', 'Email'],
            ['contact_address', 'इंदौर, मध्य प्रदेश', 'contact', 'text', 'Address'],
            ['footer_about', 'अपना किसान किसानों को सही बाजार, उपयोगी जानकारी और भरोसेमंद सहायता से जोड़ता है।', 'footer', 'textarea', 'Footer About'],
            ['footer_copyright', '© 2026 अपना किसान। सर्वाधिकार सुरक्षित।', 'footer', 'text', 'Copyright'],
            ['default_meta_title', 'अपना किसान — मंडी भाव, किसान संपर्क और परिवहन सहायता', 'seo', 'text', 'Default Meta Title'],
            ['default_meta_desc', 'मध्य प्रदेश के किसानों के लिए मंडी भाव, सब्जी बाजार, किसान संपर्क और परिवहन सहायता।', 'seo', 'textarea', 'Default Meta Description'],
        ];

        foreach ($settings as [$key, $value, $group, $type, $label]) {
            Setting::updateOrCreate(['key' => $key], compact('value', 'group', 'type', 'label'));
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['title' => 'लाइव मंडी भाव', 'slug' => 'live-mandi-bhav', 'short_description' => 'सब्जी और फसल के ताजा बाजार भाव देखें।', 'description' => 'किसान सही समय पर सही मंडी चुन सके, इसके लिए प्रमुख फसलों और सब्जियों की कीमतें एक जगह उपलब्ध कराई जाती हैं।', 'icon' => 'fa-solid fa-chart-line', 'link_url' => '/mandi-bhav', 'link_text' => 'भाव देखें', 'sort_order' => 1, 'is_active' => true],
            ['title' => 'किसान और खरीदार संपर्क', 'slug' => 'farmer-buyer-connect', 'short_description' => 'किसानों और खरीदारों को सीधे जोड़ने की सुविधा।', 'description' => 'किसान अपनी फसल और खरीदार अपनी मांग दर्ज कर सकते हैं। टीम जानकारी की समीक्षा करके आगे संपर्क कर सकती है।', 'icon' => 'fa-solid fa-handshake', 'link_url' => '/farmer-connect', 'link_text' => 'पंजीकरण करें', 'sort_order' => 2, 'is_active' => true],
            ['title' => 'परिवहन सहायता', 'slug' => 'transport-support', 'short_description' => 'खेत से मंडी तक फसल पहुंचाने के लिए परिवहन अनुरोध।', 'description' => 'ट्रक, पिकअप और शीत परिवहन के लिए अनुरोध भेजें। उपलब्धता, वाहन और चालक की जानकारी की पुष्टि टीम से प्राप्त करें।', 'icon' => 'fa-solid fa-truck-moving', 'link_url' => '/transport', 'link_text' => 'अनुरोध भेजें', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }

    private function seedDistricts(): void
    {
        foreach (MadhyaPradeshDistricts::all() as $index => [$name, $nameEn, $slug, $region]) {
            District::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'name_en' => $nameEn,
                'region' => $region,
                'description' => "{$name} जिले की मंडी और बाजार जानकारी Apna Kisaan पर उपलब्ध है।",
                'market_info' => 'किसान अपनी फसल, मात्रा और संपर्क की जानकारी दर्ज करके खरीदारों से जुड़ने में सहायता पा सकते हैं।',
                'is_featured' => $index < 12,
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function seedMarketData(): void
    {
        foreach ([['टमाटर', 'Tomato', 1800, 'क्विंटल', 'up'], ['प्याज', 'Onion', 2200, 'क्विंटल', 'same'], ['आलू', 'Potato', 1500, 'क्विंटल', 'down'], ['सोयाबीन', 'Soybean', 4600, 'क्विंटल', 'up']] as $index => [$name, $en, $price, $unit, $trend]) {
            PriceTicker::updateOrCreate(['commodity_en' => $en], ['commodity_name' => $name, 'price' => $price, 'unit' => $unit, 'trend' => $trend, 'sort_order' => $index + 1, 'is_active' => true]);
        }

        foreach ([['सब्जियां', 'Vegetables', 'vegetables', '/vegetable-price', 'टमाटर, प्याज, आलू'], ['अनाज', 'Grains', 'grains', '/crop-price', 'गेहूं, मक्का, ज्वार'], ['दलहन', 'Pulses', 'pulses', '/crop-price', 'चना, मसूर, अरहर']] as [$name, $en, $slug, $url, $examples]) {
            CropCategory::updateOrCreate(['slug' => $slug], ['name' => $name, 'name_en' => $en, 'link_url' => $url, 'examples' => $examples, 'is_active' => true]);
        }
    }

    private function seedContent(): void
    {
        Faq::where('question', 'Transport booking कैसे confirm होगी?')->update(['question' => 'परिवहन अनुरोध की पुष्टि कैसे होगी?']);
        $faqs = [
            ['मंडी भाव कैसे अपडेट होते हैं?', 'भाव उपलब्ध बाजार डेटा स्रोत से लिए जाते हैं। हर भाव को खरीदने या बेचने से पहले संबंधित मंडी में सत्यापित करें।'],
            ['किसान पंजीकरण के बाद क्या होगा?', 'आपकी जानकारी हमारी टीम तक पहुंचेगी। सत्यापन और आगे की सहायता के लिए टीम आपके दिए मोबाइल नंबर पर संपर्क करेगी।'],
            ['परिवहन अनुरोध की पुष्टि कैसे होगी?', 'टीम उपलब्ध वाहन, तारीख और किराये की पुष्टि के लिए आपसे संपर्क करेगी। अनुरोध भेजना अपने-आप में पक्की बुकिंग नहीं है।'],
        ];

        foreach ($faqs as $index => [$question, $answer]) {
            Faq::updateOrCreate(['question' => $question], ['answer' => $answer, 'page' => 'general', 'sort_order' => $index + 1, 'is_active' => true]);
        }

        $seoPages = [
            'home' => ['अपना किसान — सही बाजार, सही जानकारी', 'मध्य प्रदेश के किसानों के लिए मंडी भाव, फसल जानकारी और परिवहन सहायता।'],
            'about' => ['अपना किसान के बारे में', 'मध्य प्रदेश के किसानों के लिए अपना किसान का उद्देश्य और सेवाएं।'],
            'services' => ['किसान सेवाएं — अपना किसान', 'मंडी भाव, किसान संपर्क और परिवहन सहायता की जानकारी।'],
            'contact' => ['संपर्क करें — अपना किसान', 'किसान सहायता के लिए अपना किसान टीम से संपर्क करें।'],
            'transport' => ['फसल परिवहन — अपना किसान', 'फसल परिवहन का अनुरोध भेजें और टीम से उपलब्धता की पुष्टि पाएं।'],
            'farmer-connect' => ['किसान और खरीदार पंजीकरण — अपना किसान', 'किसान या खरीदार के रूप में पंजीकरण करके अपना किसान से जुड़ें।'],
            'mandi-bhav' => ['आज का मंडी भाव — अपना किसान', 'मध्य प्रदेश के लिए उपलब्ध फसल और सब्जी बाजार भाव देखें।'],
        ];

        foreach ($seoPages as $page => [$title, $description]) {
            SeoMeta::updateOrCreate(['page_key' => $page], ['meta_title' => $title, 'meta_description' => $description, 'robots' => 'index,follow']);
        }

        Slider::where('title', 'Apna Kisaan Hero')->update(['title' => 'अपना किसान मुख्य बैनर']);
        Slider::updateOrCreate(['title' => 'अपना किसान मुख्य बैनर'], ['image' => 'assets/images/ChatGPT Image Sep 9, 2026, 12_15_42 AM.png', 'link_url' => '/', 'alt_text' => 'अपना किसान — किसानों के लिए बाजार की जानकारी', 'sort_order' => 1, 'is_active' => true]);
        TeamMember::updateOrCreate(['email' => 'apnakisaan.mp@gmail.com'], ['name' => 'अपना किसान टीम', 'designation' => 'किसान सहायता', 'bio' => 'किसानों को बाजार की जानकारी, खरीदार संपर्क और परिवहन सहायता से जोड़ने वाली टीम।', 'phone' => '+91 626 507 1588', 'is_active' => true]);
    }
}
