<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAvailabilityController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Simple test route without Vite
Route::get('/simple', function () {
    return view('simple');
})->name('simple');

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

// Booking routes
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::post('/contact', [BookingController::class, 'contact'])->name('contact.store');

// Appointment routes
Route::get('/appointments/slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
Route::post('/appointments/book', [AppointmentController::class, 'bookAppointment'])->name('appointments.book');
Route::get('/appointments/calendar', [AppointmentController::class, 'getCalendarData'])->name('appointments.calendar');
Route::get('/appointments/booked-dates', [AppointmentController::class, 'getBookedDates'])->name('appointments.booked-dates');
Route::post('/appointments/cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointments.cancel');
Route::get('/appointments/details', [AppointmentController::class, 'getAppointmentDetails'])->name('appointments.details');
