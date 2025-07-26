<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Main route - show the home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Booking routes
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::post('/contact', [BookingController::class, 'contact'])->name('contact.store');

// API routes for frontend (if needed for future AJAX calls)
Route::prefix('api')->group(function () {
    Route::get('/services', [ApiController::class, 'getServices']);
    Route::get('/testimonials', [ApiController::class, 'getTestimonials']);
    Route::get('/faqs', [ApiController::class, 'getFaqs']);
    Route::get('/contact-info', [ApiController::class, 'getContactInfo']);
    Route::get('/time-slots', [ApiController::class, 'getAvailableTimeSlots']);
});
