@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item active" aria-current="page">किसान सेवाएं</li>
                </ol>
            </nav>
            <p class="eyebrow"><i class="fa-solid fa-seedling me-1"></i> खेती से बाजार तक</p>
            <h1>किसानों के लिए एक ही जगह जरूरी सेवाएं</h1>
            <p>बाजार भाव, जिले की जानकारी और परिवहन अनुरोध—अपनी जरूरत के अनुसार सेवा चुनें।</p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a class="ak-btn" href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-chart-line"></i> आज के भाव देखें</a>
                <a class="ak-btn secondary" href="{{ route('contact') }}"><i class="fa-solid fa-headset"></i> सहायता लें</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <p class="eyebrow mb-1">आपके काम की सेवाएं</p>
                    <h2 class="h3 fw-bold mb-0">अपनी जरूरत चुनें</h2>
                </div>
                <span class="text-secondary">{{ $services->count() }} सेवाएं</span>
            </div>
            <div class="row g-4">
                @forelse ($services as $index => $service)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="ak-card h-100 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="ak-icon"><i class="{{ $service->icon ?: 'fa-solid fa-leaf' }}"></i></span>
                                <span class="badge rounded-pill text-bg-light">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h2 class="h5 fw-bold">{{ $service->title }}</h2>
                            <p class="text-secondary">{{ $service->short_description }}</p>
                            <a class="ak-btn secondary mt-2" href="{{ route('services.show', $service) }}">
                                सेवा की जानकारी <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ak-card p-4">
                            <p class="mb-0">सेवाओं की जानकारी जल्द उपलब्ध होगी। सहायता के लिए <a class="text-success" href="{{ route('contact') }}">हमसे संपर्क करें</a>।</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section ak-soft-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <p class="eyebrow mb-1">आज ही जुड़ें</p>
                    <h2 class="h3 fw-bold">अपनी फसल और जरूरत हमें बताएं।</h2>
                    <p class="text-secondary mb-0">टीम आपकी जानकारी की समीक्षा करके सही सेवा के लिए आपसे संपर्क करेगी।</p>
                </div>
                <div class="col-lg-4 d-flex flex-wrap gap-2">
                    <a class="ak-btn" href="{{ route('farmer-connect') }}">पंजीकरण करें <i class="fa-solid fa-user-plus"></i></a>
                    <a class="ak-btn secondary" href="{{ route('transport') }}">परिवहन पूछें</a>
                </div>
            </div>
        </div>
    </section>
@endsection
