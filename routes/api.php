<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::get('/services', [ApiController::class, 'services']);
Route::get('/services/{service}', [ApiController::class, 'service']);
Route::get('/districts', [ApiController::class, 'districts']);
Route::get('/districts/{district}', [ApiController::class, 'district']);
Route::get('/crop-categories', [ApiController::class, 'cropCategories']);
Route::get('/faqs', [ApiController::class, 'faqs']);
Route::get('/sliders', [ApiController::class, 'sliders']);
Route::get('/prices/{type?}', [ApiController::class, 'prices'])
    ->whereIn('type', ['market', 'vegetable', 'crop']);
Route::get('/mandi-bhav', [ApiController::class, 'prices']);
Route::get('/market-price', [ApiController::class, 'prices']);
Route::get('/vegetable-price', fn (ApiController $controller, \Illuminate\Http\Request $request, \App\Services\FarmerPriceService $service) => $controller->prices($request, $service, 'vegetable'));
Route::get('/crop-price', fn (ApiController $controller, \Illuminate\Http\Request $request, \App\Services\FarmerPriceService $service) => $controller->prices($request, $service, 'crop'));
Route::post('/inquiries', [ApiController::class, 'inquiry']);
Route::post('/farmer-registrations', [ApiController::class, 'farmer']);
Route::post('/transport-bookings', [ApiController::class, 'transport']);

Route::middleware('api.token')->group(function () {
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::get('/profile', [ApiController::class, 'profile']);
    Route::get('/my/inquiries', [ApiController::class, 'myInquiries']);
    Route::post('/my/inquiries', [ApiController::class, 'createMyInquiry']);
});
