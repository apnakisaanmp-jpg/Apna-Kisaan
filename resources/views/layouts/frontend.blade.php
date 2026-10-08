@php
    use App\Models\Setting;
    $siteName   = Setting::get('site_name', 'अपना किसान');
    $title      = $seo?->meta_title ?? Setting::get('default_meta_title', $siteName . ' — मंडी भाव, सब्जी बाजार और कृषि जानकारी');
    $description = $seo?->meta_description ?? Setting::get('default_meta_desc', 'मध्य प्रदेश के किसानों के लिए सब्जी मंडी भाव, लाइव फसल भाव, कृषि जानकारी और परिवहन सहायता।');
    $logo       = Setting::get('logo', 'assets/images/अपना.किसान.png');
@endphp
<!doctype html>
<html lang="hi">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <meta name="description" content="{{ $description }}"/>
  <meta name="robots" content="{{ $seo?->robots ?? 'index,follow' }}"/>
  <link rel="canonical" href="{{ $seo?->canonical_url ?? url()->current() }}"/>
  <meta property="og:title" content="{{ $title }}"/>
  <meta property="og:description" content="{{ $description }}"/>
  <meta property="og:type" content="website"/>
  <meta property="og:url" content="{{ url()->current() }}"/>
  <meta property="og:image" content="{{ asset('assets/images/अपना.किसान.png') }}"/>
  <meta name="twitter:card" content="summary_large_image"/>
  <title>{{ $title }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700;800;900&family=Karla:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/ak-design.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/css/frontend-pages.css') }}"/>
  @stack('styles')
</head>
<body>

{{-- TOP BAR --}}
<div class="ak-topbar">
  <div class="ak-shell ak-topbar-inner">
    <a href="tel:+916265071588"><i class="fa-solid fa-phone"></i> +91 626 507 1588</a>
    <a href="mailto:hemantkachhi2002@gmail.com" class="ak-topbar-email d-none d-sm-inline">
      <i class="fa-solid fa-envelope"></i> hemantkachhi2002@gmail.com
    </a>
    <span class="ak-topbar-note"><i class="fa-solid fa-seedling"></i> किसानों के साथ</span>
  </div>
</div>

{{-- HEADER --}}
<header class="ak-header" id="akSharedHeader">
  <div class="ak-shell ak-nav">

    {{-- Logo --}}
    <a class="ak-brand" href="{{ route('home') }}">
      <img src="{{ asset($logo) }}" alt="अपना किसान"/>
      <div class="ak-brand-text">
        <strong>अपना किसान</strong>
        <span>ग्रामीण सब्जी — शहरी वितरण</span>
      </div>
    </a>

    {{-- Desktop Nav --}}
    <nav class="ak-nav-links" id="akDesktopNav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home', 'home.index', 'home.legacy') ? 'active' : '' }}">होम</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">हमारे बारे में</a>

      {{-- Services dropdown --}}
      <div class="ak-dd" id="ddServices">
        <a href="{{ route('services') }}" class="ak-dd-trigger {{ request()->routeIs('services*','districts.show') ? 'active' : '' }}">
          सेवाएं <i class="fa-solid fa-chevron-down"></i>
        </a>
        <div class="ak-dd-panel ak-dd-panel-wide">
          <div class="ak-dd-header"><i class="fa-solid fa-map-location-dot"></i> MP के सभी जिले</div>
          <div class="ak-dd-grid">
            @php
              $navDistricts = \App\Models\District::active()->ordered()->get();
            @endphp
            @foreach($navDistricts as $d)
              <a href="{{ route('districts.show', $d) }}" class="ak-dd-link">
                <i class="fa-solid fa-location-dot"></i><span>{{ $d->name }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Mandi Bhav dropdown --}}
      <div class="ak-dd" id="ddMandi">
        <a href="{{ route('mandi-bhav') }}" class="ak-dd-trigger {{ request()->routeIs('mandi-bhav','market-price','crop-price','vegetable-price') ? 'active' : '' }}">
          मंडी भाव <i class="fa-solid fa-chevron-down"></i>
        </a>
        <div class="ak-dd-panel">
          <a href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-store"></i> मंडी भाव</a>
          <a href="{{ route('market-price') }}"><i class="fa-solid fa-chart-line"></i> बाजार भाव</a>
          <a href="{{ route('vegetable-price') }}"><i class="fa-solid fa-leaf"></i> सब्जी भाव</a>
          <a href="{{ route('crop-price') }}"><i class="fa-solid fa-wheat-awn"></i> फसल भाव</a>
        </div>
      </div>

      <div class="ak-dd" id="ddUseful">
        <a href="{{ route('information') }}" class="ak-dd-trigger {{ request()->routeIs('information', 'internship', 'privacy', 'terms') ? 'active' : '' }}">
          उपयोगी लिंक <i class="fa-solid fa-chevron-down"></i>
        </a>
        <div class="ak-dd-panel">
          <a href="{{ route('information') }}"><i class="fa-solid fa-book-open"></i> कृषि जानकारी</a>
          <a href="{{ route('internship') }}"><i class="fa-solid fa-graduation-cap"></i> इंटर्नशिप</a>
          <a href="{{ route('privacy') }}"><i class="fa-solid fa-shield-halved"></i> गोपनीयता नीति</a>
          <a href="{{ route('terms') }}"><i class="fa-solid fa-file-lines"></i> नियम एवं शर्तें</a>
        </div>
      </div>

      <a href="{{ route('transport') }}" class="{{ request()->routeIs('transport') ? 'active' : '' }}">परिवहन</a>
      <a href="{{ route('payment') }}" class="{{ request()->routeIs('payment') ? 'active' : '' }}">भुगतान</a>
      <a href="{{ route('farmer-connect') }}" class="{{ request()->routeIs('farmer-connect') ? 'active' : '' }}">किसान संपर्क</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">संपर्क</a>
    </nav>

    {{-- Right: CTA + Hamburger --}}
    <div class="ak-nav-right">
      @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="ak-nav-cta">
          <i class="fa-solid fa-gauge"></i> डैशबोर्ड
        </a>
      @else
        <div class="ak-auth-links" aria-label="खाता विकल्प">
          <a href="{{ route('login') }}" class="ak-nav-login {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> लॉगिन
          </a>
          <a href="{{ route('register') }}" class="ak-nav-register {{ request()->routeIs('register') ? 'active' : '' }}">
            <i class="fa-solid fa-user-plus" aria-hidden="true"></i> रजिस्टर
          </a>
        </div>
      @endauth
      <button class="ak-hamburger" id="akHamBtn" aria-label="मेनू" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

{{-- Mobile Sidebar Overlay --}}
<div class="ak-sidebar-overlay" id="akOverlay"></div>

{{-- Mobile Sidebar --}}
<aside class="ak-sidebar" id="akSidebar" aria-hidden="true">
  <div class="ak-sidebar-head">
    <div class="ak-sidebar-brand">
      <img src="{{ asset($logo) }}" alt="अपना किसान"/>
      <div>
        <strong>अपना किसान</strong>
        <span>आपकी फसल, आपका सही बाजार</span>
      </div>
    </div>
    <button class="ak-sidebar-close" id="akSidebarClose" aria-label="बंद करें">&times;</button>
  </div>
  <nav class="ak-sidebar-nav">
    <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> होम</a>
    <a href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> हमारे बारे में</a>

    <div class="ak-sidebar-acc">
      <button class="ak-sidebar-acc-btn" aria-expanded="false">
        <span><i class="fa-solid fa-shop"></i> सेवाएं</span>
        <i class="fa-solid fa-chevron-down ak-acc-icon"></i>
      </button>
      <div class="ak-sidebar-acc-body">
        <p class="ak-sidebar-acc-label"><i class="fa-solid fa-map-location-dot"></i> MP के जिले</p>
        <div class="ak-sidebar-dist-grid">
          @foreach($navDistricts as $d)
            <a href="{{ route('districts.show', $d) }}" class="ak-dd-link">
              <i class="fa-solid fa-location-dot"></i><span>{{ $d->name }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>

    <div class="ak-sidebar-acc">
      <button class="ak-sidebar-acc-btn" aria-expanded="false">
        <span><i class="fa-solid fa-chart-line"></i> मंडी भाव</span>
        <i class="fa-solid fa-chevron-down ak-acc-icon"></i>
      </button>
      <div class="ak-sidebar-acc-body">
        <a href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-store"></i> मंडी भाव</a>
        <a href="{{ route('market-price') }}"><i class="fa-solid fa-chart-line"></i> बाजार भाव</a>
        <a href="{{ route('vegetable-price') }}"><i class="fa-solid fa-leaf"></i> सब्जी भाव</a>
        <a href="{{ route('crop-price') }}"><i class="fa-solid fa-wheat-awn"></i> फसल भाव</a>
      </div>
    </div>

    <a href="{{ route('transport') }}"><i class="fa-solid fa-truck-moving"></i> परिवहन</a>
    <a href="{{ route('payment') }}"><i class="fa-solid fa-credit-card"></i> भुगतान स्थिति</a>
    <a href="{{ route('farmer-connect') }}"><i class="fa-solid fa-users"></i> किसान संपर्क</a>
    <a href="{{ route('information') }}"><i class="fa-solid fa-book-open"></i> कृषि जानकारी</a>
    <a href="{{ route('internship') }}"><i class="fa-solid fa-graduation-cap"></i> इंटर्नशिप</a>
    @auth
      <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"><i class="fa-solid fa-gauge"></i> डैशबोर्ड</a>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" style="background:none;border:none;width:100%;text-align:left;padding:12px 20px;font:600 14px var(--ak-font-hi);color:var(--ak-text-mid);display:flex;align-items:center;gap:10px;cursor:pointer;">
          <i class="fa-solid fa-right-from-bracket"></i> लॉगआउट
        </button>
      </form>
    @else
      <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> लॉगिन</a>
      <a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i> नया खाता बनाएं</a>
    @endauth
  </nav>
  <div class="ak-sidebar-footer">
    <a href="{{ route('farmer-connect') }}" class="ak-sidebar-cta">आज ही शुरुआत करें <i class="fa-solid fa-arrow-right"></i></a>
    <div class="ak-sidebar-contact">
      <a href="tel:+916265071588"><i class="fa-solid fa-phone"></i> +91 626 507 1588</a>
      <a href="https://wa.me/916265071588" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
    </div>
  </div>
</aside>

{{-- Flash Messages --}}
@if(session('success'))
<div style="position:fixed;top:80px;right:20px;z-index:9999;max-width:380px;">
  <div class="ak-notice ak-notice-green" style="box-shadow:var(--ak-shadow-lg);">
    <i class="fa-solid fa-circle-check"></i>
    <div>{{ session('success') }}</div>
    <button onclick="this.closest('div').parentElement.remove()" style="background:none;border:none;cursor:pointer;color:var(--ak-green);margin-left:auto;font-size:18px;">&times;</button>
  </div>
</div>
@endif
@if(session('error') || $errors->any())
<div style="position:fixed;top:80px;right:20px;z-index:9999;max-width:380px;">
  <div class="ak-notice ak-notice-warn" style="box-shadow:var(--ak-shadow-lg);">
    <i class="fa-solid fa-triangle-exclamation"></i>
    <div>
      @if(session('error')){{ session('error') }}@endif
      @if($errors->any()){{ $errors->first() }}@endif
    </div>
    <button onclick="this.closest('div').parentElement.remove()" style="background:none;border:none;cursor:pointer;color:#b45309;margin-left:auto;font-size:18px;">&times;</button>
  </div>
</div>
@endif

{{-- Main Content --}}
<main id="main-content">
  @yield('content')
</main>

{{-- Footer --}}
<footer class="ak-footer">
  <div class="ak-shell">
    <div class="ak-footer-grid">
      <div class="ak-footer-brand">
        <img src="{{ asset($logo) }}" alt="अपना किसान"/>
        <strong>मध्य प्रदेश का अपना किसान</strong>
        <small>आपकी फसल, आपका सही बाजार।</small>
        <p>किसानों को सब्जी बाजार की जानकारी, भरोसेमंद परिवहन और समय पर भुगतान से जोड़ने का प्रयास।</p>
        <div class="ak-footer-social">
          <a href="https://wa.me/916265071588" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
          <a href="tel:+916265071588" aria-label="Phone"><i class="fa-solid fa-phone"></i></a>
          <a href="mailto:hemantkachhi2002@gmail.com" aria-label="Email"><i class="fa-solid fa-envelope"></i></a>
        </div>
      </div>

      <div class="ak-footer-col">
        <h4>किसान सेवाएं</h4>
        <a href="{{ route('mandi-bhav') }}"><i class="fa-solid fa-store"></i> बाजार भाव</a>
        <a href="{{ route('market-price') }}"><i class="fa-solid fa-chart-line"></i> मंडी मूल्य सूची</a>
        <a href="{{ route('vegetable-price') }}"><i class="fa-solid fa-leaf"></i> सब्जी भाव</a>
        <a href="{{ route('crop-price') }}"><i class="fa-solid fa-wheat-awn"></i> फसल भाव</a>
        <a href="{{ route('transport') }}"><i class="fa-solid fa-truck-moving"></i> परिवहन</a>
        <a href="{{ route('payment') }}"><i class="fa-solid fa-credit-card"></i> भुगतान</a>
        <a href="{{ route('farmer-connect') }}"><i class="fa-solid fa-users"></i> किसान संपर्क</a>
      </div>

      <div class="ak-footer-col">
        <h4>उपयोगी लिंक</h4>
        <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> होम</a>
        <a href="{{ route('about') }}"><i class="fa-solid fa-circle-info"></i> हमारे बारे में</a>
        <a href="{{ route('services') }}"><i class="fa-solid fa-shop"></i> सेवाएं</a>
        <a href="{{ route('information') }}"><i class="fa-solid fa-book-open"></i> कृषि जानकारी</a>
        <a href="{{ route('internship') }}"><i class="fa-solid fa-graduation-cap"></i> इंटर्नशिप</a>
        <a href="{{ route('contact') }}"><i class="fa-solid fa-envelope"></i> संपर्क करें</a>
        <a href="{{ route('privacy') }}"><i class="fa-solid fa-shield"></i> गोपनीयता</a>
        <a href="{{ route('terms') }}"><i class="fa-solid fa-file-lines"></i> नियम</a>
      </div>

      <div class="ak-footer-col ak-footer-contact">
        <h4>किसान सहायता</h4>
        <a href="tel:+916265071588"><i class="fa-solid fa-phone"></i> +91 626 507 1588</a>
        <a href="https://wa.me/916265071588" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp करें</a>
        <a href="mailto:hemantkachhi2002@gmail.com"><i class="fa-solid fa-envelope"></i> hemantkachhi2002@gmail.com</a>
        <span><i class="fa-solid fa-location-dot"></i> इंदौर, मध्य प्रदेश</span>
      </div>
    </div>

    <div class="ak-footer-bottom">
      <span>© {{ date('Y') }} अपना किसान. सभी अधिकार सुरक्षित।</span>
      <div class="ak-footer-legal">
        <a href="{{ route('privacy') }}">गोपनीयता नीति</a>
        <a href="{{ route('terms') }}">नियम एवं शर्तें</a>
      </div>
    </div>
  </div>
</footer>

{{-- Floating action buttons --}}
<div class="ak-float-actions">
  <a class="ak-float-btn ak-float-phone" href="tel:+916265071588" aria-label="फोन"><i class="fa-solid fa-phone"></i></a>
  <a class="ak-float-btn ak-float-whatsapp" href="https://wa.me/916265071588" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
</div>

{{-- Back to top --}}
<button id="akBackToTop" class="ak-back-to-top" aria-label="ऊपर"><i class="fa-solid fa-chevron-up"></i></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
  'use strict';

  /* ── Hamburger / Sidebar ─────────────────────────────── */
  var hamBtn   = document.getElementById('akHamBtn');
  var sidebar  = document.getElementById('akSidebar');
  var overlay  = document.getElementById('akOverlay');
  var closeBtn = document.getElementById('akSidebarClose');
  var header   = document.getElementById('akSharedHeader');

  function openSidebar() {
    if (!sidebar) return;
    sidebar.classList.add('open');
    sidebar.setAttribute('aria-hidden', 'false');
    overlay && overlay.classList.add('show');
    hamBtn && hamBtn.classList.add('active');
    document.body.classList.add('ak-no-scroll');
  }
  function closeSidebar() {
    if (!sidebar) return;
    sidebar.classList.remove('open');
    sidebar.setAttribute('aria-hidden', 'true');
    overlay && overlay.classList.remove('show');
    hamBtn && hamBtn.classList.remove('active');
    document.body.classList.remove('ak-no-scroll');
  }

  hamBtn   && hamBtn.addEventListener('click', openSidebar);
  closeBtn && closeBtn.addEventListener('click', closeSidebar);
  overlay  && overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSidebar(); });

  if (sidebar) {
    sidebar.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', closeSidebar); });
  }

  /* ── Sidebar accordions ──────────────────────────────── */
  document.querySelectorAll('.ak-sidebar-acc-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var acc  = this.closest('.ak-sidebar-acc');
      var body = acc.querySelector('.ak-sidebar-acc-body');
      var open = acc.classList.toggle('open');
      this.setAttribute('aria-expanded', String(open));
      body.style.maxHeight = open ? body.scrollHeight + 'px' : '0';
    });
  });

  /* ── Desktop dropdowns ───────────────────────────────── */
  var ddTimers = {};
  document.querySelectorAll('.ak-dd').forEach(function (dd, i) {
    dd.addEventListener('mouseenter', function () {
      clearTimeout(ddTimers[i]);
      document.querySelectorAll('.ak-dd.open').forEach(function (d) { d.classList.remove('open'); });
      dd.classList.add('open');
    });
    dd.addEventListener('mouseleave', function () {
      ddTimers[i] = setTimeout(function () { dd.classList.remove('open'); }, 160);
    });
  });

  /* ── Scroll shadow ───────────────────────────────────── */
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('scrolled', window.scrollY > 4);
    }, { passive: true });
  }

  /* ── Back to top ─────────────────────────────────────── */
  var btt = document.getElementById('akBackToTop');
  if (btt) {
    window.addEventListener('scroll', function () {
      btt.classList.toggle('visible', window.scrollY > 300);
    }, { passive: true });
    btt.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
  }

  /* ── FAQ accordion ───────────────────────────────────── */
  document.querySelectorAll('.ak-faq-q').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = this.closest('.ak-faq-item');
      var was  = item.classList.contains('open');
      document.querySelectorAll('.ak-faq-item.open').forEach(function (i) { i.classList.remove('open'); });
      if (!was) item.classList.add('open');
    });
  });

  /* ── Auto-close flash after 5s ───────────────────────── */
  var flashes = document.querySelectorAll('[style*="position:fixed"]');
  flashes.forEach(function (f) {
    setTimeout(function () { if (f && f.parentNode) f.parentNode.removeChild(f); }, 5000);
  });
})();
</script>

@stack('scripts')
</body>
</html>
