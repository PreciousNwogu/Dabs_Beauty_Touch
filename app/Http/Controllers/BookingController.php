<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'time' => 'required|string',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create the booking
            $booking = Booking::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'service' => $request->service,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'message' => $request->message,
                'status' => 'pending'
            ]);

            // Send confirmation email (optional)
            // Mail::to($request->email)->send(new BookingConfirmation($booking));

            Log::info('New booking created', ['booking_id' => $booking->id]);

            return response()->json([
                'success' => true,
                'message' => 'Booking submitted successfully! We will contact you soon to confirm your appointment.',
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating booking: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle contact form submissions.
     */
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Send contact email (implement as needed)
            // Mail::to(config('mail.admin_email'))->send(new ContactForm($request->all()));

            Log::info('Contact form submitted', ['email' => $request->email]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing contact form: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending your message. Please try again.'
            ], 500);
        }
    }

    /**
     * Get all bookings (admin use).
     */
    public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'bookings' => $bookings
        ]);
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $booking->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully.',
            'booking' => $booking
        ]);
    }
}
