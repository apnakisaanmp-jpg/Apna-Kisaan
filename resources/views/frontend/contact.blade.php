@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">संपर्क करें</li>
                </ol>
            </nav>
            <p class="eyebrow"><i class="fa-solid fa-headset me-1"></i> किसान सहायता</p>
            <h1>हमसे संपर्क करें</h1>
            <p>मंडी भाव, किसान पंजीकरण, परिवहन या किसी अन्य सहायता के लिए अपना संदेश भेजें।</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <h2 class="h3 fw-bold mb-3">Apna Kisaan सहायता टीम</h2>
                    <p class="text-secondary mb-4">अपनी जरूरत का विवरण दें। फॉर्म भेजने के बाद आपकी पूछताछ टीम के डैशबोर्ड में दर्ज होगी।</p>
                    <div class="d-grid gap-3">
                        <a class="ak-step-card text-decoration-none" href="tel:+916265071588">
                            <span><i class="fa-solid fa-phone"></i></span>
                            <div><h3>फोन पर बात करें</h3><p>+91 626 507 1588</p></div>
                        </a>
                        <a class="ak-step-card text-decoration-none" href="mailto:hemantkachhi2002@gmail.com">
                            <span><i class="fa-solid fa-envelope"></i></span>
                            <div><h3>ईमेल लिखें</h3><p>hemantkachhi2002@gmail.com</p></div>
                        </a>
                        <a class="ak-step-card text-decoration-none" href="https://wa.me/916265071588" target="_blank" rel="noopener">
                            <span><i class="fa-brands fa-whatsapp"></i></span>
                            <div><h3>WhatsApp करें</h3><p>सीधे टीम से संदेश के जरिए संपर्क करें।</p></div>
                        </a>
                    </div>
                    <div class="ak-notice mt-4">
                        <i class="fa-solid fa-shield-halved text-success mt-1"></i>
                        <p>अपना मोबाइल नंबर सही भरें ताकि टीम आपकी पूछताछ पर आपसे संपर्क कर सके।</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ak-card ak-form-card">
                        @include('frontend.forms.contact', ['source' => 'contact'])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
