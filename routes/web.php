<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAvailabilityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Main route - show the home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Test route to verify routing is working
Route::get('/test', function () {
    return response()->json(['message' => 'Route is working']);
});

// Test database connection
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['message' => 'Database connection successful']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Database connection failed: ' . $e->getMessage()]);
    }
});

// Test form submission
Route::post('/test-form', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Form test successful',
        'data' => $request->all()
    ]);
});

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
    Route::get('/bookings/unavailable', [BookingAvailabilityController::class, 'unavailable']);
});
