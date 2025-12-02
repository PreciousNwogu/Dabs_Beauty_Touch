<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingConfirmation;

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

            // Get booked time slots for the requested date (exclude completed/cancelled)
            $bookedTimeSlots = \App\Models\Booking::where('appointment_date', $date)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->whereNotNull('appointment_time')
                ->select('appointment_time')
                ->pluck('appointment_time')
                ->map(function($time) {
                    return \Carbon\Carbon::parse($time)->format('H:i');
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'booked_time_slots' => $bookedTimeSlots,
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

        // Normalize length input: accept kb_length (kids selector), hair_length (client) and convert hyphens to underscores
        $kbLengthRaw = $request->input('kb_length');
        if ($kbLengthRaw) {
            $normalizedKb = str_replace('-', '_', $kbLengthRaw);
            $request->merge(['kb_length' => $normalizedKb]);
        }

        $lengthRaw = $request->input('hair_length') ?? $request->input('length');
        if ($lengthRaw) {
            $normalized = str_replace('-', '_', $lengthRaw);
            $request->merge(['length' => $normalized]);
        }

        // Handle sample_picture validation separately to avoid empty file issues
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_email' => 'nullable|email|max:255',
            'other_email' => 'nullable|email|max:255',
            'kids_email' => 'nullable|email|max:255',
            'booking_email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            // 'length' will be required for most services but not for Hair Mask/Relaxing
            'service' => 'nullable|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'message' => 'nullable|string|max:1000'
        ];

        // If the user is booking Hair Mask/Relaxing, require a mask option instead of length
        $serviceTypeInput = $request->input('service_type') ?? $request->input('service');
        $serviceTypeNormalized = strtolower(trim((string)$serviceTypeInput));
        $isHairMask = (
            $serviceTypeNormalized === 'hair-mask' ||
            str_contains($serviceTypeNormalized, 'hair-mask') ||
            str_contains($serviceTypeNormalized, 'hair mask') ||
            str_contains($serviceTypeNormalized, 'hairmask') ||
            str_contains($serviceTypeNormalized, 'mask/relax') ||
            str_contains($serviceTypeNormalized, 'relaxing')
        );

        if ($isHairMask) {
            // hair mask - length optional, require hair_mask_option
            $validationRules['length'] = 'nullable|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
            $validationRules['hair_mask_option'] = 'required|string|in:mask-only,mask-with-weave';
        } else {
            $validationRules['length'] = 'required|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
        }

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

            // Check if this is an API request or a web request
            $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';

            if ($isApiRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please check your information and try again.',
                    'errors' => $validator->errors()
                ], 422);
            } else {
                return redirect()->route('home')
                    ->withErrors($validator)
                    ->withInput()
                    ->with('booking_error', true);
            }
        }

        // Additional validation: require at least one email candidate so we can reliably send confirmations
        $emailCandidates = array_filter([
            trim((string)$request->input('email', '')),
            trim((string)$request->input('contact_email', '')),
            trim((string)$request->input('other_email', '')),
            trim((string)$request->input('kids_email', '')),
            trim((string)$request->input('booking_email', '')),
        ]);

        if (empty($emailCandidates)) {
            Log::warning('Appointment booking validation failed: no email provided', ['request_keys' => array_keys($request->all())]);

            $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';
            if ($isApiRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide an email address so we can send a booking confirmation.',
                    'errors' => ['email' => ['At least one valid email is required.']]
                ], 422);
            } else {
                return redirect()->route('home')
                    ->withErrors(['email' => 'Please provide an email address so we can send a booking confirmation.'])
                    ->withInput()
                    ->with('booking_error', true);
            }
        }

        try {
            // Check if this date is already booked with non-completed appointment
            $existingBooking = \App\Models\Booking::where('appointment_date', $request->appointment_date)
                ->where('status', '!=', 'completed')
                ->first();

            if ($existingBooking) {
                // Check if this is an API request or a web request
                $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';

                if ($isApiRequest) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This date is already booked with another appointment. Please select a different date.'
                    ], 422);
                } else {
                    return redirect()->route('home')
                        ->with([
                            'booking_error' => true,
                            'error_message' => 'This date is already booked. Please select a different date.'
                        ]);
                }
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

            // Compute final price based on selected length and per-service base price.
            // Prefer kids selector length (`kb_length`) when present, otherwise use normalized `length`.
            $length = $request->input('kb_length') ?? $request->input('length', 'mid_back');

            // Lookup service base price if provided; fall back to 150.00
            $serviceInput = $request->input('service');
            $serviceModel = null;
            if (!empty($serviceInput)) {
                // Try slug first, then name
                $serviceModel = \App\Models\Service::where('slug', $serviceInput)->orWhere('name', $serviceInput)->first();
            }
            $basePrice = $serviceModel ? (float) $serviceModel->base_price : 150.00;

            // If this is Hair Mask/Relaxing, compute addon based on mask option (+30 for weave)
            $serviceType = $request->input('service_type') ?? $request->input('service');
            $serviceTypeNormalized = strtolower(trim((string)$serviceType));
            $isHairMask = (
                $serviceTypeNormalized === 'hair-mask' ||
                str_contains($serviceTypeNormalized, 'hair-mask') ||
                str_contains($serviceTypeNormalized, 'hair mask') ||
                str_contains($serviceTypeNormalized, 'hairmask') ||
                str_contains($serviceTypeNormalized, 'mask/relax') ||
                str_contains($serviceTypeNormalized, 'relaxing')
            );

            Log::info('Hair-mask detection', [
                'service_type_raw' => $serviceType,
                'service_type_normalized' => $serviceTypeNormalized,
                'hair_mask_option_raw' => $request->input('hair_mask_option', null),
            ]);

            // Defensive rule: only apply `hair_mask_option` when this is actually a hair-mask service.
            // If the client explicitly submitted a `hair_mask_option` but the service is NOT hair-mask,
            // we will ignore it to prevent it from affecting unrelated services.
            $explicitMaskOption = $request->input('hair_mask_option', null);
            if ($explicitMaskOption !== null && $isHairMask) {
                // prefer explicit service model price if available, otherwise default to $50
                $basePrice = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                $addon = ($explicitMaskOption === 'mask-with-weave') ? 30.00 : 0.00;
                $adjust = $addon; // persist as length_adjustment for email fidelity
                $finalPrice = round($basePrice + $addon, 2);
            } elseif ($isHairMask) {
                // prefer explicit service model price if available, otherwise default to $50
                $basePrice = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                $maskOption = $request->input('hair_mask_option', 'mask-only');
                $addon = ($maskOption === 'mask-with-weave') ? 30.00 : 0.00;
                $adjust = $addon; // persist as length_adjustment for email fidelity
                $finalPrice = round($basePrice + $addon, 2);
            } else {
                // Two-step rule: every two steps away from mid_back changes price by $20.
                $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
                $midIndex = array_search('mid_back', $ordered, true);
                $idx = array_search($length, $ordered, true);

                if ($idx === false || $midIndex === false) {
                    $adjust = 0.00;
                } else {
                    $d = $idx - $midIndex;
                    // Per-step rule: each single step away from mid_back changes price by $20.
                    // This makes waist = +20, bra_strap = -20, and two steps away = +/-40, etc.
                    $adjust = ($d * 20.00);
                }
                $finalPrice = round($basePrice + $adjust, 2);
            }

            // Log pricing calculation details for debugging
            Log::info('Pricing calculation', [
                'service_input' => $serviceInput,
                'service_model' => $serviceModel ? $serviceModel->toArray() : null,
                'base_price' => $basePrice,
                'length' => $length,
                'adjust' => $adjust,
                'final_price' => $finalPrice
            ]);

            // Resolve customer email from multiple possible input names (carousel/forms may use different ids)
            $emailCandidates = [
                'email',
                'contact_email',
                'other_email',
                'kids_email',
                'booking_email'
            ];

            $resolvedEmail = null;
            foreach ($emailCandidates as $c) {
                $val = trim((string) $request->input($c, ''));
                if (!empty($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $resolvedEmail = $val;
                    break;
                }
            }

            // Create the booking and persist kb_* selector fields, length and final_price
            $booking = \App\Models\Booking::create([
                'name' => $request->name,
                'email' => $resolvedEmail ?: ($request->email ?: 'no-email@example.com'),
                'phone' => $request->phone,
                'service' => $request->service ?: 'General Service',
                'length' => $length,
                'kb_braid_type' => $request->input('kb_braid_type'),
                'kb_finish' => $request->input('kb_finish'),
                'kb_length' => $request->input('kb_length') ?? null,
                'kb_extras' => $request->input('kb_extras') ?? null,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'message' => $request->message,
                'sample_picture' => $samplePicturePath,
                // Persist base price and length adjustment for email fidelity
                'base_price' => $basePrice,
                'length_adjustment' => $adjust,
                'hair_mask_option' => ($isHairMask ? $request->input('hair_mask_option') : null),
                'final_price' => $finalPrice,
                'status' => 'pending'
            ]);
                try {
                    // Use the resolved email we selected earlier if available
                    $notifyEmail = $resolvedEmail ?: ($booking->email && $booking->email !== 'no-email@example.com' ? $booking->email : null);
                    Log::info('Resolved customer email for booking (pre-send)', ['booking_id' => $booking->id, 'resolved_email' => $resolvedEmail, 'booking_email_field' => $booking->email]);

                    if (!empty($notifyEmail)) {
                        // Log mailer config so we can confirm which SMTP is used for web requests
                        Log::info('Mail configuration for booking confirmation (pre-send)', [
                            'mail_default' => config('mail.default'),
                            'mail_mailer_env' => env('MAIL_MAILER'),
                            'mail_host' => config('mail.mailers.smtp.host') ?? env('MAIL_HOST'),
                            'mail_port' => config('mail.mailers.smtp.port') ?? env('MAIL_PORT'),
                            'mail_username' => env('MAIL_USERNAME'),
                        ]);

                        try {
                            // Attempt immediate delivery via Notification sendNow
                            Notification::route('mail', $notifyEmail)->sendNow(new BookingConfirmation($booking));
                            Log::info('Booking confirmation notification sent (sendNow)', ['booking_id' => $booking->id, 'email' => $notifyEmail]);
                        } catch (\Throwable $notifyErr) {
                            Log::warning('Notification sendNow failed, attempting Mail fallback', ['booking_id' => $booking->id, 'email' => $notifyEmail, 'error' => $notifyErr->getMessage()]);
                            try {
                                \Illuminate\Support\Facades\Mail::to($notifyEmail)->send(new \App\Mail\BookingConfirmationMail($booking));
                                Log::info('Booking confirmation sent via Mail::to()->send() fallback', ['booking_id' => $booking->id, 'email' => $notifyEmail]);
                            } catch (\Throwable $mailErr) {
                                Log::error('Failed to send booking confirmation via Mail fallback', ['booking_id' => $booking->id, 'email' => $notifyEmail, 'error' => $mailErr->getMessage()]);
                            }
                        }
                    } else {
                        Log::info('No valid email provided; skipping booking confirmation notification', ['booking_id' => $booking->id, 'email' => $booking->email]);
                    }
            $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));
            $booking->confirmation_code = $confirmationCode;
            $booking->save();

            Log::info('New appointment booked', [
                'booking_id' => $bookingId,
                'confirmation_code' => $confirmationCode,
                'final_price' => $finalPrice,
                'length' => $booking->length
            ]);

            // Send booking confirmation email if a real email was provided
            try {
                if (!empty($booking->email) && $booking->email !== 'no-email@example.com') {
                    // Log mailer config so we can confirm which SMTP is used for web requests
                    Log::info('Mail configuration for booking confirmation', [
                        'mail_default' => config('mail.default'),
                        'mail_mailer_env' => env('MAIL_MAILER'),
                        'mail_host' => config('mail.mailers.smtp.host') ?? env('MAIL_HOST'),
                        'mail_port' => config('mail.mailers.smtp.port') ?? env('MAIL_PORT'),
                        'mail_username' => env('MAIL_USERNAME'),
                    ]);

                    // Attempt immediate delivery via Notification sendNow, with Mail fallback
                    try {
                        Notification::route('mail', $booking->email)->sendNow(new BookingConfirmation($booking));
                        Log::info('Booking confirmation notification sent (sendNow)', ['booking_id' => $booking->id, 'email' => $booking->email]);
                    } catch (\Throwable $notifyErr) {
                        Log::warning('Notification sendNow failed (post-save), attempting Mail fallback', ['booking_id' => $booking->id, 'email' => $booking->email, 'error' => $notifyErr->getMessage()]);
                        try {
                            \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\BookingConfirmationMail($booking));
                            Log::info('Booking confirmation sent via Mail::to()->send() fallback (post-save)', ['booking_id' => $booking->id, 'email' => $booking->email]);
                        } catch (\Throwable $mailErr) {
                            Log::error('Failed to send booking confirmation via Mail fallback (post-save)', ['booking_id' => $booking->id, 'email' => $booking->email, 'error' => $mailErr->getMessage()]);
                        }
                    }
                } else {
                    Log::info('No valid email provided; skipping booking confirmation notification', ['booking_id' => $booking->id, 'email' => $booking->email]);
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to send booking confirmation notification', [
                    'booking_id' => $booking->id,
                    'email' => $booking->email,
                    'error' => $e->getMessage()
                ]);
            }

            // Ensure clean JSON response
            if (ob_get_level()) {
                ob_clean();
            }

            // Check if this is an API request or a web request
            $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';

            if ($isApiRequest) {
                // Return JSON for AJAX/API requests
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment booked successfully!',
                        'appointment' => [
                        'booking_id' => $bookingId,
                        'confirmation_code' => $confirmationCode,
                        'final_price' => $finalPrice,
                        'length' => $booking->length,
                        'appointment_date' => date('l, F j, Y', strtotime($request->appointment_date)),
                        'appointment_time' => date('g:i A', strtotime($request->appointment_time)),
                        'service' => $request->service ?: 'General Service',
                        'email_provided' => !empty($resolvedEmail) || !empty($request->email)
                    ]
                ]);
            } else {
                // Return redirect with flash message for regular form submissions
                return redirect()->route('home')->with([
                    'booking_success' => true,
                    'booking_details' => [
                        'booking_id' => $bookingId,
                        'confirmation_code' => $confirmationCode,
                        'final_price' => $finalPrice,
                        'length' => $booking->length,
                        'appointment_date' => date('l, F j, Y', strtotime($request->appointment_date)),
                        'appointment_time' => date('g:i A', strtotime($request->appointment_time)),
                        'service' => $request->service ?: 'General Service'
                    ]
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage());
            Log::error('Error details: ' . $e->getTraceAsString());

            // Ensure clean response
            if (ob_get_level()) {
                ob_clean();
            }

            // Check if this is an API request or a web request
            $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';

            if ($isApiRequest) {
                // Return JSON error for AJAX/API requests
                return response()->json([
                    'success' => false,
                    'message' => 'We apologize, but there was an error processing your appointment. Please try again or contact us directly.',
                    'error_details' => 'Technical error occurred. Please try again.'
                ], 500);
            } else {
                // Return redirect with error message for regular form submissions
                return redirect()->route('home')->with([
                    'booking_error' => true,
                    'error_message' => 'We apologize, but there was an error processing your appointment. Please try again or contact us directly.'
                ]);
            }
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
                        'confirmation_code' => $booking->confirmation_code,
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
            // Use Booking model since that's where form data is saved
            $stats = [
                'total' => \App\Models\Booking::count(),
                'today' => \App\Models\Booking::whereDate('appointment_date', today())->count(),
                'pending' => \App\Models\Booking::where('status', 'pending')->count(),
                'confirmed' => \App\Models\Booking::where('status', 'confirmed')->count(),
                'completed' => \App\Models\Booking::where('status', 'completed')->count(),
                'cancelled' => \App\Models\Booking::where('status', 'cancelled')->count()
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
                // Format date safely
                $formattedDate = $booking->appointment_date;
                if ($formattedDate) {
                    try {
                        $formattedDate = is_string($booking->appointment_date)
                            ? date('M j, Y', strtotime($booking->appointment_date))
                            : $booking->appointment_date->format('M j, Y');
                    } catch (\Exception $e) {
                        $formattedDate = $booking->appointment_date;
                    }
                }

                return response()->json([
                    'success' => true,
                    'appointment' => [
                        'id' => $booking->id,
                        'name' => $booking->name,
                        'email' => $booking->email,
                        'phone' => $booking->phone,
                        'service' => $booking->service,
                        'appointment_date' => $formattedDate,
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
