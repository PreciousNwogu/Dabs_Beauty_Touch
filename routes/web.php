<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

// Main route - show the home page
Route::get('/', function () {
    return view('home');
})->name('home');

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

        return view('admin.dashboard', compact('bookings', 'stats'));
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
                // Accept final_price even when 0; use has() to allow zero values
                if ($request->has('final_price')) {
                    $booking->final_price = is_numeric($request->final_price) ? $request->final_price : null;
                }
                if ($request->payment_status) {
                    $booking->payment_status = $request->payment_status;
                }
            } elseif ($request->status === 'cancelled') {
                $booking->cancelled_at = now();
            }

            $booking->save();

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
            $searchTerm = trim($request->search);

            // Split into words for multi-word name matching (AND-match for all words)
            $words = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);

            $query = \App\Models\Booking::query();

            $query->where(function($q) use ($searchTerm, $words) {
                // exact id match or phone/email partial
                $q->where('id', $searchTerm)
                  ->orWhere('phone', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');

                // If search contains words, require all words to be present in name (AND)
                if (!empty($words)) {
                    $q->orWhere(function($q2) use ($words) {
                        foreach ($words as $w) {
                            $q2->where('name', 'like', '%' . $w . '%');
                        }
                    });
                }
            });

            // Exclude cancelled/completed and return multiple results (up to 15)
            $bookings = $query->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'completed')
                ->orderBy('appointment_date', 'desc')
                ->limit(15)
                ->get();

            if ($bookings && $bookings->count() > 0) {
                // Format date safely
                $results = $bookings->map(function($b) {
                    $formattedDate = $b->appointment_date;
                    try {
                        $formattedDate = is_string($b->appointment_date)
                            ? date('M j, Y', strtotime($b->appointment_date))
                            : $b->appointment_date->format('M j, Y');
                    } catch (\Exception $e) {
                        $formattedDate = $b->appointment_date;
                    }

                    return [
                        'id' => $b->id,
                        'name' => $b->name,
                        'email' => $b->email,
                        'phone' => $b->phone,
                        'service' => $b->service,
                        'appointment_date' => $formattedDate,
                        'appointment_time' => $b->appointment_time,
                        'status' => $b->status,
                        'final_price' => $b->final_price ?? null
                    ];
                })->values();

                return response()->json([
                    'success' => true,
                    'bookings' => $results
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
    // Prevent PHP warnings/notices from being printed into the HTTP response
    // (these can corrupt JSON responses when e.g. PHP cannot create a tmp upload file).
    if (function_exists('ini_set')) {
        ini_set('display_errors', '0');
        ini_set('display_startup_errors', '0');
    }

    // Start output buffering to capture any stray output (warnings) so we can
    // discard it before sending our JSON response.
    if (function_exists('ob_start')) {
        @ob_start();
    }

    // Ensure an application-writable temporary directory exists and is writable.
    // This helps on systems where PHP's default upload tmp dir is not writable.
    try {
        $appTemp = storage_path('app/tmp');
        if (!file_exists($appTemp)) {
            mkdir($appTemp, 0755, true);
        }
        if (function_exists('ini_set')) {
            ini_set('upload_tmp_dir', $appTemp);
        }
        Log::info('Booking upload temp config', [
            'app_temp' => $appTemp,
            'app_temp_exists' => file_exists($appTemp),
            'app_temp_writable' => is_writable($appTemp),
            'php_upload_tmp_dir' => ini_get('upload_tmp_dir'),
            'sys_temp_dir' => sys_get_temp_dir(),
        ]);
    } catch (\Exception $e) {
        Log::warning('Failed to ensure app temp dir for uploads: ' . $e->getMessage());
    }

    // Handle sample_picture validation separately to avoid empty file issues
    $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'required|string|max:20',
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
            'length' => $request->hair_length ?? $request->length ?? null,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'final_price' => $request->final_price ?? $request->price ?? null,
            'message' => $request->message, // Store in message field
            'notes' => $request->message,   // Also store in notes field for compatibility
            'sample_picture' => $samplePicturePath,
            'status' => 'pending',
        ];

        Log::info('=== BOOKING DATA PREPARED ===', $bookingData);

        // Create the booking
        Log::info('=== CREATING BOOKING ===', ['data' => $bookingData]);
        $booking = \App\Models\Booking::create($bookingData);
        Log::info('=== BOOKING CREATED SUCCESSFULLY ===', ['booking_id' => $booking->id]);

        // Ensure length persisted (sometimes clients send hair_length)
        try {
            $submittedLength = $request->hair_length ?? $request->length ?? null;
            if ($submittedLength && ($booking->length !== $submittedLength)) {
                $booking->length = $submittedLength;
                $booking->save();
                Log::info('Booking length saved/updated', ['booking_id' => $booking->id, 'length' => $submittedLength]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to save booking length: ' . $e->getMessage(), ['booking_id' => $booking->id ?? null]);
        }

        // Generate booking ID in BK format and confirmation code
        $bookingId = 'BK' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);
        $confirmationCode = 'CONF' . strtoupper(substr(md5($booking->id . time()), 0, 8));

        // Log successful booking
        Log::info('Booking created successfully', [
            'booking_id' => $booking->id,
            'formatted_booking_id' => $bookingId,
            'name' => $booking->name,
            'service' => $booking->service,
            'date' => $booking->appointment_date,
            'message' => $booking->message
        ]);

        // Check if this is an AJAX request
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Clear any buffered stray output (warnings) before returning JSON
            if (function_exists('ob_get_level')) {
                while (ob_get_level() > 0) {
                    @ob_end_clean();
                }
            }

            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Your appointment has been booked successfully!',
                'appointment' => [
                    'booking_id' => $bookingId,
                    'confirmation_code' => $confirmationCode,
                    'service' => $booking->service,
                    'appointment_date' => $booking->appointment_date->format('F j, Y'),
                    'appointment_time' => $booking->appointment_time,
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'message' => $booking->message,
                    'length' => $booking->length ?? null,
                    'final_price' => $booking->final_price ?? null,
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
                'service' => $booking->service,
                'appointment_date' => $booking->appointment_date->format('F j, Y'),
                'appointment_time' => $booking->appointment_time,
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'message' => $booking->message,
                'length' => $booking->length ?? null,
                'final_price' => $booking->final_price ?? null,
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Booking creation failed: ' . $e->getMessage(), [
            'request_data' => $request->all(),
            'exception' => $e->getTraceAsString()
        ]);

        // Check if this is an AJAX request
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            // Clear any buffered stray output (warnings) before returning JSON error
            if (function_exists('ob_get_level')) {
                while (ob_get_level() > 0) {
                    @ob_end_clean();
                }
            }

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
