@extends('layouts.frontend')

@section('content')
    <section class="ak-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <p class="eyebrow"><i class="fa-solid fa-seedling me-1"></i> मध्य प्रदेश के किसानों के साथ</p>
                    <h1 class="display-5 fw-bold mt-2">आपकी फसल, आपका सही बाजार।</h1>
                    <p class="lead">Apna Kisaan किसानों को बाजार की उपयोगी जानकारी और सहायता से जोड़ने का प्रयास है, ताकि वे जानकारी के साथ बेहतर निर्णय ले सकें।</p>
                    <a class="ak-btn mt-3" href="{{ route('farmer-connect') }}">हमारे साथ जुड़ें <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="col-lg-5">
                    <img class="img-fluid rounded-4 shadow" src="{{ asset('/assets/images/ChatGPT%20Image%20Sep%209,%202026,%2012_15_07%20AM.png') }}"
                        alt="Apna Kisaan और किसान" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow">हमारा उद्देश्य</p>
                <h2 class="h2 fw-bold">जानकारी से बेहतर निर्णय तक</h2>
                <p class="text-secondary mx-auto" style="max-width:720px">स्थानीय कृषि अनुभव को उपयोगी बाजार जानकारी और किसान-केंद्रित डिजिटल सेवाओं के साथ जोड़ना।</p>
            </div>
            <div class="row g-4">
                @foreach ([
                    ['fa-bullseye', 'सही जानकारी', 'उपलब्ध मंडी और फसल भाव को स्रोत व संदर्भ सहित समझने में मदद।'],
                    ['fa-map-location-dot', 'स्थानीय पहचान', 'मध्य प्रदेश के जिलों और स्थानीय बाजार संदर्भ से जुड़ी जानकारी।'],
                    ['fa-truck-fast', 'जरूरत पर सहायता', 'किसान पंजीकरण और परिवहन अनुरोध के लिए सीधा संपर्क।'],
                ] as [$icon, $title, $text])
                    <div class="col-12 col-md-4">
                        <article class="ak-card h-100 p-4">
                            <span class="ak-icon mb-3"><i class="fa-solid {{ $icon }}"></i></span>
                            <h3 class="h5 fw-bold">{{ $title }}</h3>
                            <p class="text-secondary mb-0">{{ $text }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section ak-soft-section">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <p class="eyebrow mb-1">जिला नेटवर्क</p>
                    <h2 class="h3 fw-bold mb-0">मध्य प्रदेश के जिले</h2>
                </div>
                <a class="ak-btn secondary" href="{{ route('services') }}">जिले और सेवाएं देखें <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="row g-3">
                @forelse ($districts->take(12) as $district)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a class="ak-card d-block h-100 p-3 text-decoration-none text-dark" href="{{ route('districts.show', $district) }}">
                            <span class="ak-icon mb-2"><i class="fa-solid fa-location-dot"></i></span>
                            <strong class="d-block">{{ $district->name }}</strong>
                            <small class="d-block text-secondary mt-1">{{ $district->region ?: 'मध्य प्रदेश' }}</small>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><p class="text-secondary">जिले की जानकारी जल्द उपलब्ध होगी।</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow">हमारी टीम</p>
                <h2 class="h2 fw-bold">किसानों की सहायता के लिए समर्पित</h2>
            </div>
            <div class="row g-4">
                @forelse ($team as $member)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="ak-card h-100 overflow-hidden">
                            @if ($member->image)
                                <img class="w-100" style="aspect-ratio:4/3;object-fit:cover" src="{{ asset($member->image) }}" alt="{{ $member->name }}" loading="lazy">
                            @else
                                <div class="d-grid bg-light" style="height:200px;place-items:center"><span class="ak-icon"><i class="fa-solid fa-user-tie"></i></span></div>
                            @endif
                            <div class="p-4">
                                <h3 class="h5 fw-bold mb-1">{{ $member->name }}</h3>
                                <strong class="small text-success">{{ $member->designation }}</strong>
                                @if ($member->bio)<p class="text-secondary small mt-2 mb-0">{{ $member->bio }}</p>@endif
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ak-card p-4 text-center">
                            <span class="ak-icon mb-3"><i class="fa-solid fa-people-group"></i></span>
                            <p class="text-secondary mb-0">टीम की जानकारी जल्द साझा की जाएगी।</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
