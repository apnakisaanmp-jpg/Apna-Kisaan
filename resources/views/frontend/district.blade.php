@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services') }}">सेवाएं और जिले</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $district->name }}</li>
                </ol>
            </nav>
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <p class="eyebrow"><i class="fa-solid fa-location-dot me-1"></i> {{ $district->region ?: 'मध्य प्रदेश' }}</p>
                    <h1>{{ $district->name }} की मंडी और बाजार जानकारी</h1>
                    <p>{{ $district->description ?: 'अपने जिले की बाजार जानकारी, किसान सहायता और सेवाओं के लिए Apna Kisaan से जुड़ें।' }}</p>
                </div>
                <div class="col-lg-4">
                    <a class="ak-btn" href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-chart-line"></i> आज के भाव देखें</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    <article class="ak-card p-4 p-md-5 h-100">
                        <span class="ak-icon mb-3"><i class="fa-solid fa-store"></i></span>
                        <p class="eyebrow">स्थानीय बाजार</p>
                        <h2 class="h3 fw-bold">आपके जिले के बाजार की जानकारी</h2>
                        <p class="text-secondary">{{ $district->market_info ?: 'अपनी फसल, मात्रा और संपर्क विवरण के साथ किसान पंजीकरण करें। उपलब्ध सेवाओं और परिवहन सहायता के लिए हमारी टीम से बात करें।' }}</p>
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a class="ak-btn" href="{{ route('farmer-connect') }}"><i class="fa-solid fa-people-group"></i> किसान / खरीदार जुड़ें</a>
                            <a class="ak-btn secondary" href="{{ route('transport') }}"><i class="fa-solid fa-truck-fast"></i> परिवहन अनुरोध</a>
                        </div>
                    </article>
                </div>
                <div class="col-lg-5">
                    <aside class="ak-card p-4">
                        <p class="eyebrow">सभी सेवाएं</p>
                        <h2 class="h4 fw-bold mb-2">किसानों के लिए सहायता</h2>
                        <div class="d-grid">
                            @forelse ($services as $service)
                                <a class="ak-step-card my-2 text-decoration-none" href="{{ route('services.show', $service) }}">
                                    <span><i class="{{ $service->icon ?: 'fa-solid fa-seedling' }}"></i></span>
                                    <div><h3>{{ $service->title }}</h3><p>{{ $service->short_description }}</p></div>
                                </a>
                            @empty
                                <p class="text-secondary mb-0">सेवाओं की जानकारी जल्द उपलब्ध होगी। सहायता के लिए संपर्क करें।</p>
                            @endforelse
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
