<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontend\LeadController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\PageController;
use App\Models\District;
use App\Services\FarmerPriceService;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/index.html', [PageController::class, 'home'])->name('home.index');
Route::get('/home.html', [PageController::class, 'home'])->name('home.legacy');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about.html', [PageController::class, 'about'])->name('about.legacy');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/service.html', [PageController::class, 'services'])->name('services.legacy');
Route::get('/services/{service}', [PageController::class, 'service'])->name('services.show');
Route::get('/district/{district}', [PageController::class, 'district'])->name('districts.show');
$legacyDistrictPages = [
    'service1.html' => 'damoh',
    'service2.html' => 'panna',
    'service3.html' => 'chhatarpur',
    'services4.html' => 'bhopal',
    'service5.html' => 'sagar',
    'service6.html' => 'narsinghpur',
    'service7.html' => 'jabalpur',
    'service8.html' => 'gwalior',
    'service9.html' => 'balaghat',
    'service10.html' => 'rewa',
    'service11.html' => 'tikamgarh',
];
foreach ($legacyDistrictPages as $path => $slug) {
    Route::get('/' . $path, fn() => app(PageController::class)->district(District::where('slug', $slug)->firstOrFail()))->name('districts.legacy.' . $slug);
}
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/contactus.html', [PageController::class, 'contact'])->name('contact.legacy');
Route::get('/farmer-connect', [PageController::class, 'farmerConnect'])->name('farmer-connect');
Route::get('/farmer-connect.html', [PageController::class, 'farmerConnect'])->name('farmer-connect.legacy');
Route::get('/transport', [PageController::class, 'transport'])->name('transport');
Route::get('/transport.html', [PageController::class, 'transport'])->name('transport.legacy');
Route::get('/mandi-bhav', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'mandi-bhav'))->name('mandi-bhav');
Route::get('/mandi-bhav.html', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'mandi-bhav'))->name('mandi-bhav.legacy');
Route::get('/market-price', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'market-price'))->name('market-price');
Route::get('/market-price.html', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'market-price'))->name('market-price.legacy');
Route::get('/crop-price', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'crop-price'))->name('crop-price');
Route::get('/crop-price.html', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'crop-price'))->name('crop-price.legacy');
Route::get('/vegetable-price', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'vegetable-price'))->name('vegetable-price');
Route::get('/vegetable-price.html', fn(PageController $controller, FarmerPriceService $priceService) => $controller->prices($priceService, 'vegetable-price'))->name('vegetable-price.legacy');
Route::get('/information', [PageController::class, 'information'])->name('information');
Route::get('/information.html', [PageController::class, 'information'])->name('information.legacy');
Route::get('/internship', [PageController::class, 'internship'])->name('internship');
Route::get('/internship.html', [PageController::class, 'internship'])->name('internship.legacy');
Route::get('/privacy', fn(PageController $controller) => $controller->legal('privacy'))->name('privacy');
Route::get('/term', fn(PageController $controller) => $controller->legal('terms'))->name('terms');
Route::get('/payment', fn(PageController $controller) => $controller->legal('payment'))->name('payment');
Route::get('/payment.html', fn(PageController $controller) => $controller->legal('payment'))->name('payment.legacy');
Route::get('/privacy.html', fn(PageController $controller) => $controller->legal('privacy'))->name('privacy.legacy');
Route::get('/term.html', fn(PageController $controller) => $controller->legal('terms'))->name('terms.legacy');

Route::post('/contact', [LeadController::class, 'contact'])->name('leads.contact');
Route::post('/farmer-connect', [LeadController::class, 'farmer'])->name('leads.farmer');
Route::post('/transport', [LeadController::class, 'transport'])->name('leads.transport');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgot'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/dashboard', [DashboardController::class, 'user'])->middleware('auth')->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/inquiry', [InquiryController::class, 'create'])->name('inquiries.create');
    Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiries.store');
    Route::get('/user/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/{resource}', [AdminController::class, 'index'])->name('resources.index');
    Route::get('/{resource}/create', [AdminController::class, 'create'])->name('resources.create');
    Route::post('/{resource}', [AdminController::class, 'store'])->name('resources.store');
    Route::get('/{resource}/{id}/edit', [AdminController::class, 'edit'])->name('resources.edit');
    Route::put('/{resource}/{id}', [AdminController::class, 'update'])->name('resources.update');
    Route::delete('/{resource}/{id}', [AdminController::class, 'destroy'])->name('resources.destroy');
});
