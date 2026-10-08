@extends('layouts.frontend')

@section('content')
    <section class="ak-page-hero">
        <div class="container">
            <nav aria-label="ब्रेडक्रम्ब">
                <ol class="breadcrumb mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">होम</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services') }}">सेवाएं</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $service->title }}</li>
                </ol>
            </nav>
            <p class="eyebrow"><i class="{{ $service->icon ?: 'fa-solid fa-seedling' }} me-1"></i> किसानों के लिए सेवा</p>
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->short_description }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    @if ($service->image)
                        <img src="{{ asset($service->image) }}" class="img-fluid rounded-4 mb-4"
                            alt="{{ $service->title }}" loading="lazy">
                    @endif
                    <article class="ak-card p-4 p-md-5">
                        <span class="ak-icon mb-3"><i class="{{ $service->icon ?: 'fa-solid fa-seedling' }}"></i></span>
                        <h2 class="h3 fw-bold">इस सेवा के बारे में</h2>
                        <div class="text-secondary" style="line-height:1.9">{!! nl2br(e($service->description)) !!}</div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <aside class="ak-card p-4 mb-4">
                        <p class="eyebrow">अगला कदम</p>
                        <h2 class="h5 fw-bold">अपनी जरूरत साझा करें</h2>
                        <p class="text-secondary">अपनी फसल या सवाल बताएं। टीम उपलब्ध सहायता पर आपसे संपर्क करेगी।</p>
                        <a class="ak-btn w-100" href="{{ route('contact') }}"><i class="fa-solid fa-headset"></i> सहायता लें</a>
                    </aside>
                    @if ($relatedServices->isNotEmpty())
                        <aside class="ak-card p-4">
                            <h2 class="h5 fw-bold mb-3">अन्य सेवाएं</h2>
                            <div class="d-grid gap-2">
                                @foreach ($relatedServices as $related)
                                    <a class="ak-step-card text-decoration-none" href="{{ route('services.show', $related) }}">
                                        <span><i class="{{ $related->icon ?: 'fa-solid fa-leaf' }}"></i></span>
                                        <div><h3>{{ $related->title }}</h3><p>{{ $related->short_description }}</p></div>
                                    </a>
                                @endforeach
                            </div>
                        </aside>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
