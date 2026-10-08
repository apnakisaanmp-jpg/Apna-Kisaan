@php use App\Models\Setting; @endphp
<footer class="ak-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5>{{ Setting::get('site_name', 'Apna Kisaan') }}</h5>
                <p class="mb-3">{{ Setting::get('footer_about', 'Farmers market information and support.') }}</p>
                <div class="d-flex gap-3">
                    <a href="{{ Setting::get('facebook_url', '#') }}"><i class="fa-brands fa-facebook"></i></a>
                    <a href="{{ Setting::get('instagram_url', '#') }}"><i class="fa-brands fa-instagram"></i></a>
                    <a href="{{ Setting::get('youtube_url', '#') }}"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h6>किसान सेवाएं</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('mandi-bhav') }}">बाजार भाव</a>
                    <a href="{{ route('vegetable-price') }}">सब्जी भाव</a>
                    <a href="{{ route('crop-price') }}">फसल भाव</a>
                    <a href="{{ route('transport') }}">परिवहन</a>
                    <a href="{{ route('farmer-connect') }}">किसान संपर्क</a>
                </div>
            </div>
            <div class="col-lg-3">
                <h6>Contact</h6>
                <p class="mb-1"><i class="fa-solid fa-phone me-2"></i>{{ Setting::get('contact_phone', '') }}</p>
                <p class="mb-1"><i class="fa-solid fa-envelope me-2"></i>{{ Setting::get('contact_email', '') }}</p>
                <p class="mb-0"><i
                        class="fa-solid fa-location-dot me-2"></i>{{ Setting::get('contact_address', '') }}</p>
            </div>
            <div class="col-lg-3">
                <h6>किसान सहायता</h6>
                <p>किसान पंजीकरण, मंडी भाव और परिवहन सहायता के लिए संपर्क करें।</p>
                <div class="d-flex flex-wrap gap-2"><a class="ak-btn" href="{{ route('contact') }}"><i
                            class="fa-solid fa-phone"></i> संपर्क करें</a><a class="ak-btn secondary"
                        href="https://wa.me/916265071588" target="_blank"><i class="fa-brands fa-whatsapp"></i>
                        WhatsApp</a></div>
            </div>
        </div>
        <hr class="border-success-subtle my-4">
        <p class="mb-0 small">{{ Setting::get('footer_copyright', '© Apna Kisaan. All rights reserved.') }}</p>
    </div>
</footer>
