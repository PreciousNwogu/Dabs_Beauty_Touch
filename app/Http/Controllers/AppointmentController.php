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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if slot is still available
            if (!Appointment::isSlotAvailable($request->appointment_date, $request->appointment_time)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is no longer available. Please select another time.'
                ], 409);
            }

            // Create the appointment
            $appointment = Appointment::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'service' => $request->service,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
                'status' => 'confirmed'
            ]);

            Log::info('New appointment booked', [
                'booking_id' => $appointment->booking_id,
                'confirmation_code' => $appointment->confirmation_code
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'appointment' => [
                    'booking_id' => $appointment->booking_id,
                    'confirmation_code' => $appointment->confirmation_code,
                    'appointment_date' => $appointment->appointment_date->format('l, F j, Y'),
                    'appointment_time' => $appointment->appointment_time->format('g:i A'),
                    'service' => $appointment->service
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error booking appointment. Please try again.'
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
            $query = Appointment::query();

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
            $appointments = $query->orderBy('appointment_date', 'asc')
                                 ->orderBy('appointment_time', 'asc')
                                 ->get();

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
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appointment = Appointment::find($request->appointment_id);

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment not found'
                ], 404);
            }

            $appointment->update([
                'status' => $request->status,
                'notes' => $request->notes ?: $appointment->notes
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
} 