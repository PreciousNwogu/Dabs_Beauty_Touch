<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Get available time slots for a specific date
     */
    public function getAvailableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today',
            'service' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $date = $request->date;
            $service = $request->service;
            
            // Check if this date is already booked with non-completed appointment
            $existingBooking = \App\Models\Booking::where('appointment_date', $date)
                ->where('status', '!=', 'completed')
                ->first();
            
            if ($existingBooking) {
                return response()->json([
                    'success' => true,
                    'slots' => [],
                    'date' => $date,
                    'message' => 'This date is already booked. Please select another date.'
                ]);
            }
            
            $slots = Appointment::getAvailableSlots($date, $service);
            
            return response()->json([
                'success' => true,
                'slots' => $slots,
                'date' => $date
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting available slots: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving available slots'
            ], 500);
        }
    }

    /**
     * Book a new appointment
     */
    public function bookAppointment(Request $request)
    {
        // Clear any output buffer to prevent warnings from mixing with JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        // Log incoming request data for debugging
        Log::info('Appointment booking request received', [
            'all_data' => $request->except(['sample_picture']), // Exclude file from logs
            'has_sample_picture' => $request->hasFile('sample_picture'),
            'sample_picture_valid' => $request->hasFile('sample_picture') && $request->file('sample_picture')->isValid(),
            'sample_picture_details' => $request->hasFile('sample_picture') ? [
                'original_name' => $request->file('sample_picture')->getClientOriginalName(),
                'mime_type' => $request->file('sample_picture')->getMimeType(),
                'size' => $request->file('sample_picture')->getSize(),
                'extension' => $request->file('sample_picture')->getClientOriginalExtension(),
            ] : 'No file uploaded',
            'headers' => $request->headers->all()
        ]);

        // Handle sample_picture validation separately to avoid empty file issues
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'nullable|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'message' => 'nullable|string|max:1000'
        ];

        // Only validate sample_picture if a file was actually uploaded
        if ($request->hasFile('sample_picture')) {
            $file = $request->file('sample_picture');
            if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
                $validationRules['sample_picture'] = 'file|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            Log::warning('Appointment booking validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if this date is already booked with non-completed appointment
            $existingBooking = \App\Models\Booking::where('appointment_date', $request->appointment_date)
                ->where('status', '!=', 'completed')
                ->first();
            
            if ($existingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'This date is already booked with another appointment. Please select a different date.'
                ], 422);
            }

            // Handle sample picture upload if provided
            $samplePicturePath = null;
            if ($request->hasFile('sample_picture')) {
                $file = $request->file('sample_picture');
                
                Log::info('File upload debug', [
                    'hasFile' => $request->hasFile('sample_picture'),
                    'isValid' => $file->isValid(),
                    'error' => $file->getError(),
                    'errorMessage' => $file->getErrorMessage(),
                    'size' => $file->getSize(),
                    'name' => $file->getClientOriginalName()
                ]);
                
                if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
                    Log::info('Processing file upload', [
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                    
                    try {
                        // Ensure storage directory exists
                        $storageDir = storage_path('app/public/sample_pictures');
                        if (!file_exists($storageDir)) {
                            mkdir($storageDir, 0755, true);
                        }
                        
                        // Use custom file name to avoid conflicts
                        $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                        $samplePicturePath = $file->storeAs('sample_pictures', $fileName, 'public');
                        
                        Log::info('File stored successfully', ['path' => $samplePicturePath]);
                    } catch (\Exception $e) {
                        Log::error('File storage failed', ['error' => $e->getMessage()]);
                        // Don't return error - continue without file upload
                        $samplePicturePath = null;
                    }
                } else {
                    Log::warning('File upload error', [
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                }
            } else {
                Log::info('No file uploaded');
            }

            // Create the booking
            $booking = \App\Models\Booking::create([
                'name' => $request->name,
                'email' => $request->email ?: 'no-email@example.com',
                'phone' => $request->phone,
                'service' => $request->service ?: 'General Service',
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'message' => $request->message,
                'sample_picture' => $samplePicturePath,
                'status' => 'pending'
            ]);

            Log::info('Booking created successfully', [
                'booking_id' => $booking->id,
                'sample_picture_saved' => $booking->sample_picture,
                'sample_picture_variable' => $samplePicturePath
            ]);

            // Generate a simple booking ID and confirmation code
            $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));

            Log::info('New appointment booked', [
                'booking_id' => $bookingId,
                'confirmation_code' => $confirmationCode
            ]);

            // Ensure clean JSON response
            if (ob_get_level()) {
                ob_clean();
            }

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'appointment' => [
                    'booking_id' => $bookingId,
                    'confirmation_code' => $confirmationCode,
                    'appointment_date' => date('l, F j, Y', strtotime($request->appointment_date)),
                    'appointment_time' => date('g:i A', strtotime($request->appointment_time)),
                    'service' => $request->service ?: 'General Service',
                    'email_provided' => !empty($request->email)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage());
            Log::error('Error details: ' . $e->getTraceAsString());
            
            // Ensure clean JSON response
            if (ob_get_level()) {
                ob_clean();
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error booking appointment. Please try again. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get calendar data for a month
     */
    public function getCalendarData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2024|max:2030',
            'month' => 'required|integer|min:1|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $year = $request->year;
            $month = $request->month;
            
            $startDate = "$year-$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $appointments = Appointment::getAppointmentsForDateRange($startDate, $endDate);
            
            $calendarData = [];
            foreach ($appointments as $appointment) {
                $date = $appointment->appointment_date->format('Y-m-d');
                if (!isset($calendarData[$date])) {
                    $calendarData[$date] = [];
                }
                $calendarData[$date][] = [
                    'time' => $appointment->appointment_time->format('H:i'),
                    'service' => $appointment->service,
                    'name' => $appointment->name
                ];
            }
            
            return response()->json([
                'success' => true,
                'calendar_data' => $calendarData,
                'year' => $year,
                'month' => $month
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting calendar data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving calendar data'
            ], 500);
        }
    }

    /**
     * Cancel an appointment
     */
    public function cancelAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string',
            'confirmation_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appointment = Appointment::where('booking_id', $request->booking_id)
                ->where('confirmation_code', $request->confirmation_code)
                ->first();

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found or invalid confirmation code'
                ], 404);
            }

            if ($appointment->status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment is already cancelled'
                ], 400);
            }

            $appointment->update(['status' => 'cancelled']);

            return response()->json([
                'success' => true,
                'message' => 'Appointment cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error cancelling appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling appointment'
            ], 500);
        }
    }

    /**
     * Get appointment details
     */
    public function getAppointmentDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Try to find in bookings table first (since that's what we're currently using)
            $booking = \App\Models\Booking::find($request->id);
            
            if ($booking) {
                return response()->json([
                    'success' => true,
                    'appointment' => [
                        'id' => $booking->id,
                        'booking_id' => 'BK-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                        'confirmation_code' => null, // Add if you have this field
                        'name' => $booking->name,
                        'email' => $booking->email,
                        'phone' => $booking->phone,
                        'address' => $booking->address,
                        'service' => $booking->service,
                        'length' => $booking->length,
                        'appointment_date' => $booking->appointment_date,
                        'appointment_time' => $booking->appointment_time,
                        'message' => $booking->message,
                        'status' => $booking->status,
                        'notes' => $booking->notes,
                        'sample_picture' => $booking->sample_picture,
                        'confirmed_at' => $booking->confirmed_at,
                        'completed_at' => $booking->completed_at,
                        'cancelled_at' => $booking->cancelled_at,
                        'completed_by' => $booking->completed_by,
                        'completion_notes' => $booking->completion_notes,
                        'service_duration_minutes' => $booking->service_duration_minutes,
                        'final_price' => $booking->final_price,
                        'payment_status' => $booking->payment_status,
                        'status_history' => $booking->getFormattedStatusHistory(),
                        'created_at' => $booking->created_at,
                        'updated_at' => $booking->updated_at
                    ]
                ]);
            }

            // Fallback to appointments table
            $appointment = Appointment::find($request->id);

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'appointment' => [
                    'id' => $appointment->id,
                    'booking_id' => $appointment->booking_id,
                    'confirmation_code' => $appointment->confirmation_code,
                    'name' => $appointment->name,
                    'email' => $appointment->email,
                    'phone' => $appointment->phone,
                    'service' => $appointment->service,
                    'appointment_date' => $appointment->appointment_date,
                    'appointment_time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                    'notes' => $appointment->notes
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting appointment details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving appointment details'
            ], 500);
        }
    }

    /**
     * Get appointment statistics for admin dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => Appointment::count(),
                'today' => Appointment::whereDate('appointment_date', today())->count(),
                'pending' => Appointment::where('status', 'pending')->count(),
                'confirmed' => Appointment::where('status', 'confirmed')->count(),
                'completed' => Appointment::where('status', 'completed')->count(),
                'cancelled' => Appointment::where('status', 'cancelled')->count()
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting appointment stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving appointment statistics'
            ], 500);
        }
    }

    /**
     * Get list of appointments with filters
     */
    public function getAppointmentsList(Request $request)
    {
        try {
            // Since we're using bookings table currently, query from there
            $query = \App\Models\Booking::query();

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('date')) {
                $query->whereDate('appointment_date', $request->date);
            }

            if ($request->filled('service')) {
                $query->where('service', $request->service);
            }

            // Order by date and time
            $bookings = $query->orderBy('appointment_date', 'asc')
                             ->orderBy('appointment_time', 'asc')
                             ->get();

            // Transform bookings to include all necessary fields
            $appointments = $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'booking_id' => 'BK-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                    'confirmation_code' => null, // Add if you have this field
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'address' => $booking->address,
                    'service' => $booking->service,
                    'length' => $booking->length,
                    'appointment_date' => $booking->appointment_date,
                    'appointment_time' => $booking->appointment_time,
                    'message' => $booking->message,
                    'status' => $booking->status,
                    'notes' => $booking->notes,
                    'sample_picture' => $booking->sample_picture,
                    'confirmed_at' => $booking->confirmed_at,
                    'completed_at' => $booking->completed_at,
                    'cancelled_at' => $booking->cancelled_at,
                    'completed_by' => $booking->completed_by,
                    'completion_notes' => $booking->completion_notes,
                    'service_duration_minutes' => $booking->service_duration_minutes,
                    'final_price' => $booking->final_price,
                    'payment_status' => $booking->payment_status,
                    'status_history' => $booking->status_history ?: [],
                    'created_at' => $booking->created_at,
                    'updated_at' => $booking->updated_at
                ];
            });

            return response()->json([
                'success' => true,
                'appointments' => $appointments
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting appointments list: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving appointments list'
            ], 500);
        }
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|integer',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
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
            // Try to find in appointments table first, then bookings table
            $appointment = Appointment::find($request->appointment_id);
            if (!$appointment) {
                // Fallback to bookings table (for backward compatibility)
                $booking = \App\Models\Booking::find($request->appointment_id);
                if ($booking) {
                    // Use the enhanced updateStatus method for bookings
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
                        'message' => 'Appointment status updated successfully'
                    ]);
                }
            }

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            $appointment->update([
                'status' => $request->status,
                'notes' => $request->completion_notes ?: $appointment->notes
            ]);

            Log::info('Appointment status updated', [
                'appointment_id' => $appointment->id,
                'booking_id' => $appointment->booking_id,
                'old_status' => $appointment->getOriginal('status'),
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment status updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating appointment status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating appointment status'
            ], 500);
        }
    }

    /**
     * Search for appointments by booking ID, phone, or name
     */
    public function searchAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $searchTerm = $request->search;
            
            // Try to find in bookings table first (since that's what we're currently using)
            $booking = \App\Models\Booking::where(function($query) use ($searchTerm) {
                $query->where('id', $searchTerm)
                      ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                      ->orWhere('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            })
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->first();

            if ($booking) {
                return response()->json([
                    'success' => true,
                    'appointment' => [
                        'id' => $booking->id,
                        'name' => $booking->name,
                        'email' => $booking->email,
                        'phone' => $booking->phone,
                        'service' => $booking->service,
                        'appointment_date' => $booking->appointment_date->format('M j, Y'),
                        'appointment_time' => $booking->appointment_time,
                        'status' => $booking->status
                    ]
                ]);
            }

            // If not found in bookings, try appointments table
            $appointment = Appointment::where(function($query) use ($searchTerm) {
                $query->where('booking_id', 'like', '%' . $searchTerm . '%')
                      ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                      ->orWhere('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%');
            })
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->first();

            if ($appointment) {
                return response()->json([
                    'success' => true,
                    'appointment' => [
                        'id' => $appointment->id,
                        'booking_id' => $appointment->booking_id,
                        'name' => $appointment->name,
                        'email' => $appointment->email,
                        'phone' => $appointment->phone,
                        'service' => $appointment->service,
                        'appointment_date' => $appointment->appointment_date->format('M j, Y'),
                        'appointment_time' => $appointment->appointment_time->format('g:i A'),
                        'status' => $appointment->status
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No pending or confirmed appointments found for this search term'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error searching appointments: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching for appointments'
            ], 500);
        }
    }

    /**
     * Get booked dates for a month to deactivate them in the calendar
     */
    public function getBookedDates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer|min:2024|max:2030',
            'month' => 'required|integer|min:1|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $year = $request->year;
            $month = $request->month;
            
            // Create start and end dates for the month
            $startDate = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            // Get bookings that are not completed (status != 'completed')
            $bookedDates = \App\Models\Booking::whereBetween('appointment_date', [$startDate, $endDate])
                ->where('status', '!=', 'completed')
                ->whereNotNull('appointment_date')
                ->select('appointment_date')
                ->distinct()
                ->pluck('appointment_date')
                ->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('Y-m-d');
                })
                ->toArray();
            
            Log::info('Booked dates retrieved', [
                'year' => $year,
                'month' => $month,
                'booked_dates' => $bookedDates
            ]);
            
            return response()->json([
                'success' => true,
                'booked_dates' => $bookedDates,
                'year' => $year,
                'month' => $month
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting booked dates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving booked dates'
            ], 500);
        }
    }

    /**
     * Get booked time slots for a specific date
     */
    public function getBookedTimeSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $date = $request->date;
            
            // Get booked time slots for this specific date (excluding completed/cancelled)
            $bookedTimeSlots = \App\Models\Booking::where('appointment_date', $date)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->whereNotNull('appointment_time')
                ->select('appointment_time')
                ->pluck('appointment_time')
                ->map(function($time) {
                    // Ensure time is in H:i format
                    return \Carbon\Carbon::parse($time)->format('H:i');
                })
                ->toArray();
            
            Log::info('Booked time slots retrieved', [
                'date' => $date,
                'booked_time_slots' => $bookedTimeSlots
            ]);
            
            return response()->json([
                'success' => true,
                'booked_time_slots' => $bookedTimeSlots,
                'date' => $date
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting booked time slots: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving booked time slots'
            ], 500);
        }
    }
} 