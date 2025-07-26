<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API routes
Route::prefix('v1')->group(function () {
    // Booking routes
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/contact', [BookingController::class, 'contact']);

    // Data routes
    Route::get('/services', [ApiController::class, 'getServices']);
    Route::get('/testimonials', [ApiController::class, 'getTestimonials']);
    Route::get('/faq', [ApiController::class, 'getFAQ']);
    Route::get('/contact-info', [ApiController::class, 'getContactInfo']);
    Route::get('/available-slots', [ApiController::class, 'getAvailableTimeSlots']);
});

// Admin routes (protected)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus']);
});
