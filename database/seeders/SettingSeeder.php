<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',          'value' => 'अपना किसान',                      'group' => 'general', 'type' => 'text',  'label' => 'वेबसाइट का नाम'],
            ['key' => 'site_tagline',        'value' => 'आपकी फसल, आपका सही बाजार।',       'group' => 'general', 'type' => 'text',  'label' => 'टैगलाइन'],
            ['key' => 'site_description',    'value' => 'मध्य प्रदेश के किसानों के लिए सब्जी मंडी भाव, लाइव फसल भाव, कृषि जानकारी और परिवहन सहायता।', 'group' => 'general', 'type' => 'textarea', 'label' => 'साइट विवरण'],
            ['key' => 'logo',                'value' => 'assets/images/अपना.किसान.png',      'group' => 'general', 'type' => 'image', 'label' => 'लोगो'],
            ['key' => 'favicon',             'value' => 'assets/images/अपना.किसान.png',      'group' => 'general', 'type' => 'image', 'label' => 'फेविकॉन'],

            // Contact
            ['key' => 'contact_phone',       'value' => '+91 626 507 1588',                 'group' => 'contact', 'type' => 'text',  'label' => 'फोन नंबर'],
            ['key' => 'contact_email',       'value' => 'apnakisaan.mp@gmail.com',          'group' => 'contact', 'type' => 'text',  'label' => 'ईमेल'],
            ['key' => 'contact_whatsapp',    'value' => '916265071588',                     'group' => 'contact', 'type' => 'text',  'label' => 'WhatsApp नंबर'],
            ['key' => 'contact_address',     'value' => 'इंदौर, मध्य प्रदेश — 452001',     'group' => 'contact', 'type' => 'text',  'label' => 'पता'],
            ['key' => 'business_hours',      'value' => 'सोम–रवि, सुबह 8 से शाम 8 बजे',    'group' => 'contact', 'type' => 'text',  'label' => 'कार्य समय'],

            // Social
            ['key' => 'facebook_url',        'value' => '#',                                'group' => 'social',  'type' => 'text',  'label' => 'Facebook URL'],
            ['key' => 'instagram_url',       'value' => '#',                                'group' => 'social',  'type' => 'text',  'label' => 'Instagram URL'],
            ['key' => 'youtube_url',         'value' => '#',                                'group' => 'social',  'type' => 'text',  'label' => 'YouTube URL'],
            ['key' => 'twitter_url',         'value' => '#',                                'group' => 'social',  'type' => 'text',  'label' => 'Twitter URL'],

            // Footer
            ['key' => 'footer_about',        'value' => 'किसानों को सब्जी बाजार की जानकारी, भरोसेमंद परिवहन और समय पर भुगतान से जोड़ने का प्रयास।', 'group' => 'footer', 'type' => 'textarea', 'label' => 'Footer About Text'],
            ['key' => 'footer_copyright',    'value' => '© 2026 अपना किसान. सभी अधिकार सुरक्षित।', 'group' => 'footer', 'type' => 'text', 'label' => 'कॉपीराइट टेक्स्ट'],

            // SEO
            ['key' => 'default_meta_title',  'value' => 'अपना किसान — मंडी भाव, सब्जी बाजार और कृषि जानकारी | मध्य प्रदेश', 'group' => 'seo', 'type' => 'text', 'label' => 'Default Meta Title'],
            ['key' => 'default_meta_desc',   'value' => 'मध्य प्रदेश के किसानों के लिए सब्जी मंडी भाव, लाइव फसल भाव, कृषि जानकारी और परिवहन सहायता। 12+ जिलों में सेवा।', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Default Meta Description'],
            ['key' => 'google_analytics_id', 'value' => '',                                'group' => 'seo',     'type' => 'text',  'label' => 'Google Analytics ID'],

            // Stats (homepage stats strip)
            ['key' => 'stat_districts',      'value' => '12+',                             'group' => 'stats',   'type' => 'text',  'label' => 'जिले कवर'],
            ['key' => 'stat_mandis',         'value' => '50+',                             'group' => 'stats',   'type' => 'text',  'label' => 'सब्जी मंडियां'],
            ['key' => 'stat_farmers',        'value' => '5,000+',                          'group' => 'stats',   'type' => 'text',  'label' => 'किसान जुड़े'],
            ['key' => 'stat_service_days',   'value' => '365',                             'group' => 'stats',   'type' => 'text',  'label' => 'दिन सेवा'],

            // API
            ['key' => 'farmer_api_url',      'value' => 'https://farmer.in/api/open/prices.json', 'group' => 'api', 'type' => 'text', 'label' => 'Farmer.in API URL'],
            ['key' => 'api_cache_ttl',       'value' => '300',                             'group' => 'api',     'type' => 'text',  'label' => 'API Cache TTL (seconds)'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
