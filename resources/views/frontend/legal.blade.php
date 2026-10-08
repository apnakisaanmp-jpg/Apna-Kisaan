@extends('layouts.frontend')

@php
    $legalPages = [
        'privacy' => [
            'title' => 'गोपनीयता नीति',
            'intro' => 'आपकी दी गई जानकारी और उसका उपयोग',
            'icon' => 'fa-shield-halved',
        ],
        'terms' => [
            'title' => 'नियम एवं शर्तें',
            'intro' => 'वेबसाइट और सेवाओं का उपयोग',
            'icon' => 'fa-file-contract',
        ],
        'payment' => [
            'title' => 'भुगतान संबंधी जानकारी',
            'intro' => 'भुगतान से पहले जरूरी सावधानियां',
            'icon' => 'fa-credit-card',
        ],
    ];
    $details = $legalPages[$page];
@endphp

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $details['title'] }}</li>
                </ol>
            </nav>
            <p class="eyebrow"><i class="fa-solid {{ $details['icon'] }} me-1"></i> अपना किसान</p>
            <h1>{{ $details['title'] }}</h1>
            <p>{{ $details['intro'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <article class="ak-card p-4 p-md-5">
                        @if ($page === 'privacy')
                            <h2 class="h4 fw-bold">हम कौन-सी जानकारी लेते हैं?</h2>
                            <p>जब आप संपर्क, किसान पंजीकरण या परिवहन फॉर्म भेजते हैं, तो आप अपना नाम, मोबाइल नंबर, जिला और अनुरोध से जुड़ी जानकारी देते हैं। फॉर्म के प्रकार के अनुसार फसल, व्यवसाय या परिवहन का विवरण भी लिया जा सकता है।</p>
                            <h2 class="h4 fw-bold mt-4">जानकारी का उपयोग</h2>
                            <p>दी गई जानकारी का उपयोग आपकी पूछताछ का उत्तर देने, पंजीकरण की समीक्षा करने और परिवहन अनुरोध पर आपसे संपर्क करने के लिए किया जाता है। अधिकृत टीम के अलावा इसे अनधिकृत रूप से साझा नहीं किया जाना चाहिए।</p>
                            <h2 class="h4 fw-bold mt-4">आपकी जिम्मेदारी और संपर्क</h2>
                            <p>कृपया सही मोबाइल और जरूरी विवरण दें। अपनी जानकारी के उपयोग के बारे में सवाल के लिए <a class="text-success" href="mailto:hemantkachhi2002@gmail.com">हमसे ईमेल पर संपर्क करें</a>।</p>
                        @elseif ($page === 'terms')
                            <h2 class="h4 fw-bold">भाव और बाजार जानकारी</h2>
                            <p>वेबसाइट पर दिखाए गए भाव सूचना के लिए हैं। डेटा स्रोत और अपडेट समय उपलब्ध होने पर पेज पर दिखाया जाता है। भाव क्षेत्रीय या संदर्भ मूल्य हो सकता है, मंडी में मिलने वाली अंतिम कीमत की गारंटी नहीं। फसल की गुणवत्ता, आवक, स्थान और समय के अनुसार वास्तविक कीमत बदल सकती है।</p>
                            <h2 class="h4 fw-bold mt-4">फॉर्म और सेवाओं का अनुरोध</h2>
                            <p>फॉर्म भेजना पंजीकरण या सेवा अनुरोध है, उसकी स्वीकृति अथवा खरीद-बिक्री की पुष्टि नहीं। परिवहन की उपलब्धता, तारीख और किराये की पुष्टि टीम से अलग से प्राप्त करें।</p>
                            <h2 class="h4 fw-bold mt-4">उचित उपयोग</h2>
                            <p>सही जानकारी दें और वेबसाइट का उपयोग धोखाधड़ी, स्पैम या किसी अन्य के अधिकारों को नुकसान पहुंचाने के लिए न करें। सेवाओं से जुड़े सवाल के लिए आधिकारिक संपर्क विवरण का उपयोग करें।</p>
                        @else
                            <h2 class="h4 fw-bold">भुगतान से पहले पुष्टि करें</h2>
                            <p>इस वेबसाइट पर परिवहन अनुरोध भेजना भुगतान या बुकिंग की पुष्टि नहीं है। वाहन, उपलब्धता, सेवा शुल्क और भुगतान की विधि की पुष्टि हमारी टीम से सीधे प्राप्त करें।</p>
                            <h2 class="h4 fw-bold mt-4">सुरक्षित भुगतान</h2>
                            <p>बिना आधिकारिक पुष्टि के किसी निजी खाते, UPI ID या फोन नंबर पर पैसे न भेजें। भुगतान का प्रमाण और रसीद संभालकर रखें। इस साइट पर फिलहाल ऑनलाइन भुगतान गेटवे की सुविधा उपलब्ध नहीं है।</p>
                            <h2 class="h4 fw-bold mt-4">सहायता</h2>
                            <p>बुकिंग या भुगतान संबंधी सवाल के लिए <a class="text-success" href="tel:+916265071588">+91 626 507 1588</a> पर संपर्क करें।</p>
                        @endif
                        <p class="small text-secondary border-top pt-3 mt-4 mb-0">इस जानकारी में बदलाव हो सकता है। महत्वपूर्ण सेवा या भुगतान विवरण टीम से सीधे सत्यापित करें।</p>
                    </article>
                </div>
                <div class="col-lg-4">
                    <aside class="ak-card p-4">
                        <span class="ak-icon mb-3"><i class="fa-solid fa-headset"></i></span>
                        <h2 class="h5 fw-bold">कोई सवाल है?</h2>
                        <p class="text-secondary">सेवा, जानकारी या भुगतान से जुड़े सवाल के लिए हमारी टीम से संपर्क करें।</p>
                        <a class="ak-btn w-100" href="{{ route('contact') }}"><i class="fa-solid fa-envelope"></i> संपर्क करें</a>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
