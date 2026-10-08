<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            // Featured 12 districts with detailed info
            ['name' => 'दमोह',        'name_en' => 'Damoh',       'slug' => 'damoh',        'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g1', 'is_featured' => true, 'sort_order' => 1,
             'description' => 'दमोह मध्य प्रदेश के विंध्य क्षेत्र का एक प्रमुख जिला है। यहाँ की सब्जी मंडी में टमाटर, प्याज और आलू की आवक अच्छी रहती है। किसानों को उचित भाव मिलें इसके लिए अपना किसान यहाँ सक्रिय है।',
             'market_info' => 'दमोह सब्जी मंडी में सोमवार और गुरुवार को प्रमुख बोली होती है। यहाँ से भोपाल और जबलपुर को सब्जियां भेजी जाती हैं।'],
            ['name' => 'पन्ना',        'name_en' => 'Panna',       'slug' => 'panna',        'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g2', 'is_featured' => true, 'sort_order' => 2,
             'description' => 'पन्ना हीरे की खदानों के लिए प्रसिद्ध है किंतु यहाँ की कृषि भूमि भी उपजाऊ है। यहाँ के किसान मुख्य रूप से सब्जियां और दलहन उगाते हैं।',
             'market_info' => 'पन्ना मंडी में मंगलवार और शुक्रवार को बड़ी बोली होती है। आलू, टमाटर और मिर्च यहाँ की प्रमुख फसलें हैं।'],
            ['name' => 'छतरपुर',      'name_en' => 'Chhatarpur',  'slug' => 'chhatarpur',   'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g3', 'is_featured' => true, 'sort_order' => 3,
             'description' => 'छतरपुर जिला खजुराहो के पास स्थित है। यहाँ की जलवायु सब्जी उत्पादन के लिए अनुकूल है। रबी सीजन में आलू और सरसों की अच्छी पैदावार होती है।',
             'market_info' => 'छतरपुर मंडी में बुधवार और शनिवार को प्रमुख बोली लगती है।'],
            ['name' => 'भोपाल',       'name_en' => 'Bhopal',      'slug' => 'bhopal',       'region' => 'राजधानी · मालवा', 'gradient_class' => 'ak-dist-g4', 'is_featured' => true, 'sort_order' => 4,
             'description' => 'भोपाल मध्य प्रदेश की राजधानी है। यहाँ की करोंद मंडी MP की सबसे बड़ी थोक सब्जी मंडियों में से एक है। बड़ी आबादी के कारण यहाँ सब्जियों की मांग हमेशा अधिक रहती है।',
             'market_info' => 'करोंद मंडी भोपाल रोज सुबह 4 बजे से खुलती है। यहाँ देश के कोने-कोने से सब्जियां आती हैं।'],
            ['name' => 'राजगढ़',      'name_en' => 'Rajgarh',     'slug' => 'rajgarh',      'region' => 'मालवा क्षेत्र', 'gradient_class' => 'ak-dist-g5', 'is_featured' => true, 'sort_order' => 5,
             'description' => 'राजगढ़ मालवा क्षेत्र में स्थित है। यहाँ की मिट्टी गेहूं, सोयाबीन और सब्जी उत्पादन के लिए उपयुक्त है।',
             'market_info' => 'राजगढ़ में ब्यावरा मंडी प्रमुख है जहाँ सोयाबीन और गेहूं की बड़ी बोली होती है।'],
            ['name' => 'सागर',        'name_en' => 'Sagar',       'slug' => 'sagar',        'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g6', 'is_featured' => true, 'sort_order' => 6,
             'description' => 'सागर मध्य प्रदेश का एक बड़ा शहर और शैक्षणिक केंद्र है। यहाँ की मंडी में साल भर सब्जियों की अच्छी आवक रहती है।',
             'market_info' => 'सागर मंडी में रोज बोली होती है। यहाँ से रीवा और जबलपुर के व्यापारी खरीदारी करते हैं।'],
            ['name' => 'नरसिंहपुर',  'name_en' => 'Narsinghpur', 'slug' => 'narsinghpur',  'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g7', 'is_featured' => true, 'sort_order' => 7,
             'description' => 'नरसिंहपुर नर्मदा नदी के किनारे स्थित है। यहाँ की जमीन अत्यंत उपजाऊ है। गेहूं, चना और सब्जियों की बंपर पैदावार होती है।',
             'market_info' => 'नरसिंहपुर मंडी में गेहूं और चने की प्रमुख बोली होती है। सब्जियों के लिए मंगलवार विशेष बाजार लगता है।'],
            ['name' => 'जबलपुर',     'name_en' => 'Jabalpur',    'slug' => 'jabalpur',     'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g8', 'is_featured' => true, 'sort_order' => 8,
             'description' => 'जबलपुर महाकौशल का प्रमुख शहर और संभागीय मुख्यालय है। यहाँ की गढ़ा मंडी MP की सबसे पुरानी और बड़ी मंडियों में एक है।',
             'market_info' => 'जबलपुर की गढ़ा मंडी में रोज 200+ ट्रक सब्जियां आती हैं। यहाँ न्यूनतम और अधिकतम भाव में अच्छा अंतर मिलता है।'],
            ['name' => 'ग्वालियर',   'name_en' => 'Gwalior',     'slug' => 'gwalior',      'region' => 'चंबल क्षेत्र', 'gradient_class' => 'ak-dist-g9', 'is_featured' => true, 'sort_order' => 9,
             'description' => 'ग्वालियर चंबल क्षेत्र का सबसे बड़ा शहर है। यहाँ का महाराज बाड़ा मंडी क्षेत्र सब्जी व्यापार का केंद्र है।',
             'market_info' => 'ग्वालियर मंडी में उत्तर प्रदेश और राजस्थान से भी सब्जियां आती हैं। यहाँ आलू और प्याज का बड़ा कारोबार होता है।'],
            ['name' => 'बालाघाट',    'name_en' => 'Balaghat',    'slug' => 'balaghat',     'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g10', 'is_featured' => true, 'sort_order' => 10,
             'description' => 'बालाघाट जिला धान उत्पादन के लिए प्रसिद्ध है। यहाँ के किसान धान के साथ-साथ सब्जियां भी उगाते हैं।',
             'market_info' => 'बालाघाट में धान की प्रमुख बोली होती है। यहाँ की सब्जी मंडी में भिंडी और टमाटर की अच्छी पैदावार आती है।'],
            ['name' => 'रीवा',       'name_en' => 'Rewa',        'slug' => 'rewa',         'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g11', 'is_featured' => true, 'sort_order' => 11,
             'description' => 'रीवा विंध्य क्षेत्र का सबसे बड़ा शहर है। यहाँ की मंडी में मध्य प्रदेश और उत्तर प्रदेश के व्यापारी आते हैं।',
             'market_info' => 'रीवा मंडी में सोमवार और गुरुवार को बड़ी बोली होती है। यहाँ से इलाहाबाद और वाराणसी को सब्जियां जाती हैं।'],
            ['name' => 'टीकमगढ़',   'name_en' => 'Tikamgarh',   'slug' => 'tikamgarh',    'region' => 'विंध्य क्षेत्र', 'gradient_class' => 'ak-dist-g12', 'is_featured' => true, 'sort_order' => 12,
             'description' => 'टीकमगढ़ बुंदेलखंड क्षेत्र में स्थित है। यहाँ के किसान प्याज, टमाटर और दलहन की खेती करते हैं।',
             'market_info' => 'टीकमगढ़ मंडी में मंगलवार और शुक्रवार को प्रमुख बोली होती है।'],

            // Remaining 43 MP districts (non-featured, link to general service page)
            ['name' => 'आगर मालवा',  'name_en' => 'Agar Malwa',  'slug' => 'agar-malwa',   'region' => 'मालवा',   'gradient_class' => 'ak-dist-g1',  'is_featured' => false, 'sort_order' => 13, 'description' => 'आगर मालवा जिले में मालवा की उपजाऊ भूमि पर गेहूं और सोयाबीन की खेती होती है।'],
            ['name' => 'अलीराजपुर',  'name_en' => 'Alirajpur',   'slug' => 'alirajpur',    'region' => 'निमाड़', 'gradient_class' => 'ak-dist-g2',  'is_featured' => false, 'sort_order' => 14, 'description' => 'अलीराजपुर आदिवासी बहुल जिला है जहाँ मक्का और ज्वार की खेती होती है।'],
            ['name' => 'अनूपपुर',    'name_en' => 'Anuppur',     'slug' => 'anuppur',      'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g3',  'is_featured' => false, 'sort_order' => 15, 'description' => 'अनूपपुर विंध्य क्षेत्र में नर्मदा के उद्गम के पास स्थित है।'],
            ['name' => 'अशोकनगर',   'name_en' => 'Ashoknagar',  'slug' => 'ashoknagar',   'region' => 'बुंदेलखंड', 'gradient_class' => 'ak-dist-g4', 'is_featured' => false, 'sort_order' => 16],
            ['name' => 'बड़वानी',     'name_en' => 'Barwani',     'slug' => 'barwani',      'region' => 'निमाड़', 'gradient_class' => 'ak-dist-g5',  'is_featured' => false, 'sort_order' => 17],
            ['name' => 'बैतूल',       'name_en' => 'Betul',       'slug' => 'betul',        'region' => 'सतपुड़ा', 'gradient_class' => 'ak-dist-g6', 'is_featured' => false, 'sort_order' => 18],
            ['name' => 'भिंड',        'name_en' => 'Bhind',       'slug' => 'bhind',        'region' => 'चंबल',    'gradient_class' => 'ak-dist-g7',  'is_featured' => false, 'sort_order' => 19],
            ['name' => 'बुरहानपुर',  'name_en' => 'Burhanpur',   'slug' => 'burhanpur',    'region' => 'निमाड़', 'gradient_class' => 'ak-dist-g8',  'is_featured' => false, 'sort_order' => 20],
            ['name' => 'छिंदवाड़ा',  'name_en' => 'Chhindwara',  'slug' => 'chhindwara',   'region' => 'सतपुड़ा', 'gradient_class' => 'ak-dist-g9', 'is_featured' => false, 'sort_order' => 21],
            ['name' => 'दतिया',       'name_en' => 'Datia',       'slug' => 'datia',        'region' => 'बुंदेलखंड', 'gradient_class' => 'ak-dist-g10', 'is_featured' => false, 'sort_order' => 22],
            ['name' => 'देवास',       'name_en' => 'Dewas',       'slug' => 'dewas',        'region' => 'मालवा',   'gradient_class' => 'ak-dist-g11', 'is_featured' => false, 'sort_order' => 23],
            ['name' => 'धार',         'name_en' => 'Dhar',        'slug' => 'dhar',         'region' => 'मालवा',   'gradient_class' => 'ak-dist-g12', 'is_featured' => false, 'sort_order' => 24],
            ['name' => 'डिंडौरी',    'name_en' => 'Dindori',     'slug' => 'dindori',      'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g1',  'is_featured' => false, 'sort_order' => 25],
            ['name' => 'गुना',        'name_en' => 'Guna',        'slug' => 'guna',         'region' => 'मालवा',   'gradient_class' => 'ak-dist-g2',  'is_featured' => false, 'sort_order' => 26],
            ['name' => 'हरदा',        'name_en' => 'Harda',       'slug' => 'harda',        'region' => 'नर्मदा', 'gradient_class' => 'ak-dist-g3',  'is_featured' => false, 'sort_order' => 27],
            ['name' => 'इंदौर',      'name_en' => 'Indore',      'slug' => 'indore',       'region' => 'मालवा',   'gradient_class' => 'ak-dist-g4',  'is_featured' => false, 'sort_order' => 28],
            ['name' => 'झाबुआ',      'name_en' => 'Jhabua',      'slug' => 'jhabua',       'region' => 'मालवा',   'gradient_class' => 'ak-dist-g5',  'is_featured' => false, 'sort_order' => 29],
            ['name' => 'कटनी',       'name_en' => 'Katni',       'slug' => 'katni',        'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g6', 'is_featured' => false, 'sort_order' => 30],
            ['name' => 'खंडवा',      'name_en' => 'Khandwa',     'slug' => 'khandwa',      'region' => 'निमाड़', 'gradient_class' => 'ak-dist-g7',  'is_featured' => false, 'sort_order' => 31],
            ['name' => 'खरगोन',      'name_en' => 'Khargone',    'slug' => 'khargone',     'region' => 'निमाड़', 'gradient_class' => 'ak-dist-g8',  'is_featured' => false, 'sort_order' => 32],
            ['name' => 'मैहर',       'name_en' => 'Maihar',      'slug' => 'maihar',       'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g9',  'is_featured' => false, 'sort_order' => 33],
            ['name' => 'मंडला',      'name_en' => 'Mandla',      'slug' => 'mandla',       'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g10', 'is_featured' => false, 'sort_order' => 34],
            ['name' => 'मंदसौर',     'name_en' => 'Mandsaur',    'slug' => 'mandsaur',     'region' => 'मालवा',   'gradient_class' => 'ak-dist-g11', 'is_featured' => false, 'sort_order' => 35],
            ['name' => 'मऊगंज',      'name_en' => 'Mauganj',     'slug' => 'mauganj',      'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g12', 'is_featured' => false, 'sort_order' => 36],
            ['name' => 'मुरैना',     'name_en' => 'Morena',      'slug' => 'morena',       'region' => 'चंबल',    'gradient_class' => 'ak-dist-g1',  'is_featured' => false, 'sort_order' => 37],
            ['name' => 'नर्मदापुरम', 'name_en' => 'Narmadapuram', 'slug' => 'narmadapuram', 'region' => 'नर्मदा', 'gradient_class' => 'ak-dist-g2', 'is_featured' => false, 'sort_order' => 38],
            ['name' => 'नीमच',       'name_en' => 'Neemuch',     'slug' => 'neemuch',      'region' => 'मालवा',   'gradient_class' => 'ak-dist-g3',  'is_featured' => false, 'sort_order' => 39],
            ['name' => 'निवाड़ी',    'name_en' => 'Niwari',      'slug' => 'niwari',       'region' => 'बुंदेलखंड', 'gradient_class' => 'ak-dist-g4', 'is_featured' => false, 'sort_order' => 40],
            ['name' => 'पांढुर्णा',  'name_en' => 'Pandhurna',   'slug' => 'pandhurna',    'region' => 'सतपुड़ा', 'gradient_class' => 'ak-dist-g5', 'is_featured' => false, 'sort_order' => 41],
            ['name' => 'रायसेन',     'name_en' => 'Raisen',      'slug' => 'raisen',       'region' => 'नर्मदा', 'gradient_class' => 'ak-dist-g6',  'is_featured' => false, 'sort_order' => 42],
            ['name' => 'रतलाम',      'name_en' => 'Ratlam',      'slug' => 'ratlam',       'region' => 'मालवा',   'gradient_class' => 'ak-dist-g7',  'is_featured' => false, 'sort_order' => 43],
            ['name' => 'सतना',       'name_en' => 'Satna',       'slug' => 'satna',        'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g8',  'is_featured' => false, 'sort_order' => 44],
            ['name' => 'सीहोर',      'name_en' => 'Sehore',      'slug' => 'sehore',       'region' => 'मालवा',   'gradient_class' => 'ak-dist-g9',  'is_featured' => false, 'sort_order' => 45],
            ['name' => 'सिवनी',      'name_en' => 'Seoni',       'slug' => 'seoni',        'region' => 'महाकौशल', 'gradient_class' => 'ak-dist-g10', 'is_featured' => false, 'sort_order' => 46],
            ['name' => 'शहडोल',      'name_en' => 'Shahdol',     'slug' => 'shahdol',      'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g11', 'is_featured' => false, 'sort_order' => 47],
            ['name' => 'शाजापुर',    'name_en' => 'Shajapur',    'slug' => 'shajapur',     'region' => 'मालवा',   'gradient_class' => 'ak-dist-g12', 'is_featured' => false, 'sort_order' => 48],
            ['name' => 'श्योपुर',    'name_en' => 'Sheopur',     'slug' => 'sheopur',      'region' => 'चंबल',    'gradient_class' => 'ak-dist-g1',  'is_featured' => false, 'sort_order' => 49],
            ['name' => 'शिवपुरी',    'name_en' => 'Shivpuri',    'slug' => 'shivpuri',     'region' => 'चंबल',    'gradient_class' => 'ak-dist-g2',  'is_featured' => false, 'sort_order' => 50],
            ['name' => 'सीधी',       'name_en' => 'Sidhi',       'slug' => 'sidhi',        'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g3',  'is_featured' => false, 'sort_order' => 51],
            ['name' => 'सिंगरौली',   'name_en' => 'Singrauli',   'slug' => 'singrauli',    'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g4',  'is_featured' => false, 'sort_order' => 52],
            ['name' => 'उज्जैन',     'name_en' => 'Ujjain',      'slug' => 'ujjain',       'region' => 'मालवा',   'gradient_class' => 'ak-dist-g5',  'is_featured' => false, 'sort_order' => 53],
            ['name' => 'उमरिया',     'name_en' => 'Umaria',      'slug' => 'umaria',       'region' => 'विंध्य',  'gradient_class' => 'ak-dist-g6',  'is_featured' => false, 'sort_order' => 54],
            ['name' => 'विदिशा',     'name_en' => 'Vidisha',     'slug' => 'vidisha',      'region' => 'मालवा',   'gradient_class' => 'ak-dist-g7',  'is_featured' => false, 'sort_order' => 55],
        ];

        foreach ($districts as $district) {
            District::updateOrCreate(
                ['slug' => $district['slug']],
                array_merge(['is_active' => true, 'description' => $district['description'] ?? null, 'market_info' => $district['market_info'] ?? null], $district)
            );
        }
    }
}
