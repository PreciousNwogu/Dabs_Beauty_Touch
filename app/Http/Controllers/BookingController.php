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
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'completed_by' => 'nullable|string|max:255',
            'completion_notes' => 'nullable|string|max:1000',
            'final_price' => 'nullable|numeric|min:0',
            'service_duration_minutes' => 'nullable|integer|min:1',
            'payment_status' => 'nullable|in:pending,deposit_paid,fully_paid'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Use the enhanced updateStatus method
            $booking->updateStatus(
                $request->status,
                $request->completed_by,
                $request->completion_notes,
                $request->final_price,
                $request->service_duration_minutes
            );

            // Update payment status if provided
            if ($request->filled('payment_status')) {
                $booking->payment_status = $request->payment_status;
                $booking->save();
            }

            Log::info('Booking status updated', [
                'booking_id' => $booking->id,
                'old_status' => $booking->getOriginal('status'),
                'new_status' => $request->status,
                'updated_by' => $request->completed_by
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully.',
                'booking' => $booking->fresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating booking status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the booking status.'
            ], 500);
        }
    }

    /**
     * Get booking statistics for admin dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => Booking::count(),
                'today' => Booking::whereDate('appointment_date', today())->count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'completed' => Booking::where('status', 'completed')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
                'revenue_today' => Booking::where('status', 'completed')
                    ->whereDate('completed_at', today())
                    ->sum('final_price'),
                'revenue_month' => Booking::where('status', 'completed')
                    ->whereMonth('completed_at', now()->month)
                    ->whereYear('completed_at', now()->year)
                    ->sum('final_price'),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting booking stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving booking statistics'
            ], 500);
        }
    }
}
