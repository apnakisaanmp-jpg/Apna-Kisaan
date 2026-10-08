@extends('layouts.frontend')

@section('content')
    <section class="ak-auth-section">
        <div class="container">
            <div class="ak-auth-panel">
                <div class="ak-auth-art" aria-label="किसान सेवा">
                    <div class="ak-auth-art-icon" aria-hidden="true">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <p class="ak-auth-eyebrow">अपना किसान परिवार</p>
                    <h1>आपकी फसल से सही बाजार तक।</h1>
                    <p>लॉगिन करके मंडी भाव देखें, सेवाओं से जुड़ें और अपनी पूछताछ की जानकारी पाएँ।</p>
                    <div class="ak-auth-art-points">
                        <span><i class="fa-solid fa-check-circle"></i> भरोसेमंद कृषि जानकारी</span>
                        <span><i class="fa-solid fa-check-circle"></i> सरल और सुरक्षित खाता</span>
                    </div>
                </div>

                <div class="ak-auth-content">
                    <p class="ak-auth-eyebrow">आपका स्वागत है</p>
                    <h2>अपने खाते में लॉगिन करें</h2>
                    <p class="ak-auth-description">जारी रखने के लिए अपना ईमेल और पासवर्ड भरें।</p>

                    <form class="ak-auth-form" method="post" action="{{ route('login.store') }}">
                        @csrf
                        <div class="ak-auth-field">
                            <label for="login-email">ईमेल पता</label>
                            <input id="login-email" class="form-control @error('email') is-invalid @enderror"
                                name="email" type="email" value="{{ old('email') }}" autocomplete="email"
                                placeholder="name@example.com" required autofocus>
                            @error('email')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field">
                            <label for="login-password">पासवर्ड</label>
                            <input id="login-password" class="form-control @error('password') is-invalid @enderror"
                                name="password" type="password" autocomplete="current-password"
                                placeholder="अपना पासवर्ड लिखें" required>
                            @error('password')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-options">
                            <label class="ak-auth-remember" for="remember">
                                <input id="remember" type="checkbox" name="remember" value="1"
                                    @checked(old('remember'))>
                                <span>मुझे याद रखें</span>
                            </label>
                            <a href="{{ route('password.request') }}">पासवर्ड भूल गए?</a>
                        </div>
                        <button class="ak-btn ak-auth-submit" type="submit">
                            लॉगिन करें <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>

                    <p class="ak-auth-switch">क्या आपका खाता नहीं है?
                        <a href="{{ route('register') }}">नया खाता बनाएं</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
