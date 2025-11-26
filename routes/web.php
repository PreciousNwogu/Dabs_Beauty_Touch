<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

// Main route - show the home page
Route::get('/', function () {
    $servicePrices = Service::pluck('base_price', 'slug')->toArray();
    return view('home', compact('servicePrices'));
})->name('home');

// Basic admin routes for services (protect with middleware in production)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('services/{service}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
    Route::post('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
});

// CSRF Token refresh route
Route::get('/csrf-token', function (Request $request) {
    return response()->json([
        'token' => csrf_token()
    ]);
})->name('csrf.token');

// Clear session route (temporary fix for persistent success messages)
Route::get('/clear-session', function (Request $request) {
    session()->forget(['booking_success', 'booking_details', 'booking_error', 'error_message']);

    // Handle AJAX requests
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['success' => true, 'message' => 'Session cleared']);
    }

    return redirect()->route('home');
})->name('clear.session');

// Get booked dates for calendar
Route::get('/api/booked-dates', function (Request $request) {
    try {
        // Only get dates with pending or confirmed bookings (exclude cancelled and completed)
        $bookedDates = \App\Models\Booking::whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('appointment_date, COUNT(*) as booking_count')
            ->groupBy('appointment_date')
            ->get()
            ->map(function ($booking) {
                // Format date as YYYY-MM-DD for JavaScript
                $formattedDate = \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d');
                return [
                    'date' => $formattedDate,
                    'original_date' => $booking->appointment_date,
                    'count' => $booking->booking_count,
                    'disabled' => true // Disable all dates with pending or confirmed bookings
                ];
            });

        \Illuminate\Support\Facades\Log::info('Booked dates API response:', [
            'total_bookings_in_db' => \App\Models\Booking::count(),
            'pending_bookings' => \App\Models\Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => \App\Models\Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => \App\Models\Booking::where('status', 'completed')->count(),
            'cancelled_bookings' => \App\Models\Booking::where('status', 'cancelled')->count(),
            'dates_to_disable' => $bookedDates->count(),
            'booked_dates' => $bookedDates->toArray()
        ]);

        return response()->json([
            'success' => true,
            'booked_dates' => $bookedDates
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to fetch booked dates: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch booked dates'
        ], 500);
    }
})->name('api.booked-dates');

// Test upload route
Route::get('/test-upload', function () {
    return view('test-upload');
});

// Test database route
Route::get('/test-db', function () {
    try {
        $count = \App\Models\Booking::count();
        $lastBooking = \App\Models\Booking::latest()->first();
        return response()->json([
            'database_status' => 'Connected',
            'total_bookings' => $count,
            'last_booking' => $lastBooking ? [
                'id' => $lastBooking->id,
                'name' => $lastBooking->name,
                'created_at' => $lastBooking->created_at
            ] : 'No bookings found',
            'connection_test' => 'OK'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'database_status' => 'Error',
            'error' => $e->getMessage(),
            'connection_test' => 'FAILED'
        ], 500);
    }
});

Route::post('/test-upload', function (Request $request) {
    $tempDir = storage_path('temp');
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    if (function_exists('ini_set')) {
        ini_set('upload_tmp_dir', $tempDir);
    }

    $result = [
        'temp_dir' => $tempDir,
        'temp_dir_exists' => file_exists($tempDir),
        'temp_dir_writable' => is_writable($tempDir),
        'has_file' => $request->hasFile('sample_picture'),
        'php_upload_tmp_dir' => ini_get('upload_tmp_dir'),
        'sys_temp_dir' => sys_get_temp_dir(),
    ];

    if ($request->hasFile('sample_picture')) {
        $file = $request->file('sample_picture');
        $result['file_valid'] = $file->isValid();
        $result['file_error'] = $file->getError();
        $result['file_size'] = $file->getSize();
        $result['file_name'] = $file->getClientOriginalName();

        if ($file->isValid()) {
            try {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/uploads/test', $filename);
                $result['upload_success'] = true;
                $result['upload_path'] = $path;
            } catch (\Exception $e) {
                $result['upload_success'] = false;
                $result['upload_error'] = $e->getMessage();
            }
        }
    }

    return response()->json($result);
});

// (test email route removed)

// Debug route to test HTTPS and security
Route::get('/debug/security', function (Request $request) {
    return response()->json([
        'timestamp' => now(),
        'environment' => config('app.env'),
        'app_url' => config('app.url'),
        'request_url' => $request->url(),
        'is_secure' => $request->secure(),
        'scheme' => $request->getScheme(),
        'host' => $request->getHost(),
        'headers' => [
            'x-forwarded-proto' => $request->header('X-Forwarded-Proto'),
            'x-forwarded-for' => $request->header('X-Forwarded-For'),
            'user-agent' => $request->userAgent(),
        ],
        'session' => [
            'driver' => config('session.driver'),
            'secure' => config('session.secure'),
            'same_site' => config('session.same_site'),
        ],
        'csrf_token' => csrf_token(),
    ]);
})->name('debug.security');

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

// Kids Braids Selector page
Route::get('/kids-selector', function () {
    // Pass service prices to the selector page (from config or Service model)
    $servicePrices = config('service_prices', []);
    return view('kids-selector', compact('servicePrices'));
})->name('kids.selector');

// Handle kids selector submission (server-side) and redirect to home with flashed session
Route::post('/kids-selector/submit', function (Request $request) {
    $data = $request->validate([
        'kb_braid_type' => 'required|string',
        'kb_finish' => 'nullable|string',
        'kb_length' => 'required|string',
        'extras' => 'nullable|string',
        'price' => 'required|numeric'
    ]);

    // Normalize payload
    $payload = [
        'service' => 'Kids Braids',
        'service_type' => 'kids-braids',
        'price' => (float) $data['price'],
        'hair_length' => $data['kb_length'],
        'braid_type' => $data['kb_braid_type'],
        'finish' => $data['kb_finish'] ?? null,
        'extras' => $data['extras'] ?? null,
    ];

    // Flash to session for one-time consumption on home page
    return redirect()->route('home')->with('kids_selector', $payload);
})->name('kids.selector.submit');

// Admin authentication routes (unprotected but rate limited) - TEMPORARY SIMPLE VERSION
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

// TEMPORARY: Check database status
Route::get('/check-db', function () {
    $connection = config('database.default');
    $dbName = config("database.connections.{$connection}.database");

    try {
        $userCount = \App\Models\User::count();
        $adminCount = \App\Models\User::where('is_admin', true)->count();

        return [
            'database_connection' => $connection,
            'database_name' => $dbName,
            'total_users' => $userCount,
            'admin_users' => $adminCount,
            'admin_exists' => \App\Models\User::where('email', 'admin@dabsbeautytouch.com')->exists(),
        ];
    } catch (\Exception $e) {
        return [
            'database_connection' => $connection,
            'database_name' => $dbName,
            'error' => $e->getMessage()
        ];
    }
});

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard')->with('success', 'Welcome back!');
    }

    return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
})->name('admin.login.submit');

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
})->name('admin.logout');

// Protected admin routes - TEMPORARY SIMPLE VERSION (no middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect admin root to login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Admin dashboard (accessible after login)
    Route::get('/dashboard', function () {
        $query = \App\Models\Booking::with([]);

        // Apply filters if provided
        if (request('status') && request('status') !== 'all') {
            $query->where('status', request('status'));
        }

        if (request('date')) {
            $query->whereDate('appointment_date', request('date'));
        }

        if (request('service')) {
            $query->where('service', 'LIKE', '%' . request('service') . '%');
        }

        // Paginate bookings (10 per page)
        $bookings = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        $stats = [
            'total_bookings' => \App\Models\Booking::count(),
            'pending_bookings' => \App\Models\Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => \App\Models\Booking::where('status', 'confirmed')->count(),
            'completed_bookings' => \App\Models\Booking::where('status', 'completed')->count(),
            'today_bookings' => \App\Models\Booking::whereDate('appointment_date', today())->count(),
            'this_week_bookings' => \App\Models\Booking::whereBetween('appointment_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            // Revenue calculations for completed bookings only
            'today_revenue' => \App\Models\Booking::where('status', 'completed')
                ->whereDate('completed_at', today())
                ->sum('final_price') ?? 0,
            'monthly_revenue' => \App\Models\Booking::where('status', 'completed')
                ->whereYear('completed_at', now()->year)
                ->whereMonth('completed_at', now()->month)
                ->sum('final_price') ?? 0,
        ];

    // Also fetch recent custom service requests for admin review
    $customRequests = \App\Models\CustomServiceRequest::orderBy('created_at', 'desc')->take(10)->get();

    return view('admin.dashboard', compact('bookings', 'stats', 'customRequests'));
    })->name('dashboard');

    // Get booking details for modal
    Route::get('/booking-details/{id}', function ($id) {
        $booking = \App\Models\Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    })->name('booking-details');

    // Admin service completion page
    Route::get('/complete-service', function () {
        return view('admin.complete-service');
    })->name('complete-service');

    // Admin profile routes - SIMPLE VERSION
    Route::get('/profile', function () {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    })->name('profile');

    Route::post('/profile', function (Request $request) {
        // Simple profile update logic can be added here later
        return back()->with('success', 'Profile updated successfully!');
    })->name('profile.update');

    // Admin booking management routes
    Route::post('/bookings/update-status', function(Request $request) {
        try {
            // Accept both booking_id and appointment_id for compatibility
            $bookingId = $request->booking_id ?? $request->appointment_id;
            $booking = \App\Models\Booking::findOrFail($bookingId);
            $booking->status = $request->status;

            // Add completion notes if provided
            if ($request->completion_notes) {
                $booking->completion_notes = $request->completion_notes;
            }

            // Update timestamps and completion data based on status
            if ($request->status === 'confirmed') {
                $booking->confirmed_at = now();
            } elseif ($request->status === 'completed') {
                $booking->completed_at = now();

                // Add completion details if provided
                if ($request->completed_by) {
                    $booking->completed_by = $request->completed_by;
                }
                if ($request->service_duration_minutes) {
                    $booking->service_duration_minutes = $request->service_duration_minutes;
                }
                if ($request->final_price) {
                    $booking->final_price = $request->final_price;
                }
                if ($request->payment_status) {
                    $booking->payment_status = $request->payment_status;
                }
            } elseif ($request->status === 'cancelled') {
                $booking->cancelled_at = now();
            }

            $booking->save();

            // Send notifications for completed or cancelled statuses
            try {
                if ($request->status === 'completed' && $booking->email) {
                    \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                        ->notify(new \App\Notifications\ServiceCompletedNotification($booking));
                } elseif ($request->status === 'cancelled' && $booking->email) {
                    $cancelledBy = $request->cancelled_by ?? 'Admin';
                    \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                        ->notify(new \App\Notifications\BookingCancelledNotification($booking, $cancelledBy));
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to send booking status notification', [
                    'booking_id' => $booking->id,
                    'status' => $request->status,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating booking status: ' . $e->getMessage()
            ], 500);
        }
    })->name('bookings.update-status');

    // Admin booking single view (so the 'View Booking' button in emails works)
    Route::get('/bookings/{id}', function ($id) {
        $booking = \App\Models\Booking::find($id);

        if ($booking) {
            return view('admin.booking', compact('booking'));
        }

        // Fallback: check for custom service request with this id
        $customRequest = \App\Models\CustomServiceRequest::find($id);
        if ($customRequest) {
            // Render the same view but provide booking variable as null and customRequest for the template to handle
            return view('admin.booking', ['booking' => null, 'customRequest' => $customRequest]);
        }

        abort(404, 'Booking not found');
    })->name('bookings.show');

    // Update status for custom service requests
    Route::post('/custom-requests/{id}/status', function(Request $request, $id) {
        $request->validate(['status' => 'required|string']);

        $model = \App\Models\CustomServiceRequest::findOrFail($id);
        $model->status = $request->status;
        $model->save();

        return response()->json(['success' => true, 'message' => 'Status updated', 'status' => $model->status]);
    })->name('custom-requests.update-status');

    Route::post('/bookings/search', function(Request $request) {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
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
                    'booking' => [
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

            return response()->json([
                'success' => false,
                'message' => 'No pending or confirmed bookings found for this search term'
            ], 404);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error searching bookings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching for booking: ' . $e->getMessage()
            ], 500);
        }
    })->name('bookings.search');

    // Admin schedule management (FullCalendar events)
    Route::get('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/events', [\App\Http\Controllers\Admin\ScheduleController::class, 'events'])->name('schedules.events');
    Route::post('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::put('/schedules/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/reschedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'reschedule'])->name('schedules.reschedule');
    // Public endpoint used by the booking calendar to mark blocked days
    Route::get('/schedules/blocked-dates', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedDates'])->name('schedules.blocked-dates');
    // Public endpoint: list upcoming blocked ranges for users
    Route::get('/schedules/blocked-list', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedList'])->name('schedules.blocked-list');

});

// Test route to verify routing is working
Route::get('/test', function () {
    return response()->json(['message' => 'Route is working']);
});

// Simple admin test route
Route::get('/admin/test', function () {
    return 'Admin route is working!';
});

// Admin authentication routes (unprotected but rate limited) - TEMPORARY SIMPLE VERSION
Route::get('/admin/login', function () {
    return view('admin.login-simple');
})->name('admin.login');

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

// Booking routes - simplified closure implementation
Route::post('/bookings', function(Request $request) {

    // Handle sample_picture validation separately to avoid empty file issues
    $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => ['required','string','regex:/^[0-9+\-\s()]+$/','min:7','max:20'],
        'service' => 'nullable|string|max:255',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|string',
        'message' => 'nullable|string|max:1000',
    ];

    // Only validate sample_picture if a file was actually uploaded
    if ($request->hasFile('sample_picture')) {
        $file = $request->file('sample_picture');
        if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
            $validationRules['sample_picture'] = 'file|image|mimes:jpeg,png,jpg,gif|max:5120'; // 5MB max
        }
    }

    // Validate the booking form
    $request->validate($validationRules);

    // Create the booking
    try {
        Log::info('=== BOOKING ROUTE STARTED ===', [
            'method' => $request->method(),
            'is_ajax' => $request->wantsJson(),
            'headers' => $request->headers->all(),
            'request_data' => $request->except(['sample_picture']), // Exclude file from logs
            'has_sample_picture' => $request->hasFile('sample_picture')
        ]);

        // Handle sample picture upload if provided
        $samplePicturePath = null;
        if ($request->hasFile('sample_picture')) {
            $file = $request->file('sample_picture');

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

        $bookingData = [
            'name' => $request->name,
            'email' => $request->email ?: 'no-email@example.com',
            'phone' => $request->phone,
            'address' => $request->address,
            'service' => $request->service ?: 'General Service',
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message' => $request->message, // Store in message field
            'notes' => $request->message,   // Also store in notes field for compatibility
            'sample_picture' => $samplePicturePath,
            'status' => 'pending',
        ];

        // Normalize incoming length (accept hair_length or length) and determine final price using Service model + length adjustments
        $lengthRaw = $request->input('hair_length') ?? $request->input('length');
        if ($lengthRaw) {
            $length = str_replace('-', '_', $lengthRaw);
        } else {
            $length = $request->length ?: 'mid_back';
        }
        try {
            $serviceInput = $request->service;
            $serviceModel = null;
            if ($serviceInput) {
                // Try slug first
                $serviceModel = Service::where('slug', $serviceInput)->first();
                if (!$serviceModel) {
                    // Try by name
                    $serviceModel = Service::where('name', $serviceInput)->first();
                }
            }

            // Determine authoritative base price from Service model (ignore client-provided price)
            $base = $serviceModel ? (float) $serviceModel->base_price : 150.00;

            // If client explicitly provided a hair_mask_option, prefer that
            $explicitMaskOption = $request->input('hair_mask_option', null);
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

            if ($explicitMaskOption !== null && $isHairMask) {
                // Treat as hair mask when explicit option present and service is hair-mask
                $base = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                $addon = ($explicitMaskOption === 'mask-with-weave') ? 30.00 : 0.00;
                $adjust = $addon;
                $finalPrice = round($base + $addon, 2);
            } elseif ($isHairMask) {
                // service_type indicates hair mask; use hair-mask defaults
                $base = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                $maskOption = $request->input('hair_mask_option', 'mask-only');
                $addon = ($maskOption === 'mask-with-weave') ? 30.00 : 0.00;
                $adjust = $addon;
                $finalPrice = round($base + $addon, 2);
            } else {
                // Compute adjustment using same per-step $20 rule as controller
                $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
                $midIndex = array_search('mid_back', $ordered, true);
                $idx = array_search($length, $ordered, true);
                $d = ($idx !== false && $midIndex !== false) ? ($idx - $midIndex) : 0;
                $adjust = $d * 20.00;

                $finalPrice = round($base + $adjust, 2);
            }

            // Persist breakdown for email fidelity and audit
            $bookingData['base_price'] = $base;
            $bookingData['length_adjustment'] = $adjust;
            $bookingData['final_price'] = $finalPrice;
            $bookingData['length'] = $length;
            // Persist hair mask option only when this booking is a hair-mask service
            if ($explicitMaskOption !== null && $isHairMask) {
                $bookingData['hair_mask_option'] = $explicitMaskOption;
            } elseif ($isHairMask && $request->input('hair_mask_option')) {
                $bookingData['hair_mask_option'] = $request->input('hair_mask_option');
            }
        } catch (\Exception $e) {
            Log::warning('Failed to compute final price: ' . $e->getMessage());
            $bookingData['final_price'] = 150.00;
        }

        Log::info('=== BOOKING DATA PREPARED ===', $bookingData);

        // Create the booking
        Log::info('=== CREATING BOOKING ===', ['data' => $bookingData]);
        $booking = \App\Models\Booking::create($bookingData);
        Log::info('=== BOOKING CREATED SUCCESSFULLY ===', ['booking_id' => $booking->id]);

        // Generate booking ID in BK format and confirmation code
        $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));

        // Persist confirmation code on the booking record
        try {
            $booking->confirmation_code = $confirmationCode;
            $booking->save();
        } catch (\Exception $e) {
            Log::warning('Failed to save confirmation_code for booking', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        }

        // Log successful booking
        Log::info('Booking created successfully', [
            'booking_id' => $booking->id,
            'formatted_booking_id' => $bookingId,
            'name' => $booking->name,
            'service' => $booking->service,
            'date' => $booking->appointment_date,
            'message' => $booking->message
        ]);

        // Log mail configuration active for this request (helps debug which env is loaded)
        Log::info('Mail configuration for booking confirmation', [
            'mail_mailer' => config('mail.default'),
            'mail_host' => env('MAIL_HOST'),
            'mail_port' => env('MAIL_PORT'),
            'mail_username' => env('MAIL_USERNAME'),
        ]);

        // Attempt to send booking confirmation email to customer (if real email provided)
        try {
            if ($booking->email && $booking->email !== 'no-email@example.com') {
                // Use Notification facade directly to send a one-off mail
                \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                    ->notify(new \App\Notifications\BookingConfirmation($booking));
                Log::info('Booking confirmation email queued/sent for booking', ['booking_id' => $booking->id, 'email' => $booking->email]);
            } else {
                Log::info('No customer email provided; skipping booking confirmation email', ['booking_id' => $booking->id]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send booking confirmation email', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        }

        // Attempt to notify admin about new booking
        try {
            $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notify(new \App\Notifications\AdminBookingNotification($booking));
            Log::info('Admin booking notification queued/sent', ['booking_id' => $booking->id, 'admin_email' => $adminEmail]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin booking notification', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        }

        // Check if this is an AJAX request
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Your appointment has been booked successfully!',
                'appointment' => [
                    'booking_id' => $bookingId,
                    'confirmation_code' => $confirmationCode,
                    'final_price' => $booking->final_price,
                    'length' => $booking->length,
                    'service' => $booking->service,
                    'appointment_date' => $booking->appointment_date->format('F j, Y'),
                    'appointment_time' => $booking->appointment_time,
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'message' => $booking->message,
                ]
            ]);
        }

        // Redirect back to home page with flash session data (automatically cleared after display)
        return redirect()->route('home')->with([
            'success' => 'Your appointment has been booked successfully!',
            'booking_success' => true,
            'booking_details' => [
                'booking_id' => $bookingId,
                'confirmation_code' => $confirmationCode,
                'final_price' => $booking->final_price,
                'length' => $booking->length,
                'service' => $booking->service,
                'appointment_date' => $booking->appointment_date->format('F j, Y'),
                'appointment_time' => $booking->appointment_time,
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'message' => $booking->message,
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Booking creation failed: ' . $e->getMessage(), [
            'request_data' => $request->all(),
            'exception' => $e->getTraceAsString()
        ]);

        // Check if this is an AJAX request
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Return JSON error response for AJAX requests
            return response()->json([
                'success' => false,
                'message' => 'There was an issue processing your booking. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }

        // Return redirect with flash error data (automatically cleared after display)
        return redirect()->route('home')->withErrors(['error' => 'Something went wrong. Please try again.'])->withInput()->with([
            'booking_error' => true,
            'error_message' => 'There was an issue processing your booking. Please try again.'
        ]);
    }
})->name('bookings.store');

Route::post('/contact', function(Request $request) {
    // Validate the contact form
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:1000',
    ]);

    // Store contact form submission (you can save to database later)
    // For now, just redirect back with success message
    return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
})->name('contact.store');

// Custom service request form handler
Route::post('/custom-service', function(Request $request) {
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
        'service' => 'nullable|string|max:255',
        'appointment_date' => 'nullable|date',
        'appointment_time' => 'nullable|string',
        'message' => 'nullable|string|max:2000',
    ];

    $data = $request->validate($rules);

    try {
        // Persist request to database
        $modelData = [
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'service' => $data['service'] ?? null,
            'appointment_date' => $data['appointment_date'] ?? null,
            'appointment_time' => $data['appointment_time'] ?? null,
            'message' => $data['message'] ?? null,
        ];

        // Log incoming submission and DB config for debugging
        \Illuminate\Support\Facades\Log::info('Custom service submission received', [
            'model_data' => $modelData,
            'remote_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'db_default_connection' => config('database.default'),
            'db_database' => config('database.connections.' . config('database.default') . '.database'),
        ]);

        $record = \App\Models\CustomServiceRequest::create($modelData);

        // Build payload for notification including record id
        $payload = array_merge($modelData, [
            'id' => $record->id ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Log creation result
        \Illuminate\Support\Facades\Log::info('Custom service record created', [
            'record_id' => $record->id ?? null,
            'record' => $record->toArray()
        ]);

        // Log before sending notifications
        \Illuminate\Support\Facades\Log::info('Preparing to send notifications for custom service request', [
            'payload' => $payload,
        ]);

        // Send notification to admin
        $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
        \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
            ->notify(new \App\Notifications\CustomServiceRequest(array_merge($payload, ['is_admin' => true])));

        // Send a simple confirmation to the user if email provided
        if (!empty($record->email)) {
            \Illuminate\Support\Facades\Notification::route('mail', $record->email)
                ->notify(new \App\Notifications\UserCustomServiceConfirmation($payload));
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Custom service request submitted', 'id' => $record->id]);
        }

        return redirect()->back()->with('success', 'Your custom service request has been submitted. We will contact you soon.');

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Custom service submission failed: ' . $e->getMessage(), [
            'payload' => $payload ?? $data,
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Failed to submit request'], 500);
        }

        return redirect()->back()->withErrors(['error' => 'Failed to submit request'])->withInput();
    }
})->name('custom-service.store');

// Booking routes (public)
Route::get('/bookings/slots', function(Request $request) {
    return response()->json(['slots' => []]);
})->name('bookings.slots');

Route::get('/bookings/calendar', function(Request $request) {
    return response()->json(['calendar' => []]);
})->name('bookings.calendar');

Route::get('/bookings/booked-dates', function(Request $request) {
    return response()->json(['dates' => []]);
})->name('bookings.booked-dates');

Route::get('/bookings/booked-time-slots', function(Request $request) {
    return response()->json(['slots' => []]);
})->name('bookings.booked-time-slots');

Route::post('/bookings/cancel', function(Request $request) {
    return response()->json(['message' => 'Booking cancellation received']);
})->name('bookings.cancel');

Route::get('/bookings/details', function(Request $request) {
    return response()->json(['details' => []]);
})->name('bookings.details');

// Public booking confirmation link - shows booking details only when confirmation code matches
Route::get('/bookings/confirm/{id}/{code}', function($id, $code) {
    $booking = \App\Models\Booking::find($id);
    if (!$booking || ($booking->confirmation_code ?? '') !== $code) {
        return redirect()->route('home')->with(['booking_error' => true, 'error_message' => 'Invalid booking confirmation link.']);
    }

    // Render a simple page showing booking details (or reuse booking.success view)
    $bookingDetails = [
        'booking_id' => 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
        'confirmation_code' => $booking->confirmation_code,
        'service' => $booking->service,
        'length' => $booking->length,
        'final_price' => $booking->final_price,
        'appointment_date' => $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : null,
        'appointment_time' => $booking->appointment_time,
        'name' => $booking->name,
        'email' => $booking->email,
        'phone' => $booking->phone,
        'message' => $booking->message,
    ];

    return view('booking.success', ['bookingDetails' => $bookingDetails]);
})->name('bookings.confirm');

// Temporary debug route to inspect mail configuration from the running web process.
// Use this to verify which MAIL_* values the server process is using (Mailtrap vs Zoho).
Route::get('/_debug/mail', function() {
    return response()->json([
        'mail_default' => config('mail.default'),
        'mail_host' => env('MAIL_HOST'),
        'mail_port' => env('MAIL_PORT'),
        'mail_username' => env('MAIL_USERNAME'),
        'mail_from' => config('mail.from'),
        'admin_email' => env('ADMIN_EMAIL'),
    ]);
});

// Temporary debug route: force-send notifications for a booking id (admin + customer)
Route::match(['get','post'], '/_debug/send-booking-notifs/{id}', function($id) {
    $booking = \App\Models\Booking::find($id);
    if (! $booking) {
        return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
    }

    try {
        Log::info('[_debug] forcing booking notifications', ['booking_id' => $booking->id]);

        if ($booking->email && $booking->email !== 'no-email@example.com') {
            \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                ->notify(new \App\Notifications\BookingConfirmation($booking));
            Log::info('[_debug] sent booking confirmation', ['booking_id' => $booking->id, 'email' => $booking->email]);
        }

        $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
        \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
            ->notify(new \App\Notifications\AdminBookingNotification($booking));
        Log::info('[_debug] sent admin booking notification', ['booking_id' => $booking->id, 'admin_email' => $adminEmail]);

        return response()->json(['success' => true, 'message' => 'Notifications sent (or attempted)']);
    } catch (\Exception $e) {
        Log::error('[_debug] notification sending failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Notification sending failed', 'error' => $e->getMessage()], 500);
    }
});

// API routes for frontend - simplified closure implementation
Route::prefix('api')->group(function () {
    Route::get('/services', function() {
        return response()->json(['services' => []]);
    });

    Route::get('/testimonials', function() {
        return response()->json(['testimonials' => []]);
    });

    Route::get('/faqs', function() {
        return response()->json(['faqs' => []]);
    });

    Route::get('/contact-info', function() {
        return response()->json(['contact' => []]);
    });

    Route::get('/time-slots', function() {
        return response()->json(['time_slots' => []]);
    });

    Route::get('/bookings/unavailable', function() {
        return response()->json(['unavailable' => []]);
    });
});
