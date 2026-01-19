<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingConfirmation;
use App\Services\PriceCalculator;
use Carbon\Carbon;

use Illuminate\Http\JsonResponse;

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
            $normalizedKb = str_replace(['-', ' '], '_', strtolower((string)$kbLengthRaw));
            // map common synonyms to canonical keys
            $synMap = [
                'tail_bone' => 'tailbone',
                'tail-bone' => 'tailbone',
                'tail bone' => 'tailbone',
                'tailbone' => 'tailbone',
                'midback' => 'mid_back',
                'mid_back' => 'mid_back',
                'brastrap' => 'bra_strap',
                'brastrap' => 'bra_strap',
                'bra_strap' => 'bra_strap'
            ];
            if (isset($synMap[$normalizedKb])) {
                $normalizedKb = $synMap[$normalizedKb];
            }
            $request->merge(['kb_length' => $normalizedKb]);
        }

        $lengthRaw = $request->input('hair_length') ?? $request->input('length');
        if ($lengthRaw) {
            $normalized = str_replace(['-', ' '], '_', strtolower((string)$lengthRaw));
            $synMap = [
                'tail_bone' => 'tailbone',
                'tail-bone' => 'tailbone',
                'tail bone' => 'tailbone',
                'tailbone' => 'tailbone',
                'midback' => 'mid_back',
                'mid_back' => 'mid_back',
                'brastrap' => 'bra_strap',
                'brastrap' => 'bra_strap',
                'bra_strap' => 'bra_strap'
            ];
            if (isset($synMap[$normalized])) {
                $normalized = $synMap[$normalized];
            }
            $request->merge(['length' => $normalized]);
        }

        // Determine service type early so we can tailor validation (require length for braids)
        $serviceTypeInput = $request->input('service_type') ?? $request->input('service');
        $serviceTypeNormalized = strtolower(trim((string)$serviceTypeInput));
        $isHairMask = (
            $serviceTypeNormalized === 'hair-mask' ||
            str_contains($serviceTypeNormalized, 'hair-mask') ||
            str_contains($serviceTypeNormalized, 'hair mask') ||
            str_contains($serviceTypeNormalized, 'hairmask') ||
            str_contains($serviceTypeNormalized, 'mask/relax') ||
            str_contains($serviceTypeNormalized, 'relaxing') ||
            str_contains($serviceTypeNormalized, 'retouch')
        );

        $isBraid = (
            str_contains($serviceTypeNormalized, 'braid') ||
            str_contains($serviceTypeNormalized, 'braids') ||
            str_contains($serviceTypeNormalized, 'knotless') ||
            str_contains($serviceTypeNormalized, 'knot')
        );

        $isStitch = (
            str_contains($serviceTypeNormalized, 'stitch') ||
            str_contains(strtolower((string) $request->input('service', '')), 'stitch')
        );

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

        // Tailor length rules based on service type
        if ($isHairMask) {
            // hair mask - length optional, require hair_mask_option
            $validationRules['length'] = 'nullable|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
            $validationRules['hair_mask_option'] = 'required|string|in:mask-only,mask-with-weave';
        } elseif ($isBraid) {
            // For braid/knotless services, require either kb_length or length (one of them)
            $validationRules['length'] = 'required_without:kb_length|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
            $validationRules['kb_length'] = 'required_without:length|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
        } else {
            $validationRules['length'] = 'required|string|in:neck,shoulder,armpit,bra_strap,mid_back,waist,hip,tailbone,classic';
        }

        // Stitch rows option: only required for stitch braids
        if ($isStitch) {
            $validationRules['stitch_rows_option'] = 'required|string|in:ten_or_less,more_than_ten';
        } else {
            $validationRules['stitch_rows_option'] = 'nullable|string|in:ten_or_less,more_than_ten';
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


            // Enforce length for braid/knotless services (runtime guard)
            $serviceTypeInput = $request->input('service_type') ?? $request->input('service');
            $serviceTypeNormalized = strtolower(trim((string)$serviceTypeInput));
            $isBraid = (
                str_contains($serviceTypeNormalized, 'braid') ||
                str_contains($serviceTypeNormalized, 'braids') ||
                str_contains($serviceTypeNormalized, 'knotless') ||
                str_contains($serviceTypeNormalized, 'knot')
            );
            if ($isBraid) {
                $selectedLength = $request->input('kb_length') ?? $request->input('length');
                if (empty($selectedLength)) {
                    Log::warning('Appointment booking validation failed: missing length for braid service', ['request_keys' => array_keys($request->all())]);
                    $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';
                    if ($isApiRequest) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Please select a hair length for braid/knotless services.',
                            'errors' => ['length' => ['Please select a hair length for this service.']]
                        ], 422);
                    } else {
                        return redirect()->route('home')
                            ->withErrors(['length' => 'Please select a hair length for this service.'])
                            ->withInput()
                            ->with('booking_error', true);
                    }
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

            // Check if this date/time is blocked (only block full-day blocks or if time falls within blocked range)
            $appointmentDate = \Carbon\Carbon::parse($request->appointment_date)->startOfDay();
            $appointmentTime = $request->appointment_time ?? null;

            // Get all blocked schedules that overlap with this date
            $blockedSchedules = \App\Models\Schedule::where('type', 'blocked')
                ->where('start', '<=', $appointmentDate->copy()->endOfDay())
                ->where('end', '>', $appointmentDate)
                ->get();

            foreach ($blockedSchedules as $blockedSchedule) {
                $startParsed = \Carbon\Carbon::parse($blockedSchedule->start)->utc();
                $endParsed = \Carbon\Carbon::parse($blockedSchedule->end)->utc();

                // Check if it's a full-day block
                $isAllDay = $startParsed->format('H:i:s') === '00:00:00' &&
                           $endParsed->format('H:i:s') === '00:00:00';

                if ($isAllDay) {
                    // Full-day block: check if this date falls within the block range
                    $blockStartDate = $startParsed->format('Y-m-d');
                    $blockEndDate = $endParsed->format('Y-m-d');
                    $requestedDate = $appointmentDate->format('Y-m-d');

                    if ($requestedDate >= $blockStartDate && $requestedDate < $blockEndDate) {
                        $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';
                        $blockedTitle = $blockedSchedule->title ?? 'Blocked';

                        if ($isApiRequest) {
                            return response()->json([
                                'success' => false,
                                'message' => "This date is blocked: \"{$blockedTitle}\". Please select a different date."
                            ], 422);
                        } else {
                            return redirect()->route('home')
                                ->with([
                                    'booking_error' => true,
                                    'error_message' => "This date is blocked: \"{$blockedTitle}\". Please select a different date."
                                ]);
                        }
                    }
                } else {
                    // Time-specific block: only block if the selected time falls within the blocked range
                    if ($appointmentTime) {
                        try {
                            $requestedDateTime = \Carbon\Carbon::parse($request->appointment_date . ' ' . $appointmentTime);
                            $blockStart = $startParsed->copy()->setTimezone(config('app.timezone') ?: 'UTC');
                            $blockEnd = $endParsed->copy()->setTimezone(config('app.timezone') ?: 'UTC');

                            // Check if the requested date matches the block date(s)
                            $blockStartDate = $blockStart->format('Y-m-d');
                            $blockEndDate = $blockEnd->format('Y-m-d');
                            $requestedDate = $appointmentDate->format('Y-m-d');

                            if ($requestedDate >= $blockStartDate && $requestedDate <= $blockEndDate) {
                                // Check if the time falls within the blocked range
                                if ($requestedDateTime->gte($blockStart) && $requestedDateTime->lt($blockEnd)) {
                                    $isApiRequest = $request->expectsJson() || $request->is('api/*') || $request->header('X-Requested-With') === 'XMLHttpRequest';
                                    $blockedTitle = $blockedSchedule->title ?? 'Blocked';

                                    if ($isApiRequest) {
                                        return response()->json([
                                            'success' => false,
                                            'message' => "The selected time is blocked: \"{$blockedTitle}\". Please select a different time."
                                        ], 422);
                                    } else {
                                        return redirect()->route('home')
                                            ->with([
                                                'booking_error' => true,
                                                'error_message' => "The selected time is blocked: \"{$blockedTitle}\". Please select a different time."
                                            ]);
                                    }
                                }
                            }
                        } catch (\Exception $timeException) {
                            // If time parsing fails, continue with booking
                            Log::warning('Failed to check blocked time: ' . $timeException->getMessage());
                        }
                    }
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

            // Use the centralized PriceCalculator for all pricing logic and breakdowns
            $serviceInput = $request->input('service');
            $serviceModel = null;
            $serviceNameForSave = $serviceInput;
            if (!empty($serviceInput)) {
                $serviceModel = \App\Models\Service::where('slug', $serviceInput)->orWhere('name', $serviceInput)->first();
                if ($serviceModel) $serviceNameForSave = $serviceModel->name;
            }

            // If this is a hair mask service with weave option, append " with Weaving" to the service name
            $hairMaskOption = $request->input('hair_mask_option') ?? $request->input('selectedHairMaskOption');
            if ($hairMaskOption) {
                $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$hairMaskOption)));
                if (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) {
                    $serviceNameLower = strtolower($serviceNameForSave ?? '');
                    if (str_contains($serviceNameLower, 'hair mask') ||
                        str_contains($serviceNameLower, 'hair-mask') ||
                        str_contains($serviceNameLower, 'relaxing') ||
                        str_contains($serviceNameLower, 'retouch')) {
                        // Only append if not already there
                        if (!str_contains(strtolower($serviceNameForSave), 'with weaving')) {
                            $serviceNameForSave = trim($serviceNameForSave) . ' with Weaving';
                        }
                    }
                }
            }

            $calculator = new PriceCalculator();
            $calcInput = [
                'service_input' => $serviceInput,
                'service_model' => $serviceModel,
                'service_type' => $request->input('service_type') ?? $serviceInput,
                'length' => $request->input('length'),
                'kb_length' => $request->input('kb_length'),
                'kb_extras' => $request->input('kb_extras'),
                'hair_mask_option' => $request->input('hair_mask_option') ?? $request->input('selectedHairMaskOption'),
                'stitch_rows_option' => $request->input('stitch_rows_option'),
            ];

            $breakdown = $calculator->calculate($calcInput);

            $basePrice = $breakdown['base_price'] ?? 0.00;
            $adjust = $breakdown['length_adjustment'] ?? 0.00;
            $finalPrice = $breakdown['final_price'] ?? ($basePrice + $adjust);
            $priceWarning = null;

            // Merge normalized hair_mask_option back to request for persistence if provided by calculator
            if (!empty($breakdown['hair_mask_option_normalized'])) {
                $request->merge(['hair_mask_option' => $breakdown['hair_mask_option_normalized']]);
            }

            // Attach kids breakdown values for later persistence
            $kb_base_price = $breakdown['kb_base_price'] ?? null;
            $kb_length_adjustment = $breakdown['kb_length_adjustment'] ?? null;
            $kb_extras_total = $breakdown['kb_extras_total'] ?? null;
            $kb_final_price = $breakdown['kb_final_price'] ?? null;

            // Validate client-supplied final_price against the server calculation with tolerance
            $tolerance = is_numeric(env('PRICE_TOLERANCE')) ? (float) env('PRICE_TOLERANCE') : 1.00;
            $serverCalculatedFinal = $finalPrice;
            if ($request->filled('final_price') && is_numeric($request->input('final_price'))) {
                $clientFinal = round((float) $request->input('final_price'), 2);
                $diff = abs($clientFinal - $serverCalculatedFinal);
                if ($diff <= $tolerance) {
                    Log::info('Client-provided final_price within tolerance; accepting client value', [
                        'server_final' => $serverCalculatedFinal,
                        'client_final' => $clientFinal,
                        'difference' => $diff,
                        'tolerance' => $tolerance,
                        'service' => $serviceInput,
                    ]);
                    $finalPrice = $clientFinal;
                } else {
                    Log::error('Client final_price mismatch exceeds tolerance; overriding with server calculation', [
                        'server_final' => $serverCalculatedFinal,
                        'client_final' => $clientFinal,
                        'difference' => $diff,
                        'tolerance' => $tolerance,
                        'service' => $serviceInput,
                        'request_snapshot' => substr(json_encode(array_intersect_key($request->all(), array_flip(['service','service_type','length','kb_length','price','final_price','hair_mask_option']))), 0, 1000)
                    ]);
                    $finalPrice = $serverCalculatedFinal;
                    if (!empty($breakdown['is_hair_mask'])) {
                        $priceWarning = 'Client-submitted price did not match server calculation and was adjusted to the canonical price.';
                    }
                }
            }
            // Ensure length variable is set for logging/persistence
            $length = $request->input('kb_length') ?? $request->input('length', 'mid_back');
            if (is_string($length)) {
                $length = str_replace(['-', ' '], '_', strtolower($length));
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

            // Prepare kids-specific breakdown if this was a kids selector booking
            $kb_base_price = null;
            $kb_length_adjustment = null;
            $kb_final_price = null;
            $kb_extras_total = null;
            $isKidsFlow = ($request->filled('kb_length') || ($serviceTypeNormalized && str_contains($serviceTypeNormalized, 'kids')));
            if ($isKidsFlow) {
                // Determine kids base price from service model or config fallback
                $kb_base_price = $serviceModel ? (float) $serviceModel->base_price : (float) config('service_prices.kids_braids', 80);

                // Calculate all adjustments: type + length + finish (matching UI calculation)
                $typeAdj = ['protective'=>-20,'cornrows'=>-40,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];

                $kb_braid_type = $request->input('kb_braid_type');
                $kb_length = $request->input('kb_length') ?? $request->input('length');
                $kb_finish = $request->input('kb_finish');

                // Normalize kb_length
                if (is_string($kb_length)) {
                    $kb_length = str_replace(['-', ' '], '_', strtolower($kb_length));
                }

                // Calculate type adjustment
                $typeAdjustment = 0.00;
                if ($kb_braid_type && isset($typeAdj[$kb_braid_type])) {
                    $typeAdjustment = (float) $typeAdj[$kb_braid_type];
                }

                // Calculate length adjustment (using the selector mapping, not mid_back rule)
                $lengthAdjustment = 0.00;
                if ($kb_length && isset($lengthAdj[$kb_length])) {
                    $lengthAdjustment = (float) $lengthAdj[$kb_length];
                }

                // Calculate finish adjustment
                $finishAdjustment = 0.00;
                if ($kb_finish && isset($finishAdj[$kb_finish])) {
                    $finishAdjustment = (float) $finishAdj[$kb_finish];
                }

                // Total adjustments = type + length + finish
                $kb_total_adjustments = $typeAdjustment + $lengthAdjustment + $finishAdjustment;

                // Store length adjustment separately for backwards compatibility (but it's actually total adjustments)
                $kb_length_adjustment = $kb_total_adjustments;

                // Parse extras if provided (either numeric CSV or named extras)
                $kb_extras_total = 0.00;
                $kb_extras_raw = $request->input('kb_extras');
                if (!empty($kb_extras_raw)) {
                    if (is_string($kb_extras_raw) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $kb_extras_raw)) {
                        $parts = array_map('floatval', explode(',', $kb_extras_raw));
                        $kb_extras_total = array_sum($parts);
                    } else {
                        // named extras mapping
                        $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                        foreach (explode(',', $kb_extras_raw) as $it) {
                            $it = trim($it);
                            if (isset($addonMap[$it])) $kb_extras_total += $addonMap[$it];
                        }
                    }
                }

                // Final price = base + (type + length + finish adjustments) + addons
                $kb_final_price = round(($kb_base_price ?? 0) + $kb_total_adjustments + ($kb_extras_total ?? 0), 2);
                // If client submitted a final_price for kids flow, verify within tolerance and prefer server calc if mismatch large
                if ($request->filled('final_price') && is_numeric($request->input('final_price'))) {
                    $clientFinal = round((float) $request->input('final_price'), 2);
                    $tolerance = is_numeric(env('PRICE_TOLERANCE')) ? (float) env('PRICE_TOLERANCE') : 1.00;
                    if (abs($clientFinal - $kb_final_price) <= $tolerance) {
                        $kb_final_price = $clientFinal;
                    } else {
                        Log::warning('Kids client final_price mismatch; using server calc', ['server' => $kb_final_price, 'client' => $clientFinal]);
                    }
                }
            }

            // Create the booking and persist kb_* selector fields, length and final_price
            $booking = \App\Models\Booking::create([
                'name' => $request->name,
                'email' => $resolvedEmail ?: ($request->email ?: 'no-email@example.com'),
                'phone' => $request->phone,
                    // Save canonical service name if we resolved a Service model, otherwise store user-provided label
                    'service' => $serviceNameForSave ?: ($request->service ?: 'General Service'),
                'length' => $length,
                'kb_braid_type' => $request->input('kb_braid_type'),
                'kb_finish' => $request->input('kb_finish'),
                'kb_length' => $request->input('kb_length') ?? null,
                'kb_extras' => $request->input('kb_extras') ?? null,
                'kb_base_price' => $kb_base_price,
                'kb_length_adjustment' => $kb_length_adjustment,
                'kb_final_price' => $kb_final_price,
                'kb_extras_total' => $kb_extras_total,
                'appointment_date' => $request->appointment_date,
                // Persist appointment_time normalized to H:i (24h) format when possible
                'appointment_time' => (function($val){ try { return \Carbon\Carbon::parse($val)->format('H:i'); } catch (\Exception $e) { return $val; } })($request->appointment_time),
                'message' => $request->message,
                'sample_picture' => $samplePicturePath,
                // Persist base price and length adjustment for email fidelity
                'base_price' => $basePrice,
                'length_adjustment' => $adjust,
                'hair_mask_option' => ($isHairMask ? $request->input('hair_mask_option') : null),
                'stitch_rows_option' => $request->input('stitch_rows_option'),
                // For kids flow prefer kb_final_price as authoritative final price
                'final_price' => ($kb_final_price !== null) ? $kb_final_price : $finalPrice,
                'status' => 'pending'
            ]);
            $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
            $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));
            $booking->confirmation_code = $confirmationCode;
            $booking->save();

            // Log persisted booking details including what was stored for final_price
            Log::info('New appointment booked', [
                'booking_id' => $bookingId,
                'confirmation_code' => $confirmationCode,
                'final_price_persisted' => $booking->final_price,
                'server_calculated_final' => isset($serverCalculatedFinal) ? $serverCalculatedFinal : null,
                'client_submitted_final' => $request->filled('final_price') ? $request->input('final_price') : null,
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

                    // Attempt immediate delivery via Notification sendNow, with Mail fallback.
                    try {
                        Log::info('Attempting to send booking confirmation to customer', [
                            'booking_id' => $booking->id,
                            'email' => $booking->email,
                            'mail_from' => config('mail.from.address'),
                            'mailer' => config('mail.default')
                        ]);

                        Notification::route('mail', $booking->email)->sendNow(new BookingConfirmation($booking));
                        Log::info('Booking confirmation notification sent (sendNow)', ['booking_id' => $booking->id, 'email' => $booking->email]);
                    } catch (\Throwable $notifyErr) {
                        Log::warning('Notification sendNow failed (post-save), attempting Mail fallback', ['booking_id' => $booking->id, 'email' => $booking->email, 'error' => $notifyErr->getMessage(), 'trace' => $notifyErr->getTraceAsString()]);
                        try {
                            \Illuminate\Support\Facades\Mail::to($booking->email)->send(new \App\Mail\BookingConfirmationMail($booking));
                            Log::info('Booking confirmation sent via Mail::to()->send() fallback (post-save)', ['booking_id' => $booking->id, 'email' => $booking->email]);
                        } catch (\Throwable $mailErr) {
                            Log::error('Failed to send booking confirmation via Mail fallback (post-save)', ['booking_id' => $booking->id, 'email' => $booking->email, 'error' => $mailErr->getMessage(), 'trace' => $mailErr->getTraceAsString()]);
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
                ] + ($priceWarning ? ['price_warning' => $priceWarning] : []));
            } else {
                // Return redirect with flash message for regular form submissions
                $flash = [
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
                ];
                if ($priceWarning) $flash['price_warning'] = $priceWarning;
                return redirect()->route('home')->with($flash);
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
     * Return a server-side canonical price breakdown for given inputs.
     */
    public function previewPrice(Request $request): JsonResponse
    {
        try {
            $payload = $request->only(['service','service_type','kb_length','length','kb_extras','kb_braid_type','hair_mask_option','selectedHairMaskOption','stitch_rows_option']);
            $calculator = new PriceCalculator();
            $breakdown = $calculator->calculate($payload);
            return response()->json([
                'success' => true,
                'breakdown' => $breakdown
            ]);
        } catch (\Exception $e) {
            Log::error('Price preview failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to compute price'], 500);
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
                        'confirmed_at_formatted' => $booking->confirmed_at ? $booking->confirmed_at->setTimezone('America/Toronto')->format('F j, Y g:i A') : null,
                        'completed_at' => $booking->completed_at,
                        'completed_at_formatted' => $booking->completed_at ? $booking->completed_at->setTimezone('America/Toronto')->format('F j, Y g:i A') : null,
                        'cancelled_at' => $booking->cancelled_at,
                        'cancelled_at_formatted' => $booking->cancelled_at ? $booking->cancelled_at->setTimezone('America/Toronto')->format('F j, Y g:i A') : null,
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

    /**
     * Get available time slots for a specific date, filtering out booked and blocked slots
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $date = $request->date;
            $dateCarbon = \Carbon\Carbon::parse($date)->startOfDay();

            // Check if the entire date is blocked (all-day block)
            $appTz = config('app.timezone') ?: date_default_timezone_get();
            $dateStr = $dateCarbon->format('Y-m-d');
            $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $dateStr . ' 00:00:00', $appTz)->startOfDay();
            $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $dateStr . ' 23:59:59', $appTz)->endOfDay();

            $blockedSchedules = \App\Models\Schedule::where('type', 'blocked')
                ->where('start', '<', $endOfDay)
                ->where('end', '>', $startOfDay)
                ->get();

            // Check if there's a full-day block
            foreach ($blockedSchedules as $blockedSchedule) {
                $startParsed = Carbon::parse($blockedSchedule->start)->utc();
                $endParsed = Carbon::parse($blockedSchedule->end)->utc();

                // Check if it's an all-day block
                $isAllDay = $startParsed->format('H:i:s') === '00:00:00' &&
                           $endParsed->format('H:i:s') === '00:00:00';

                if ($isAllDay) {
                    // Check if this date falls within the all-day block range
                    $blockStartDate = $startParsed->format('Y-m-d');
                    $blockEndDate = $endParsed->format('Y-m-d');

                    if ($dateStr >= $blockStartDate && $dateStr < $blockEndDate) {
                        return response()->json([
                            'success' => true,
                            'slots' => [],
                            'message' => $blockedSchedule->title ?? 'This date is blocked',
                            'date' => $date
                        ]);
                    }
                }
            }

            // Default available time slots (9 AM to 6 PM)
            // Note: Lunch/break time is controlled via blocked schedules, not hardcoded exclusions.
            $defaultSlots = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];

            // Get booked time slots
            $bookedTimeSlots = \App\Models\Booking::where('appointment_date', $date)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->whereNotNull('appointment_time')
                ->pluck('appointment_time')
                ->map(function($time) {
                    return \Carbon\Carbon::parse($time)->format('H:i');
                })
                ->toArray();

            // Get blocked time ranges for this date
            $blockedTimeRanges = [];
            $dateStr = $dateCarbon->format('Y-m-d');
            $startOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $dateStr . ' 00:00:00', $appTz)->startOfDay();
            $endOfDay = Carbon::createFromFormat('Y-m-d H:i:s', $dateStr . ' 23:59:59', $appTz)->endOfDay();

            $blockedSchedules = \App\Models\Schedule::where('type', 'blocked')
                ->where('start', '<', $endOfDay)
                ->where('end', '>', $startOfDay)
                ->get();

            foreach ($blockedSchedules as $block) {
                // Parse from UTC (as stored) first
                $startParsedUTC = Carbon::parse($block->start)->utc();
                $endParsedUTC = Carbon::parse($block->end)->utc();

                // Check if it's an all-day block
                $isAllDay = $startParsedUTC->format('H:i:s') === '00:00:00' &&
                           $endParsedUTC->format('H:i:s') === '00:00:00';

                if (!$isAllDay) {
                    // For time-specific blocks stored with old code, the UTC times need to be converted
                    // to app timezone to get the actual local times
                    $startParsed = $startParsedUTC->copy()->setTimezone($appTz);
                    $endParsed = $endParsedUTC->copy()->setTimezone($appTz);

                    // Check if this block overlaps with the requested date
                    $blockStartDate = $startParsed->format('Y-m-d');
                    $blockEndDate = $endParsed->format('Y-m-d');

                    // Check if the requested date falls within the block's date range
                    if ($dateStr >= $blockStartDate && $dateStr <= $blockEndDate) {
                        // Get the intersection with the requested date
                        $dayStart = $dateCarbon->copy()->setTimezone($appTz)->startOfDay();
                        $dayEnd = $dateCarbon->copy()->setTimezone($appTz)->endOfDay();

                        $blockStart = $startParsed->copy();
                        if ($blockStart->lt($dayStart)) $blockStart = $dayStart->copy();

                        $blockEnd = $endParsed->copy();
                        if ($blockEnd->gt($dayEnd)) $blockEnd = $dayEnd->copy();

                        if ($blockStart->lt($blockEnd)) {
                            $blockedTimeRanges[] = [
                                'start' => $blockStart->format('H:i'),
                                'end' => $blockEnd->format('H:i'),
                            ];

                            Log::debug('Added blocked time range', [
                                'block_id' => $block->id,
                                'stored_utc_start' => $startParsedUTC->format('Y-m-d H:i:s'),
                                'stored_utc_end' => $endParsedUTC->format('Y-m-d H:i:s'),
                                'converted_start' => $startParsed->format('Y-m-d H:i:s'),
                                'converted_end' => $endParsed->format('Y-m-d H:i:s'),
                                'blocked_start' => $blockStart->format('H:i'),
                                'blocked_end' => $blockEnd->format('H:i'),
                                'date' => $date,
                                'app_timezone' => $appTz,
                            ]);
                        }
                    }
                }
            }

            // Log blocked time ranges for debugging
            Log::debug('Blocked time ranges for date', [
                'date' => $date,
                'blocked_ranges' => $blockedTimeRanges,
            ]);

            // Filter out blocked and booked slots
            $availableSlots = [];
            foreach ($defaultSlots as $slotTime) {
                $isBooked = in_array($slotTime, $bookedTimeSlots);

                // Check if slot falls within any blocked time range
                $isBlocked = false;
                foreach ($blockedTimeRanges as $range) {
                    // Parse times in the same timezone for comparison
                    $slotDateTime = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $slotTime, $appTz);
                    $rangeStart = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $range['start'], $appTz);
                    $rangeEnd = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $range['end'], $appTz);

                    // Check if slot time falls within the blocked range.
                    // Treat blocked ranges as [start, end) so a lunch block 12:00–13:00 does NOT block the 13:00 slot.
                    if ($slotDateTime->gte($rangeStart) && $slotDateTime->lt($rangeEnd)) {
                        $isBlocked = true;
                        Log::debug('Slot blocked', [
                            'slot_time' => $slotTime,
                            'range_start' => $range['start'],
                            'range_end' => $range['end'],
                        ]);
                        break;
                    }
                }

                if (!$isBooked && !$isBlocked) {
                    $hour = (int)substr($slotTime, 0, 2);
                    $minute = substr($slotTime, 3, 2);
                    $formattedTime = date('g:i A', mktime($hour, $minute, 0));

                    $availableSlots[] = [
                        'time' => $slotTime,
                        'available' => true,
                        'formatted_time' => $formattedTime,
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'slots' => $availableSlots,
                'date' => $date
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting available time slots: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving available time slots'
            ], 500);
        }
    }
}
