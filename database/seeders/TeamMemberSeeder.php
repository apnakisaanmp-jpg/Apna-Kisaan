<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name'=>'हेमंत कच्छी','designation'=>'संस्थापक एवं CEO','bio'=>'मध्य प्रदेश के किसानों को डिजिटल जानकारी से जोड़ने का सपना लेकर अपना किसान की नींव रखी। इंदौर से संचालित यह मंच किसानों के जीवन में सकारात्मक बदलाव ला रहा है।','image'=>'assets/images/ChatGPT Image Sep 8, 2026, 11_56_46 PM.png','phone'=>'+91 626 507 1588','email'=>'apnakisaan.mp@gmail.com','sort_order'=>1,'is_active'=>true],
            ['name'=>'कृषि सलाहकार','designation'=>'बाजार एवं फसल विश्लेषण','bio'=>'12 से अधिक जिलों में बाजार का गहरा अनुभव। सब्जी की मांग, आपूर्ति और मूल्य रुझान का विश्लेषण करके किसानों को सही समय पर सही जानकारी देना हमारा काम है।','image'=>'assets/images/ChatGPT Image Sep 8, 2026, 11_31_14 PM.png','phone'=>null,'email'=>null,'sort_order'=>2,'is_active'=>true],
            ['name'=>'परिवहन एवं लॉजिस्टिक्स','designation'=>'सुरक्षित ढुलाई सेवा','bio'=>'खेत से मंडी तक सब्जियों की सुरक्षित और समय पर ढुलाई सुनिश्चित करना। सही वाहन, सही समय पर — ताकि किसान की मेहनत बेकार न जाए।','image'=>'assets/images/ChatGPT Image Sep 9, 2026, 12_22_32 AM.png','phone'=>null,'email'=>null,'sort_order'=>3,'is_active'=>true],
        ];
        foreach ($members as $m) {
            TeamMember::updateOrCreate(['name'=>$m['name']], $m);
        }
    }
}
