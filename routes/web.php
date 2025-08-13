<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingAvailabilityController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Main route - show the home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Booking success page
Route::get('/booking/success', function () {
    // Check if we have booking details in session
    $bookingDetails = session('booking_details');
    return view('booking.success', compact('bookingDetails'));
})->name('booking.success');

// Calendar booking page
Route::get('/calendar', function () {
    return view('calendar');
})->name('calendar');

// Admin dashboard
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Admin service completion page
Route::get('/admin/complete-service', function () {
    return view('admin.complete-service');
})->name('admin.complete-service');

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

// Appointment routes
Route::get('/appointments/slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.slots');
Route::post('/appointments/book', [AppointmentController::class, 'bookAppointment'])->name('appointments.book');
Route::get('/appointments/calendar', [AppointmentController::class, 'getCalendarData'])->name('appointments.calendar');
Route::get('/appointments/booked-dates', [AppointmentController::class, 'getBookedDates'])->name('appointments.booked-dates');
Route::get('/appointments/booked-time-slots', [AppointmentController::class, 'getBookedTimeSlots'])->name('appointments.booked-time-slots');
Route::post('/appointments/cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointments.cancel');
Route::get('/appointments/details', [AppointmentController::class, 'getAppointmentDetails'])->name('appointments.details');

// Admin appointment routes
Route::get('/appointments/stats', [AppointmentController::class, 'getStats'])->name('appointments.stats');
Route::get('/appointments/list', [AppointmentController::class, 'getAppointmentsList'])->name('appointments.list');
Route::post('/appointments/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
Route::post('/appointments/search', [AppointmentController::class, 'searchAppointment'])->name('appointments.search');

// API routes for frontend (if needed for future AJAX calls)
Route::prefix('api')->group(function () {
    Route::get('/services', [ApiController::class, 'getServices']);
    Route::get('/testimonials', [ApiController::class, 'getTestimonials']);
    Route::get('/faqs', [ApiController::class, 'getFaqs']);
    Route::get('/contact-info', [ApiController::class, 'getContactInfo']);
    Route::get('/time-slots', [ApiController::class, 'getAvailableTimeSlots']);
    Route::get('/bookings/unavailable', [BookingAvailabilityController::class, 'unavailable']);
});
