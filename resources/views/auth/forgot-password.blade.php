@extends('layouts.frontend')

@section('content')
    <section class="ak-auth-section">
        <div class="container">
            <div class="ak-auth-panel ak-auth-panel-compact">
                <div class="ak-auth-art" aria-hidden="true">
                    <div class="ak-auth-art-icon"><i class="fa-solid fa-key"></i></div>
                    <p class="ak-auth-eyebrow">खाता सहायता</p>
                    <h1>पासवर्ड वापस पाएं।</h1>
                    <p>अपने खाते से जुड़े ईमेल पर पासवर्ड रीसेट लिंक मंगाएँ।</p>
                </div>
                <div class="ak-auth-content">
                    <p class="ak-auth-eyebrow">पासवर्ड सहायता</p>
                    <h2>पासवर्ड भूल गए?</h2>
                    <p class="ak-auth-description">अपना पंजीकृत ईमेल भरें। यदि उस ईमेल से खाता मौजूद है, तो रीसेट लिंक भेजा जाएगा।</p>
                    <form class="ak-auth-form" method="post" action="{{ route('password.email') }}">
                        @csrf
                        <div class="ak-auth-field">
                            <label for="reset-email">ईमेल पता</label>
                            <input id="reset-email" class="form-control @error('email') is-invalid @enderror"
                                type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                                placeholder="name@example.com" required autofocus>
                            @error('email')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button class="ak-btn ak-auth-submit" type="submit">
                            रीसेट लिंक भेजें <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </form>
                    <p class="ak-auth-switch"><a href="{{ route('login') }}">लॉगिन पेज पर वापस जाएँ</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
