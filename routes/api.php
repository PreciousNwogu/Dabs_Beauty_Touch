<?php

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

// Public API routes - simplified closure implementation
Route::prefix('v1')->group(function () {
    // Booking routes
    Route::post('/bookings', function(Request $request) {
        return response()->json(['message' => 'API booking submission received']);
    });
    
    Route::post('/contact', function(Request $request) {
        return response()->json(['message' => 'API contact form submission received']);
    });

    // Data routes
    Route::get('/services', function() {
        return response()->json(['services' => []]);
    });
    
    Route::get('/testimonials', function() {
        return response()->json(['testimonials' => []]);
    });
    
    Route::get('/faq', function() {
        return response()->json(['faq' => []]);
    });
    
    Route::get('/contact-info', function() {
        return response()->json(['contact' => []]);
    });
    
    Route::get('/available-slots', function() {
        return response()->json(['available_slots' => []]);
    });
});

// Admin routes (protected) - simplified closure implementation
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::get('/bookings', function() {
        return response()->json(['bookings' => []]);
    });
    
    Route::patch('/bookings/{booking}/status', function($booking, Request $request) {
        return response()->json(['message' => 'API booking status updated']);
    });
});
