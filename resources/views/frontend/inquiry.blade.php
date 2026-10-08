@extends('layouts.frontend')

@section('content')
    <section class="section bg-white">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-7">
                    <div class="eyebrow">किसान सहायता</div>
                    <h1 class="fw-bold">नई inquiry भेजें</h1>
                    <p class="text-secondary">आपकी inquiry का जवाब और स्थिति आपके dashboard में दिखाई देगी।</p>
                    <div class="ak-card p-4">
                        <form method="post" action="{{ route('inquiries.store') }}">
                            @csrf
                            <div class="mb-3"><label class="form-label">विषय</label><input class="form-control"
                                    name="subject" value="{{ old('subject') }}" required></div>
                            <div class="mb-3"><label class="form-label">फोन</label><input class="form-control"
                                    name="phone" value="{{ old('phone', auth()->user()->mobile) }}"></div>
                            <div class="mb-3"><label class="form-label">संदेश</label>
                                <textarea class="form-control" name="message" rows="6" required>{{ old('message') }}</textarea>
                            </div>
                            <button class="ak-btn" type="submit"><i class="fa-solid fa-paper-plane"></i> inquiry
                                भेजें</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
