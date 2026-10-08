@extends('layouts.frontend')

@section('content')
    <section class="ak-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <div class="eyebrow text-warning">Apna Kisaan Internship</div>
                    <h1 class="display-5 fw-bold mt-2">कृषि और तकनीक के साथ सीखें, किसानों के लिए काम करें।</h1>
                    <p class="lead">ग्रामीण बाजार, डिजिटल सेवाओं और किसान सहायता से जुड़े वास्तविक काम में योगदान दें।</p>
                    <a class="ak-btn mt-3" href="#internship-application">अपनी रुचि दर्ज करें <i
                            class="fa-solid fa-arrow-down"></i></a>
                </div>
                <div class="col-lg-5">
                    <img class="img-fluid rounded-3 shadow" src="{{ asset('assets/images/internship.jpg') }}"
                        alt="अपना किसान इंटर्नशिप कार्यक्रम" loading="eager">
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <div class="eyebrow">सीखने के क्षेत्र</div>
                <h2 class="fw-bold">अपनी रुचि के अनुसार योगदान दें।</h2>
                <p class="text-secondary">इंटर्नशिप रुचि भेजें; उपलब्ध अवसर और आगे की प्रक्रिया हमारी टीम साझा करेगी।</p>
            </div>
            <div class="row g-4">
                @foreach ([
                    ['fa-seedling', 'कृषि और बाजार', 'फसल, स्थानीय मंडी और किसानों की जरूरतों पर जानकारी जुटाएं।'],
                    ['fa-laptop-code', 'डिजिटल सेवाएं', 'वेबसाइट, डेटा और ऑनलाइन किसान सेवाओं को बेहतर बनाने में सहयोग करें।'],
                    ['fa-bullhorn', 'किसान समुदाय', 'स्थानीय जागरूकता, संचार और किसान सहायता गतिविधियों में भाग लें।'],
                ] as [$icon, $title, $description])
                    <div class="col-md-4">
                        <div class="ak-card h-100 p-4">
                            <div class="ak-icon mb-3"><i class="fa-solid {{ $icon }}"></i></div>
                            <h3 class="h5 fw-bold">{{ $title }}</h3>
                            <p class="text-secondary mb-0">{{ $description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section ak-soft-section" id="internship-application">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <div class="eyebrow">इंटर्नशिप में रुचि</div>
                    <h2 class="fw-bold">हमसे संपर्क करें।</h2>
                    <p class="text-secondary">अपना नाम, मोबाइल नंबर और रुचि का क्षेत्र भेजें। आपकी inquiry टीम तक पहुंचेगी और हम उपलब्ध अवसरों के बारे में संपर्क करेंगे।</p>
                    <a href="mailto:hemantkachhi2002@gmail.com" class="ak-link">
                        <i class="fa-solid fa-envelope me-2"></i>hemantkachhi2002@gmail.com
                    </a>
                </div>
                <div class="col-lg-7">
                    <div class="ak-card p-4">
                        @include('frontend.forms.contact', ['source' => 'internship'])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
