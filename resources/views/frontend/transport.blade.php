@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">फसल परिवहन</li>
                </ol>
            </nav>
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <p class="eyebrow"><i class="fa-solid fa-truck-fast me-1"></i> खेत से बाजार तक</p>
                    <h1>फसल परिवहन का अनुरोध करें</h1>
                    <p>उठाने का स्थान, गंतव्य, फसल और तारीख भेजें। हमारी टीम उपलब्ध वाहन की पुष्टि के लिए आपसे संपर्क करेगी।</p>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex flex-wrap gap-2">
                        <a class="ak-btn" href="tel:+916265071588"><i class="fa-solid fa-phone"></i> अभी बात करें</a>
                        <a class="ak-btn secondary" href="https://wa.me/916265071588" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <div class="ak-form-intro">
                        <p class="eyebrow">आसान और स्पष्ट प्रक्रिया</p>
                        <h2 class="h3 fw-bold">अनुरोध के बाद क्या होगा?</h2>
                        <p class="text-secondary">आपकी भेजी जानकारी हमारी टीम तक पहुंचती है; वाहन और किराये की पुष्टि कॉल पर होगी।</p>
                    </div>
                    <div class="d-grid gap-3">
                        <article class="ak-step-card">
                            <span>1</span>
                            <div><h3>विवरण भरें</h3><p>फसल, मात्रा, स्थान और पसंदीदा तारीख दें।</p></div>
                        </article>
                        <article class="ak-step-card">
                            <span>2</span>
                            <div><h3>टीम का फोन पाएं</h3><p>उपलब्ध वाहन और अनुमानित किराये पर बात होगी।</p></div>
                        </article>
                        <article class="ak-step-card">
                            <span>3</span>
                            <div><h3>बुकिंग की पुष्टि</h3><p>सहमति के बाद बुकिंग नंबर और आगे की जानकारी पाएं।</p></div>
                        </article>
                    </div>
                    <div class="ak-notice mt-4">
                        <i class="fa-solid fa-circle-info text-success mt-1"></i>
                        <p><strong>ध्यान दें:</strong> फॉर्म भेजने से बुकिंग अपने-आप पक्की नहीं होती। टीम की पुष्टि का इंतजार करें।</p>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ak-card ak-form-card">
                        @include('frontend.forms.transport')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
