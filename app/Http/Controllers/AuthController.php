<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'कृपया अपना ईमेल पता भरें।',
            'email.email' => 'कृपया सही ईमेल पता दर्ज करें।',
            'password.required' => 'कृपया अपना पासवर्ड भरें।',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'ईमेल या पासवर्ड सही नहीं है।'])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! $request->user()->is_active) {
            Auth::logout();
            return back()->withErrors(['email' => 'यह खाता अभी सक्रिय नहीं है।']);
        }

        return redirect()->intended($request->user()->isAdmin() ? route('admin.dashboard') : route('dashboard'));
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email'],
            'mobile' => ['nullable', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required' => 'कृपया अपना पूरा नाम भरें।',
            'name.max' => 'नाम 120 अक्षरों से अधिक नहीं होना चाहिए।',
            'email.required' => 'कृपया अपना ईमेल पता भरें।',
            'email.email' => 'कृपया सही ईमेल पता दर्ज करें।',
            'email.max' => 'ईमेल पता 180 अक्षरों से अधिक नहीं होना चाहिए।',
            'email.unique' => 'इस ईमेल से पहले ही खाता बना हुआ है।',
            'mobile.regex' => 'कृपया सही मोबाइल नंबर दर्ज करें।',
            'password.required' => 'कृपया पासवर्ड भरें।',
            'password.confirmed' => 'दोनों पासवर्ड एक जैसे नहीं हैं।',
            'password.min' => 'पासवर्ड कम से कम 8 अक्षरों का होना चाहिए।',
        ]);

        $user = User::create($data + ['role' => 'user', 'is_active' => true]);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'आपका खाता बन गया है।');
    }

    public function forgotForm()
    {
        return view('auth.forgot-password');
    }

    public function forgot(Request $request)
    {
        $request->validate(['email' => ['required', 'email']], [
            'email.required' => 'कृपया अपना ईमेल पता भरें।',
            'email.email' => 'कृपया सही ईमेल पता दर्ज करें।',
        ]);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'पासवर्ड रीसेट लिंक भेज दिया गया है।')
            : back()->withErrors(['email' => 'इस ईमेल के लिए खाता नहीं मिला।']);
    }

    public function resetForm(Request $request, string $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'कृपया अपना ईमेल पता भरें।',
            'email.email' => 'कृपया सही ईमेल पता दर्ज करें।',
            'password.required' => 'कृपया नया पासवर्ड भरें।',
            'password.confirmed' => 'दोनों पासवर्ड एक जैसे नहीं हैं।',
            'password.min' => 'पासवर्ड कम से कम 8 अक्षरों का होना चाहिए।',
        ]);

        $status = Password::reset($data, function (User $user, string $password) {
            $user->forceFill(['password' => $password])->save();
        });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'पासवर्ड अपडेट हो गया है।')
            : back()->withErrors(['email' => 'रीसेट लिंक अमान्य या समाप्त हो गया है।']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
