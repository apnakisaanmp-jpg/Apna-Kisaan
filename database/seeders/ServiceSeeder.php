<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title'=>'सब्जी बाजार की जानकारी','slug'=>'sabji-bazar','short_description'=>'मध्य प्रदेश के 12 जिलों की सब्जी मंडी और बाजार की सटीक जानकारी।','description'=>'मध्य प्रदेश के 12 से अधिक जिलों की सब्जी मंडी और बाजार की विस्तृत जानकारी। दमोह से ग्वालियर, जबलपुर से रीवा — हर जिले की बाजार स्थिति जानें। सही समय पर सही बाजार चुनें और अपनी फसल का उचित मूल्य पाएं।','icon'=>'fa-solid fa-shop','icon_bg'=>'#dcfce7','icon_color'=>'#15803d','stripe_color'=>'#22c55e','link_url'=>'/services','link_text'=>'बाजार देखें','sort_order'=>1,'is_active'=>true],
            ['title'=>'लाइव मंडी भाव','slug'=>'live-mandi-bhav','short_description'=>'farmer.in API से प्राप्त ताज़ा मंडी भाव — सब्जी और फसल दोनों।','description'=>'farmer.in API के माध्यम से मध्य प्रदेश की सभी प्रमुख सब्जियों और फसलों के ताज़ा मंडी भाव। न्यूनतम, अधिकतम और मोडल मूल्य एक ही जगह — हर दिन अपडेट। सही जानकारी से सही निर्णय लें।','icon'=>'fa-solid fa-chart-line','icon_bg'=>'#fef9c3','icon_color'=>'#ca8a04','stripe_color'=>'#f59e0b','link_url'=>'/mandi-bhav','link_text'=>'भाव देखें','sort_order'=>2,'is_active'=>true],
            ['title'=>'परिवहन सहायता','slug'=>'parivahan-sahayata','short_description'=>'सब्जियों को एक स्थान से दूसरे स्थान पर सुरक्षित पहुंचाने की बेहतर व्यवस्था।','description'=>'अपनी सब्जियों को खेत से मंडी तक और एक जिले से दूसरे जिले तक पहुंचाने की सुविधा। भरोसेमंद परिवहन, समय पर भुगतान और व्यक्तिगत सहायता। ट्रक, पिकअप और कोल्ड ट्रांसपोर्ट सेवा उपलब्ध।','icon'=>'fa-solid fa-truck-moving','icon_bg'=>'#fff7ed','icon_color'=>'#ea580c','stripe_color'=>'#f97316','link_url'=>'/transport','link_text'=>'संपर्क करें','sort_order'=>3,'is_active'=>true],
        ];
        foreach ($services as $s) {
            Service::updateOrCreate(['slug'=>$s['slug']], $s);
        }
    }
}
