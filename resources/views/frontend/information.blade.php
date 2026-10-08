@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">कृषि जानकारी</li>
                </ol>
            </nav>
            <p class="eyebrow"><i class="fa-solid fa-book-open me-1"></i> किसानों के लिए उपयोगी जानकारी</p>
            <h1>खेती, बाजार और सेवाओं से जुड़े सवाल</h1>
            <p>मंडी भाव समझने, पंजीकरण करने और परिवहन अनुरोध भेजने से जुड़ी जानकारी यहां पढ़ें।</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 mb-5">
                @foreach ([
                    ['fa-chart-line', 'मंडी भाव कैसे देखें?', 'मंडी भाव पेज पर फसल खोजें। भाव का स्रोत और तारीख जरूर देखें; उपलब्ध डेटा क्षेत्रीय हो सकता है।'],
                    ['fa-users', 'किसान या खरीदार कैसे जुड़ें?', 'किसान संपर्क पेज पर अपनी भूमिका चुनें, जरूरी जानकारी भरें और पंजीकरण भेजें।'],
                    ['fa-truck-fast', 'परिवहन का अनुरोध कैसे करें?', 'परिवहन पेज पर उठाने और पहुंचाने का स्थान, फसल की मात्रा, तारीख और मोबाइल नंबर दर्ज करें।'],
                ] as [$icon, $question, $answer])
                    <div class="col-12 col-md-4">
                        <article class="ak-card h-100 p-4">
                            <span class="ak-icon mb-3"><i class="fa-solid {{ $icon }}"></i></span>
                            <h2 class="h5 fw-bold">{{ $question }}</h2>
                            <p class="text-secondary mb-0">{{ $answer }}</p>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <p class="eyebrow mb-1">अक्सर पूछे जाने वाले सवाल</p>
                    <h2 class="h3 fw-bold mb-0">आपके सवाल, सरल जवाब</h2>
                </div>
                <a class="ak-btn secondary" href="{{ route('contact') }}"><i class="fa-solid fa-headset"></i> और सहायता लें</a>
            </div>

            <div class="accordion mt-4" id="farmer-faq">
                @forelse ($faqs as $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="faq{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h3>
                        <div id="faq{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            data-bs-parent="#farmer-faq">
                            <div class="accordion-body">{{ $faq->answer }}</div>
                        </div>
                    </div>
                @empty
                    @foreach ([
                        ['भाव को अंतिम कीमत क्यों न मानें?', 'भाव संदर्भ के लिए हैं। वास्तविक खरीद मूल्य फसल की गुणवत्ता, मात्रा, स्थान और उसी दिन की मंडी स्थिति पर निर्भर करता है।'],
                        ['पंजीकरण भेजने के बाद क्या होगा?', 'टीम आपकी जानकारी की समीक्षा करके दिए गए मोबाइल नंबर पर संपर्क करेगी। पंजीकरण से खरीद या बिक्री की गारंटी नहीं मिलती।'],
                        ['मेरी जानकारी का उपयोग कैसे होगा?', 'दिए गए संपर्क विवरण का उपयोग आपकी पूछताछ या अनुरोध का जवाब देने के लिए किया जाएगा। अधिक जानकारी के लिए गोपनीयता नीति पढ़ें।'],
                    ] as $index => [$question, $answer])
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button {{ $index ? 'collapsed' : '' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#fallback-faq-{{ $index }}"
                                    aria-expanded="{{ $index ? 'false' : 'true' }}" aria-controls="fallback-faq-{{ $index }}">
                                    {{ $question }}
                                </button>
                            </h3>
                            <div id="fallback-faq-{{ $index }}" class="accordion-collapse collapse {{ $index ? '' : 'show' }}"
                                data-bs-parent="#farmer-faq">
                                <div class="accordion-body">{{ $answer }}</div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
@endsection
