@extends('layouts.frontend')
@section('content')
    <section class="section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="eyebrow"> किसान account</div>
                    <h1 class="fw-bold mb-1">नमस्ते, {{ auth()->user()->name }}</h1>
                    <p class="text-secondary mb-0">आपकी किसान सेवाओं और requests का overview.</p>
                </div>
                <form method="post" action="{{ route('logout') }}">@csrf<button class="ak-btn secondary"><i
                            class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button></form>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-tile"><small class="text-secondary">मेरी inquiries</small>
                        <div class="fs-2 fw-bold">{{ $inquiries->count() }}</div><a class="ak-link"
                            href="{{ route('inquiries.create') }}">नई inquiry भेजें <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-tile"><small class="text-secondary">मेरी registrations</small>
                        <div class="fs-2 fw-bold">{{ $registrations->count() }}</div><a class="ak-link"
                            href="{{ route('farmer-connect') }}">किसान connect करें <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-tile"><small class="text-secondary">मेरी bookings</small>
                        <div class="fs-2 fw-bold">{{ $bookings->count() }}</div><a class="ak-link"
                            href="{{ route('transport') }}">Transport बुक करें <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="ak-card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold mb-0">मेरी inquiries</h5><i class="fa-solid fa-message text-success"></i>
                        </div>
                        @forelse($inquiries as $item)
                            <div class="border-bottom py-2">
                                <div class="fw-semibold">{{ $item->subject ?: 'सहायता request' }}</div><small
                                    class="text-secondary">{{ $item->created_at->format('d M Y') }}</small><span
                                    class="status-pill float-end">{{ $item->status }}</span>
                        </div>@empty<p class="text-secondary mb-0">अभी कोई inquiry नहीं है।</p>
                        @endforelse
                        <a class="ak-link" href="{{ route('inquiries.index') }}">सभी inquiries देखें <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ak-card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold mb-0">Registrations</h5><i class="fa-solid fa-seedling text-success"></i>
                        </div>
                        @forelse($registrations as $item)
                            <div class="border-bottom py-2">
                                <div class="fw-semibold">{{ ucfirst($item->type) }}</div><small
                                    class="text-secondary">{{ $item->district ?: 'District pending' }}</small><span
                                    class="status-pill float-end">{{ $item->status }}</span>
                        </div>@empty<p class="text-secondary mb-0">अभी कोई registration नहीं है।</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ak-card p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold mb-0">Transport bookings</h5><i class="fa-solid fa-truck text-success"></i>
                        </div>
                        @forelse($bookings as $item)
                            <div class="border-bottom py-2">
                                <div class="fw-semibold">{{ $item->booking_number }}</div><small
                                    class="text-secondary">{{ $item->crop_name ?: 'Crop pending' }}</small><span
                                    class="status-pill float-end">{{ $item->status }}</span>
                        </div>@empty<p class="text-secondary mb-0">अभी कोई booking नहीं है।</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
