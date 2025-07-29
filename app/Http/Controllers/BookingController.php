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
        // Debug: Log the incoming request
        Log::info('Booking request received', [
            'method' => $request->method(),
            'url' => $request->url(),
            'headers' => $request->headers->all(),
            'data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            // 'address' => 'nullable|string|max:255', // Temporarily commented out until migration is run
            'message' => 'nullable|string|max:1000',
            'sample_picture' => 'nullable|file|image|max:2048',
        ]);

        if ($validator->fails()) {
            Log::warning('Booking validation failed', ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file upload if present
            $samplePicturePath = null;
            if ($request->hasFile('sample_picture')) {
                $file = $request->file('sample_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $samplePicturePath = $file->storeAs('sample_pictures', $filename, 'public');
            }

            // Create the booking with default appointment date/time
            $booking = Booking::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                // 'address' => $request->address, // Temporarily commented out until migration is run
                'service' => $request->service,
                'message' => $request->message,
                'sample_picture' => $samplePicturePath,
                'appointment_date' => now()->addDays(1)->toDateString(), // Default to tomorrow
                'appointment_time' => '09:00', // Default time
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
            Log::error('Error creating booking: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

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
