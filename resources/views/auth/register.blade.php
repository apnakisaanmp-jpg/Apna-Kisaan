@extends('layouts.frontend')

@section('content')
    <section class="ak-auth-section">
        <div class="container">
            <div class="ak-auth-panel">
                <div class="ak-auth-art" aria-label="अपना किसान से जुड़ें">
                    <div class="ak-auth-art-icon" aria-hidden="true">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <p class="ak-auth-eyebrow">अपना किसान परिवार</p>
                    <h1>खेत से बाजार तक, अब साथ-साथ।</h1>
                    <p>अपना खाता बनाकर कृषि जानकारी, मंडी भाव और हमारी किसान सेवाओं से जुड़ें।</p>
                    <div class="ak-auth-art-points">
                        <span><i class="fa-solid fa-check-circle"></i> एक ही जगह जरूरी सेवाएँ</span>
                        <span><i class="fa-solid fa-check-circle"></i> आसान खाता प्रबंधन</span>
                    </div>
                </div>

                <div class="ak-auth-content">
                    <p class="ak-auth-eyebrow">आज ही जुड़ें</p>
                    <h2>अपना खाता बनाएं</h2>
                    <p class="ak-auth-description">नीचे अपनी जानकारी भरकर निःशुल्क पंजीकरण करें।</p>

                    <form class="ak-auth-form" method="post" action="{{ route('register.store') }}">
                        @csrf
                        <div class="ak-auth-field">
                            <label for="register-name">पूरा नाम</label>
                            <input id="register-name" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" autocomplete="name"
                                placeholder="अपना पूरा नाम लिखें" maxlength="120" required autofocus>
                            @error('name')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field">
                            <label for="register-mobile">मोबाइल नंबर <span>(वैकल्पिक)</span></label>
                            <input id="register-mobile" class="form-control @error('mobile') is-invalid @enderror"
                                name="mobile" type="tel" value="{{ old('mobile') }}" autocomplete="tel"
                                inputmode="tel" placeholder="अपना मोबाइल नंबर लिखें">
                            @error('mobile')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field">
                            <label for="register-email">ईमेल पता</label>
                            <input id="register-email" class="form-control @error('email') is-invalid @enderror"
                                name="email" type="email" value="{{ old('email') }}" autocomplete="email"
                                placeholder="name@example.com" maxlength="180" required>
                            @error('email')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field-row">
                            <div class="ak-auth-field">
                                <label for="register-password">पासवर्ड</label>
                                <input id="register-password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" type="password" autocomplete="new-password"
                                    placeholder="कम से कम 8 अक्षर" minlength="8" required>
                                @error('password')
                                    <span class="ak-field-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="ak-auth-field">
                                <label for="register-password-confirmation">पासवर्ड दोबारा लिखें</label>
                                <input id="register-password-confirmation" class="form-control"
                                    name="password_confirmation" type="password" autocomplete="new-password"
                                    placeholder="पासवर्ड की पुष्टि करें" minlength="8" required>
                            </div>
                        </div>
                        <button class="ak-btn ak-auth-submit" type="submit">
                            खाता बनाएं <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                        </button>
                    </form>

                    <p class="ak-auth-switch">पहले से खाता है?
                        <a href="{{ route('login') }}">लॉगिन करें</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
