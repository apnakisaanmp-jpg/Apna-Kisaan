@php
    use App\Models\District;
    use App\Models\Setting;
    $navDistricts = District::active()->ordered()->get();
@endphp
<div class="ak-topbar py-2">
    <div class="container d-flex justify-content-between align-items-center"><span><i
                class="fa-solid fa-phone me-2"></i>+91 626 507 1588</span><span class="d-none d-sm-inline"><i
                class="fa-solid fa-envelope me-2"></i>hemantkachhi2002@gmail.com</span></div>
</div>
<nav class="ak-nav py-2">
    <div class="container d-flex align-items-center justify-content-between gap-3">
        <a href="{{ route('home') }}" class="ak-brand d-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset(Setting::get('logo', 'assets/images/अपना.किसान.png')) }}" alt="Apna Kisaan">
            <span>{{ Setting::get('site_name', 'Apna Kisaan') }}<small>ग्राम सेवा - सही बाजार</small></span>
        </a>
        <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNav">
            <i class="fa-solid fa-bars fs-3"></i>
        </button>
        <div id="mainNav" class="collapse d-lg-flex flex-grow-1 justify-content-end align-items-center gap-3">
            <a class="ak-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            <a class="ak-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            <div class="dropdown">
                <a class="ak-link dropdown-toggle {{ request()->routeIs('services*', 'districts.show') ? 'active' : '' }}"
                    href="{{ route('services') }}" data-bs-toggle="dropdown" aria-expanded="false">सेवाएं</a>
                <div class="dropdown-menu ak-dropdown-menu ak-district-menu p-3">
                    <div class="small fw-bold text-secondary border-bottom pb-2 mb-2"><i
                            class="fa-solid fa-map-location-dot text-success me-1"></i> MP के सभी
                        {{ $navDistricts->count() }} जिले</div>
                    <div class="ak-district-grid">
                        @foreach ($navDistricts as $district)
                            <a href="{{ route('districts.show', $district) }}"><i
                                    class="fa-solid fa-location-dot"></i>{{ $district->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <a class="ak-link dropdown-toggle {{ request()->routeIs('mandi-bhav', 'market-price', 'crop-price', 'vegetable-price') ? 'active' : '' }}"
                    href="{{ route('mandi-bhav') }}" data-bs-toggle="dropdown" aria-expanded="false">मंडी भाव</a>
                <div class="dropdown-menu ak-dropdown-menu">
                    <a href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-store"></i> बाजार भाव</a>
                    <a href="{{ route('vegetable-price') }}"><i class="fa-solid fa-leaf"></i> सब्जी भाव</a>
                    <a href="{{ route('crop-price') }}"><i class="fa-solid fa-wheat-awn"></i> फसल भाव</a>
                </div>
            </div>
            <a class="ak-link" href="{{ route('farmer-connect') }}">Farmer Connect</a>
            <a class="ak-link" href="{{ route('transport') }}">Transport</a>
            <a class="ak-link" href="{{ route('contact') }}">Contact</a>
            @auth
                <a class="ak-btn secondary"
                    href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"><i
                        class="fa-solid fa-gauge"></i> Dashboard</a>
            @else
                <a class="ak-btn secondary" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i>
                    Login</a>
            @endauth
        </div>
    </div>
</nav>
