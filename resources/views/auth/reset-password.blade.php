@extends('layouts.frontend')

@section('content')
    <section class="ak-auth-section">
        <div class="container">
            <div class="ak-auth-panel ak-auth-panel-compact">
                <div class="ak-auth-art" aria-hidden="true">
                    <div class="ak-auth-art-icon"><i class="fa-solid fa-lock"></i></div>
                    <p class="ak-auth-eyebrow">खाता सुरक्षा</p>
                    <h1>नया पासवर्ड चुनें।</h1>
                    <p>अपना पासवर्ड अपडेट करके अपने खाते का सुरक्षित उपयोग जारी रखें।</p>
                </div>
                <div class="ak-auth-content">
                    <p class="ak-auth-eyebrow">पासवर्ड रीसेट</p>
                    <h2>नया पासवर्ड बनाएं</h2>
                    <p class="ak-auth-description">सुरक्षा के लिए कम से कम 8 अक्षरों का पासवर्ड रखें।</p>
                    <form class="ak-auth-form" method="post" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="ak-auth-field">
                            <label for="reset-email">ईमेल पता</label>
                            <input id="reset-email" class="form-control @error('email') is-invalid @enderror"
                                type="email" name="email" value="{{ old('email', $email) }}" autocomplete="email" required>
                            @error('email')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field">
                            <label for="reset-password">नया पासवर्ड</label>
                            <input id="reset-password" class="form-control @error('password') is-invalid @enderror"
                                type="password" name="password" autocomplete="new-password" minlength="8" required>
                            @error('password')
                                <span class="ak-field-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ak-auth-field">
                            <label for="reset-password-confirmation">पासवर्ड दोबारा लिखें</label>
                            <input id="reset-password-confirmation" class="form-control"
                                type="password" name="password_confirmation" autocomplete="new-password" minlength="8" required>
                        </div>
                        <button class="ak-btn ak-auth-submit" type="submit">
                            पासवर्ड अपडेट करें <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
