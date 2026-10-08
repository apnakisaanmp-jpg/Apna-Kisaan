@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">किसान संपर्क</li>
                </ol>
            </nav>
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <p class="eyebrow"><i class="fa-solid fa-people-group me-1"></i> किसान और खरीदार नेटवर्क</p>
                    <h1>किसान या खरीदार के रूप में जुड़ें</h1>
                    <p>अपनी भूमिका चुनें। उसी के अनुसार जरूरी जानकारी भरकर पंजीकरण भेजें—फसल बेचने वाले किसान और खरीदने वाले व्यापारी दोनों के लिए अलग फॉर्म उपलब्ध है।</p>
                </div>
                <div class="col-lg-4">
                    <a class="ak-btn secondary" href="{{ route('information') }}"><i class="fa-solid fa-circle-question"></i> सवाल-जवाब देखें</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <h2 class="h3 fw-bold mb-3">इस पंजीकरण से क्या होगा?</h2>
                    <p class="text-secondary mb-4">आपकी जानकारी टीम तक पहुंचेगी, जो जरूरत समझकर उपलब्ध सहायता के लिए संपर्क करेगी। पंजीकरण से खरीद-बिक्री या किसी भाव की गारंटी नहीं मिलती।</p>
                    <div class="d-grid gap-3">
                        <article class="ak-step-card">
                            <span><i class="fa-solid fa-user-check"></i></span>
                            <div><h3>अपनी भूमिका चुनें</h3><p>किसान या खरीदार चुनने पर उसी से जुड़े सवाल दिखेंगे।</p></div>
                        </article>
                        <article class="ak-step-card">
                            <span><i class="fa-solid fa-list-check"></i></span>
                            <div><h3>सही जानकारी दें</h3><p>जिला, फसल और मात्रा से आपकी जरूरत समझने में मदद मिलेगी।</p></div>
                        </article>
                        <article class="ak-step-card">
                            <span><i class="fa-solid fa-phone-volume"></i></span>
                            <div><h3>टीम से बात करें</h3><p>सत्यापन और आगे की जानकारी के लिए टीम आपके मोबाइल पर संपर्क करेगी।</p></div>
                        </article>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ak-card ak-form-card">
                        @include('frontend.forms.farmer')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
