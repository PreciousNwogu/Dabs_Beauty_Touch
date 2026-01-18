<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;

// TEMPORARY (staging-only): clear application caches.
// Protect this route with an env check + secret key and remove when done.
Route::get('/__clear', function (Request $request) {
    // Only allow on staging/local environments
    abort_unless(app()->environment(['staging', 'local']), 404);

    // Require a secret key in staging to prevent public abuse:
    // call as: /__clear?key=YOUR_CLEAR_CACHE_KEY
    $expectedKey = env('CLEAR_CACHE_KEY');
    if (app()->environment('staging') && $expectedKey) {
        abort_unless(hash_equals($expectedKey, (string) $request->query('key', '')), 403);
    }

    Artisan::call('optimize:clear');

    return response()->json([
        'success' => true,
        'message' => 'Caches cleared',
    ]);
});

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

// Public endpoints for blocked dates (used by booking calendar)
Route::get('/schedules/blocked-dates', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedDates'])->name('schedules.blocked-dates');
Route::get('/schedules/blocked-list', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedList'])->name('schedules.blocked-list');

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

// Price preview API (server-side canonical breakdown)
Route::post('/api/price/preview', [\App\Http\Controllers\AppointmentController::class, 'previewPrice'])->name('api.price.preview');

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
        $adminUsers = \App\Models\User::where('is_admin', true)->get(['id', 'name', 'email']);

        return [
            'database_connection' => $connection,
            'database_name' => $dbName,
            'total_users' => $userCount,
            'admin_users' => $adminCount,
            'admin_exists' => \App\Models\User::where('email', 'admin@dabsbeautytouch.com')->exists(),
            'admin_users_list' => $adminUsers->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ];
            })->toArray(),
        ];
    } catch (\Exception $e) {
        return [
            'database_connection' => $connection,
            'database_name' => $dbName,
            'error' => $e->getMessage()
        ];
    }
});

// TEMPORARY: Create admin user route (remove after use)
Route::get('/create-admin', function () {
    try {
        $adminEmail = 'admin@dabsbeautytouch.com';
        $adminPassword = 'admin123!@#';
        
        $existingAdmin = \App\Models\User::where('email', $adminEmail)->first();
        
        if ($existingAdmin) {
            // Update existing user to be admin
            $existingAdmin->update([
                'is_admin' => true,
                'password' => \Illuminate\Support\Facades\Hash::make($adminPassword)
            ]);
            return [
                'success' => true,
                'message' => 'Admin user updated',
                'email' => $adminEmail,
                'password' => $adminPassword
            ];
        } else {
            // Create new admin user
            \App\Models\User::create([
                'name' => 'System Administrator',
                'email' => $adminEmail,
                'password' => \Illuminate\Support\Facades\Hash::make($adminPassword),
                'is_admin' => true,
            ]);
            
            return [
                'success' => true,
                'message' => 'Admin user created successfully',
                'email' => $adminEmail,
                'password' => $adminPassword,
                'note' => 'Please change the password after first login'
            ];
        }
    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
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
        try {
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

            // Paginate bookings (50 per page to show more bookings)
            $bookings = $query->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->paginate(50);

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
            try {
                $customRequests = \App\Models\CustomServiceRequest::orderBy('created_at', 'desc')->take(10)->get();
            } catch (\Exception $e) {
                Log::warning('Failed to fetch custom service requests: ' . $e->getMessage());
                $customRequests = collect([]); // Empty collection as fallback
            }

            return view('admin.dashboard', compact('bookings', 'stats', 'customRequests'));
        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Return error response
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while loading the dashboard: ' . $e->getMessage()
                ], 500);
            }
            
            // For web requests, redirect to login with error message
            return redirect()->route('admin.login')
                ->with('error', 'An error occurred while loading the dashboard. Please try again later.');
        }
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

    // Admin profile routes
    Route::get('/profile', function () {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access your profile.');
        }
        return view('admin.profile', compact('user'));
    })->name('profile');

    // Update email
    Route::post('/profile/update-email', function (Request $request) {
        $user = Auth::user();
        
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'password.required' => 'Current password is required to change your email.',
        ]);

        // Verify current password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Current password is incorrect.'])->withInput();
        }

        // Update email
        $user->email = $validated['email'];
        $user->save();

        Log::info('Admin email updated', [
            'user_id' => $user->id,
            'old_email' => $user->getOriginal('email'),
            'new_email' => $user->email,
        ]);

        return back()->with('success', 'Email address updated successfully!');
    })->name('profile.update-email');

    // Update password
    Route::post('/profile/update-password', function (Request $request) {
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'New password must be at least 8 characters long.',
            'password.confirmed' => 'New password confirmation does not match.',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        // Check if new password is different from current
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'New password must be different from your current password.'])->withInput();
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        Log::info('Admin password updated', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return back()->with('success', 'Password updated successfully!');
    })->name('profile.update-password');

    // Admin booking management routes
    Route::post('/bookings/update-status', function(HttpRequest $request) {
        // Log incoming request for debugging
        Log::info('Booking status update request received', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'has_csrf' => $request->hasHeader('X-CSRF-TOKEN'),
            'booking_id' => $request->booking_id ?? $request->appointment_id,
            'status' => $request->status,
            'request_data' => $request->all(),
        ]);

        try {
            // Accept both booking_id and appointment_id for compatibility
            $bookingId = $request->booking_id ?? $request->appointment_id;
            
            if (!$bookingId) {
                Log::warning('Booking status update failed: No booking ID provided');
                return response()->json([
                    'success' => false,
                    'message' => 'Booking ID is required'
                ], 400);
            }
            
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
                // Ensure payment_status is always set to a valid enum value
                $validPaymentStatuses = ['pending', 'deposit_paid', 'fully_paid'];
                if ($request->payment_status && in_array($request->payment_status, $validPaymentStatuses)) {
                    $booking->payment_status = $request->payment_status;
                } else {
                    // Default to 'pending' if not provided or invalid
                    $booking->payment_status = 'pending';
                }
            } elseif ($request->status === 'cancelled') {
                $booking->cancelled_at = now();
            }

            $booking->save();

            // Send notifications for confirmed, completed, or cancelled statuses
            try {
                if ($request->status === 'confirmed' && $booking->email && $booking->email !== 'no-email@example.com') {
                    \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                        ->notify(new \App\Notifications\BookingConfirmation($booking));
                } elseif ($request->status === 'completed' && $booking->email) {
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

    Route::post('/bookings/search-complete', function(Request $request) {
        try {
            $query = \App\Models\Booking::query();

            // Only show bookings that can be completed (pending or confirmed)
            $query->whereIn('status', ['pending', 'confirmed']);

            // Search by ID (from query params or JSON body)
            $bookingId = $request->input('booking_id') ?? $request->booking_id;
            if ($bookingId) {
                $query->where('id', $bookingId);
            }

            // Search by customer name
            $customerName = $request->input('customer_name') ?? $request->customer_name;
            if ($customerName) {
                $query->where('name', 'LIKE', '%' . $customerName . '%');
            }

            // Search by date
            $date = $request->input('date') ?? $request->date;
            if ($date) {
                $query->whereDate('appointment_date', $date);
            }

            // Search by service name
            $service = $request->input('service') ?? $request->service;
            if ($service) {
                $query->where('service', 'LIKE', '%' . $service . '%');
            }

            // If no search criteria provided, return empty result
            if (!$bookingId && !$customerName && !$date && !$service) {
                return response()->json([
                    'success' => true,
                    'bookings' => [],
                    'count' => 0
                ]);
            }

            $bookings = $query->orderBy('appointment_date', 'desc')
                             ->orderBy('appointment_time', 'desc')
                             ->get();

            $formattedBookings = $bookings->map(function($booking) {
                $formattedDate = null;
                if ($booking->appointment_date) {
                    try {
                        $formattedDate = is_string($booking->appointment_date)
                            ? date('M j, Y', strtotime($booking->appointment_date))
                            : $booking->appointment_date->format('M j, Y');
                    } catch (\Exception $e) {
                        $formattedDate = $booking->appointment_date;
                    }
                }

                return [
                    'id' => $booking->id,
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'service' => $booking->service,
                    'appointment_date' => $formattedDate,
                    'appointment_date_raw' => $booking->appointment_date ? (is_string($booking->appointment_date) ? $booking->appointment_date : $booking->appointment_date->format('Y-m-d')) : null,
                    'appointment_time' => $booking->appointment_time,
                    'status' => $booking->status,
                    'final_price' => $booking->final_price
                ];
            });

            return response()->json([
                'success' => true,
                'bookings' => $formattedBookings,
                'count' => $formattedBookings->count()
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error searching bookings for completion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching for bookings: ' . $e->getMessage()
            ], 500);
        }
    })->name('bookings.search-complete');

    // Admin schedule management (FullCalendar events)
    Route::get('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/events', [\App\Http\Controllers\Admin\ScheduleController::class, 'events'])->name('schedules.events');
    Route::post('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
    Route::put('/schedules/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/reschedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'reschedule'])->name('schedules.reschedule');
    
    // Temporary route to unblock all January dates (GET for easy browser access)
    Route::get('/schedules/unblock-january', function(Request $request) {
        try {
            $year = $request->input('year', date('Y')); // Default to current year
            $janStart = \Carbon\Carbon::create($year, 1, 1)->startOfDay();
            $janEnd = \Carbon\Carbon::create($year, 1, 31)->endOfDay();
            
            // Find all blocked schedules that overlap with January
            $blockedSchedules = \App\Models\Schedule::where('type', 'blocked')
                ->where(function($query) use ($janStart, $janEnd) {
                    $query->where(function($q) use ($janStart, $janEnd) {
                        // Schedule starts before or during January and ends after January starts
                        $q->where('start', '<=', $janEnd)
                          ->where('end', '>', $janStart);
                    });
                })
                ->get();
            
            if ($blockedSchedules->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => "No blocked schedules found for January {$year}",
                    'deleted_count' => 0
                ]);
            }
            
            $deletedCount = 0;
            $deletedTitles = [];
            
            foreach ($blockedSchedules as $schedule) {
                $deletedTitles[] = $schedule->title ?? 'Untitled';
                $schedule->delete();
                $deletedCount++;
            }
            
            \Illuminate\Support\Facades\Log::info('Unblocked January dates', [
                'year' => $year,
                'deleted_count' => $deletedCount,
                'deleted_schedules' => $deletedTitles
            ]);
            
            return response()->json([
                'success' => true,
                'message' => "Unblocked {$deletedCount} schedule(s) for January {$year}",
                'deleted_count' => $deletedCount,
                'deleted_schedules' => $deletedTitles
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to unblock January: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unblock January: ' . $e->getMessage()
            ], 500);
        }
    })->name('schedules.unblock-january');

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

        // Normalize phone server-side: allow leading + and digits, strip other characters
        $rawPhone = $request->phone ?? '';
        $normalizedPhone = preg_replace('/[^0-9+]/', '', $rawPhone);
        // If there are multiple + signs, keep only the leading one
        if (substr_count($normalizedPhone, '+') > 1) {
            $normalizedPhone = preg_replace('/\++/', '+', $normalizedPhone);
            if (strpos($normalizedPhone, '+') !== 0) {
                // move single + to start
                $normalizedPhone = '+' . str_replace('+', '', $normalizedPhone);
            }
        }

        $bookingData = [
            'name' => $request->name,
            'email' => $request->email ?: 'no-email@example.com',
            'phone' => $normalizedPhone,
            'address' => $request->address,
            'service' => $request->service ?: 'General Service',
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message' => $request->message, // Store in message field
            'notes' => $request->message,   // Also store in notes field for compatibility
            'sample_picture' => $samplePicturePath,
            'status' => 'pending',
        ];

        // Capture kids selector fields if present and append to notes for email fidelity
        try{
            $selectorFields = [];
            if($request->filled('kb_braid_type')) $selectorFields['braid_type'] = $request->input('kb_braid_type');
            if($request->filled('kb_finish')) $selectorFields['finish'] = $request->input('kb_finish');
            if($request->filled('kb_length')) $selectorFields['length'] = $request->input('kb_length');
            if($request->filled('kb_extras')) $selectorFields['extras'] = $request->input('kb_extras');
            if(!empty($selectorFields)){
                $json = json_encode($selectorFields);
                $bookingData['notes'] = trim(($bookingData['notes'] ?? '') . "\nSelector: " . $json);
                // persist selector fields directly on booking for easier access

                $bookingData['kb_braid_type'] = $selectorFields['braid_type'] ?? null;
                $bookingData['kb_finish'] = $selectorFields['finish'] ?? null;
                $bookingData['kb_length'] = $selectorFields['length'] ?? null;
                $bookingData['kb_extras'] = $selectorFields['extras'] ?? null;

                // Map the braid type to a human friendly service label and store as service for clarity
                $braidMap = [
                    'protective' => 'Protective style',
                    'cornrows' => 'Cornrows',
                    'knotless_small' => 'Knotless (small)',
                    'knotless_med' => 'Knotless (medium)',
                    'box_small' => 'Box (small)',
                    'box_med' => 'Box (medium)',
                    'stitch' => 'Stitch',
                ];
                if(!empty($selectorFields['braid_type'])){
                    $human = $braidMap[$selectorFields['braid_type']] ?? ucwords(str_replace(['_','-'], ' ', $selectorFields['braid_type']));
                    $bookingData['service'] = 'Kids Braids — ' . $human;
                    $bookingData['service_type'] = 'kids-braids';
                }

                // Compute authoritative kids price using the same mapping as notifications
                $baseConfigured = (float) (config('service_prices.kids_braids', 80));
                $typeAdj = ['protective'=>-20,'cornrows'=>-40,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];
                $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];

                $adjustments = 0; $addons = 0;
                $bt = $selectorFields['braid_type'] ?? null;
                $ln = $selectorFields['length'] ?? null;
                $fi = $selectorFields['finish'] ?? null;
                $ex = $selectorFields['extras'] ?? null;

                if($bt && isset($typeAdj[$bt])) $adjustments += $typeAdj[$bt];
                if($ln && isset($lengthAdj[$ln])) $adjustments += $lengthAdj[$ln];
                if($fi && isset($finishAdj[$fi])) $adjustments += $finishAdj[$fi];

                if($ex){
                    if(is_string($ex) && strpos($ex,'kb_add_')!==false){
                        foreach(explode(',', $ex) as $it){ $it = trim($it); if(isset($addonMap[$it])) $addons += $addonMap[$it]; }
                    } else if(is_string($ex) && preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)){
                        foreach(explode(',', $ex) as $n){ $addons += floatval($n); }
                    }
                }

                $finalKidsPrice = round($baseConfigured + $adjustments + $addons, 2);
                $bookingData['base_price'] = $baseConfigured;
                $bookingData['length_adjustment'] = $adjustments;
                $bookingData['final_price'] = $finalKidsPrice;
                // Also persist selector-specific breakdown so we don't overwrite other services
                $bookingData['kb_base_price'] = $baseConfigured;
                $bookingData['kb_length_adjustment'] = $adjustments;
                $bookingData['kb_final_price'] = $finalKidsPrice;
            }
        }catch(
        Exception $e){ /* noop */ }

        // If this is a kids-braids submission, ensure a length was provided (kb_length or length/hair_length)
        if (!empty($bookingData['service_type']) && $bookingData['service_type'] === 'kids-braids') {
            $providedLength = $bookingData['kb_length'] ?? $request->input('length') ?? $request->input('hair_length') ?? null;
            if (empty($providedLength)) {
                // Return early with a validation-like error so the user can correct the form
                if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json(['success' => false, 'message' => 'Please select a hair length for kids braids.'], 422);
                }
                return redirect()->route('home')->withErrors(['length' => 'Please select a hair length for kids braids'])->withInput();
            }

            // Normalize kb_length to canonical format server-side
            $norm = strtolower(trim((string)$providedLength));
            $norm = str_replace([' ', '-'], ['_', '_'], $norm);
            $norm = str_replace(['tail_bone','tail bone','tail-bone','tailbone','tail_bone'], 'tailbone', $norm);
            $norm = str_replace(['bra strap','bra-strap','bra_strap'], 'bra_strap', $norm);
            $bookingData['kb_length'] = $norm;
        }

        // Normalize incoming length (accept hair_length or length or kb_length) and determine final price using Service model + length adjustments
        $lengthRaw = $request->input('hair_length') ?? $request->input('length') ?? $bookingData['kb_length'] ?? null;
        if ($lengthRaw) {
            $length = strtolower(trim((string)$lengthRaw));
            $length = str_replace([' ', '-'], ['_', '_'], $length);
            $length = str_replace(['tail_bone','tail bone','tail-bone','tailbone','tail_bone'], 'tailbone', $length);
            $length = str_replace(['bra strap','bra-strap','bra_strap'], 'bra_strap', $length);
        } else {
            $length = $request->length ?: 'mid_back';
        }
        try {
            $serviceInput = $request->service;
            $serviceModel = null;
            if ($serviceInput) {
                // Try slug first (exact match)
                $serviceModel = Service::where('slug', $serviceInput)->first();
                if (!$serviceModel) {
                    // Try by name (exact match)
                    $serviceModel = Service::where('name', $serviceInput)->first();
                }
                if (!$serviceModel) {
                    // Try by name case-insensitive
                    $serviceModel = Service::whereRaw('LOWER(name) = ?', [strtolower($serviceInput)])->first();
                }
                if (!$serviceModel) {
                    // Try by slug (convert service name to slug format for lookup)
                    $slugFromName = strtolower(str_replace([' ', '-'], '-', $serviceInput));
                    $serviceModel = Service::where('slug', $slugFromName)->first();
                }
            }

            // Determine authoritative base price from Service model (ignore client-provided price)
            // If not found in database, try config file as fallback
            if ($serviceModel) {
                $base = (float) $serviceModel->base_price;
            } else {
                // Try to find in config by slug (convert service name to slug format)
                // Convert spaces and hyphens to underscores for config lookup
                $serviceSlug = strtolower(str_replace([' ', '-'], '_', $serviceInput ?? ''));
                $base = (float) (config("service_prices.{$serviceSlug}", 150.00));
            }

            // If client explicitly provided a hair_mask_option, prefer that
            $explicitMaskOption = $request->input('hair_mask_option', null);
            $serviceTypeInput = $request->input('service_type') ?? $request->input('service');
            $serviceTypeNormalized = strtolower(trim((string)$serviceTypeInput));
            $serviceNameNormalized = strtolower(trim((string)($request->input('service') ?? $request->input('service_display') ?? '')));
            $isHairMask = (
                $serviceTypeNormalized === 'hair-mask' ||
                str_contains($serviceTypeNormalized, 'hair-mask') ||
                str_contains($serviceTypeNormalized, 'hair mask') ||
                str_contains($serviceTypeNormalized, 'hairmask') ||
                str_contains($serviceTypeNormalized, 'mask/relax') ||
                str_contains($serviceTypeNormalized, 'relaxing') ||
                str_contains($serviceTypeNormalized, 'retouching') ||
                str_contains($serviceTypeNormalized, 'retouch') ||
                str_contains($serviceNameNormalized, 'hair mask') ||
                str_contains($serviceNameNormalized, 'mask/relax') ||
                str_contains($serviceNameNormalized, 'relaxing') ||
                str_contains($serviceNameNormalized, 'retouching') ||
                str_contains($serviceNameNormalized, 'retouch')
            );

            if ($explicitMaskOption !== null && $isHairMask) {
                // Treat as hair mask when explicit option present and service is hair-mask
                $base = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                // Normalize mask option value (handle variations like 'mask-with-weave', 'mask_with_weave', etc.)
                $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$explicitMaskOption)));
                $addon = (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) ? 30.00 : 0.00;
                $adjust = $addon;
                $finalPrice = round($base + $addon, 2);
            } elseif ($isHairMask) {
                // service_type indicates hair mask; use hair-mask defaults
                $base = $serviceModel ? (float) $serviceModel->base_price : 50.00;
                $maskOption = $request->input('hair_mask_option', 'mask-only');
                // Normalize mask option value (handle variations)
                $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$maskOption)));
                $addon = (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) ? 30.00 : 0.00;
                $adjust = $addon;
                $finalPrice = round($base + $addon, 2);
            } else {
                // Check if this is a popular service that should skip length adjustments
                // Note: Kinky Twist and Twist Braids are popular services but DO allow length adjustments
                $popularServicesNoLengthAdjustment = [
                    'Weaving Crotchet',
                    'Single Crotchet',
                    'Natural Hair Twist',
                    'Weaving No-Extension'
                ];
                $isPopularServiceNoLength = in_array($serviceInput, $popularServicesNoLengthAdjustment, true);
                
                if ($isPopularServiceNoLength) {
                    // Popular services (excluding Kinky Twist and Twist Braids): no length adjustments, use base price only (mid-back length)
                    $adjust = 0.00;
                    $finalPrice = round($base, 2);
                    // Ensure length is set to mid_back for popular services
                    $length = 'mid_back';
                } else {
                    // Length adjustment pricing with grouped lengths (applies to regular services AND Kinky Twist/Twist Braids):
                    // - neck, shoulder, armpit: same price (-$40)
                    // - bra_strap, mid_back: base/default price ($0 adjustment)
                    // - waist: +$20
                    // - hip: +$40 (waist + $20)
                    // - tailbone, classic: same price (+$60)
                    $lengthAdjustmentMap = [
                        'neck' => -40.00,
                        'shoulder' => -40.00,
                        'armpit' => -40.00,
                        'bra_strap' => 0.00,
                        'mid_back' => 0.00,
                        'waist' => 20.00,
                        'hip' => 40.00,
                        'tailbone' => 60.00,
                        'classic' => 60.00,
                    ];
                    
                    $adjust = $lengthAdjustmentMap[$length] ?? 0.00;
                    $finalPrice = round($base + $adjust, 2);
                }
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

        // Check if this date is blocked before creating booking (only block full-day blocks)
        if (!empty($bookingData['appointment_date'])) {
            try {
                $appointmentDate = \Carbon\Carbon::parse($bookingData['appointment_date'])->startOfDay();
                $appointmentTime = $bookingData['appointment_time'] ?? null;
                
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
                            $blockedTitle = $blockedSchedule->title ?? 'Blocked';
                            $isApiRequest = $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

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
                                $requestedDateTime = \Carbon\Carbon::parse($bookingData['appointment_date'] . ' ' . $appointmentTime);
                                $blockStart = $startParsed->copy()->setTimezone(config('app.timezone') ?: 'UTC');
                                $blockEnd = $endParsed->copy()->setTimezone(config('app.timezone') ?: 'UTC');
                                
                                // Check if the requested date matches the block date(s)
                                $blockStartDate = $blockStart->format('Y-m-d');
                                $blockEndDate = $blockEnd->format('Y-m-d');
                                $requestedDate = $appointmentDate->format('Y-m-d');
                                
                                if ($requestedDate >= $blockStartDate && $requestedDate <= $blockEndDate) {
                                    // Check if the time falls within the blocked range
                                    if ($requestedDateTime->gte($blockStart) && $requestedDateTime->lt($blockEnd)) {
                                        $blockedTitle = $blockedSchedule->title ?? 'Blocked';
                                        $isApiRequest = $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

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
                                \Illuminate\Support\Facades\Log::warning('Failed to check blocked time: ' . $timeException->getMessage());
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::warning('Failed to check blocked date for booking: ' . $e->getMessage());
                // Continue with booking creation if date check fails
            }
        }

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
    try {
        // Validate the contact form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Prepare contact data with correct timezone
        $timezone = 'America/Toronto'; // Always use Toronto timezone
        $submittedAt = \Carbon\Carbon::now($timezone);
        
        $contactData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'submitted_at' => $submittedAt->toDateTimeString(),
            'submitted_at_timestamp' => $submittedAt->timestamp,
            'submitted_at_timezone' => $timezone, // Store timezone for reference
        ];

        // Log the contact form submission
        Log::info('Contact form submission received', [
            'name' => $contactData['name'],
            'email' => $contactData['email'],
            'subject' => $contactData['subject'],
            'ip' => $contactData['ip'],
        ]);

        // Send notification to admin
        try {
            $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
            
            if (empty($adminEmail) || $adminEmail === 'admin@example.com') {
                Log::warning('Admin email not configured for contact form notification', [
                    'contact_name' => $contactData['name'],
                    'config_mail_admin' => config('mail.admin_address'),
                    'env_admin_email' => env('ADMIN_EMAIL'),
                ]);
            }
            
            Log::info('Sending admin notification for contact form submission', [
                'admin_email' => $adminEmail,
                'contact_name' => $contactData['name'],
                'contact_email' => $contactData['email'],
            ]);
            
            // Create notification instance
            $notification = new \App\Notifications\AdminContactNotification($contactData);
            
            // Send notification immediately (not queued) to ensure admin receives it right away
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notifyNow($notification);
            
            Log::info('Admin notification sent successfully for contact form submission', [
                'admin_email' => $adminEmail,
                'contact_name' => $contactData['name'],
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send admin notification for contact form submission', [
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'contact_name' => $contactData['name'] ?? null,
                'contact_email' => $contactData['email'] ?? null,
                'admin_email' => $adminEmail ?? null,
            ]);
            // Don't fail the request if notification fails - still show success to user
        }

        // Return success response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.'
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Contact form submission failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your message. Please try again.'
            ], 500);
        }

        return redirect()->back()->withErrors(['error' => 'An error occurred while submitting your message. Please try again.'])->withInput();
    }
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
        'service_category' => 'nullable|string|max:255',
        'braid_size' => 'nullable|string|max:255',
        'hair_length' => 'nullable|string|max:255',
        'budget_range' => 'nullable|string|max:255',
        'urgency' => 'nullable|string|max:255',
        'style_preferences' => 'nullable|array',
        'special_requirements' => 'nullable|string|max:2000',
        'reference_image' => 'nullable|file|image|max:5120', // 5MB max
    ];

    $data = $request->validate($rules);

    try {
        // Handle file upload for reference image
        $referenceImagePath = null;
        if ($request->hasFile('reference_image')) {
            $file = $request->file('reference_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $referenceImagePath = $file->storeAs('custom-service-images', $filename, 'public');
        }

        // Convert style_preferences array to JSON string
        $stylePreferences = null;
        if (!empty($data['style_preferences']) && is_array($data['style_preferences'])) {
            $stylePreferences = json_encode($data['style_preferences']);
        }

        // Persist request to database
        $modelData = [
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'service' => $data['service'] ?? null,
            'appointment_date' => $data['appointment_date'] ?? null,
            'appointment_time' => $data['appointment_time'] ?? null,
            'message' => $data['message'] ?? null,
            'service_category' => $data['service_category'] ?? null,
            'braid_size' => $data['braid_size'] ?? null,
            'hair_length' => $data['hair_length'] ?? null,
            'budget_range' => $data['budget_range'] ?? null,
            'urgency' => $data['urgency'] ?? null,
            'style_preferences' => $stylePreferences,
            'special_requirements' => $data['special_requirements'] ?? null,
            'reference_image' => $referenceImagePath,
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

        // Build payload for notification including record id and all custom service details
        $payload = array_merge($modelData, [
            'id' => $record->id ?? null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'style_preferences_array' => !empty($data['style_preferences']) ? $data['style_preferences'] : [],
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
        try {
            $adminEmail = config('mail.admin_address') ?: env('ADMIN_EMAIL') ?: 'admin@example.com';
            \Illuminate\Support\Facades\Log::info('Sending admin notification for custom service request', [
                'admin_email' => $adminEmail,
                'request_id' => $record->id ?? null,
            ]);
            
            // Create notification instance
            $notification = new \App\Notifications\CustomServiceRequest(array_merge($payload, ['is_admin' => true]));
            
            // Send notification immediately (not queued) to ensure admin receives it right away
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notifyNow($notification);
            
            \Illuminate\Support\Facades\Log::info('Admin notification sent for custom service request', [
                'admin_email' => $adminEmail,
                'request_id' => $record->id ?? null,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send admin notification for custom service request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_id' => $record->id ?? null,
            ]);
        }

        // Send a simple confirmation to the user if email provided
        if (!empty($record->email)) {
            try {
                \Illuminate\Support\Facades\Notification::route('mail', $record->email)
                    ->notify(new \App\Notifications\UserCustomServiceConfirmation($payload));
                \Illuminate\Support\Facades\Log::info('User confirmation email sent for custom service request', [
                    'user_email' => $record->email,
                    'request_id' => $record->id ?? null,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send user confirmation email for custom service request', [
                    'error' => $e->getMessage(),
                    'user_email' => $record->email,
                    'request_id' => $record->id ?? null,
                ]);
            }
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
Route::get('/bookings/slots', [App\Http\Controllers\AppointmentController::class, 'getAvailableTimeSlots'])->name('bookings.slots');

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

// Serve an .ics calendar file for a booking so users can download/import to calendars
Route::get('/bookings/{id}/calendar.ics', function ($id) {
    $booking = \App\Models\Booking::withTrashed()->findOrFail($id);
    $tz = config('app.timezone') ?: 'UTC';
    try {
        $date = $booking->appointment_date ? $booking->appointment_date->format('Y-m-d') : null;
        $time = $booking->appointment_time ?? null;
        if (!$date || !$time) {
            abort(404, 'Booking has no scheduled date/time');
        }
        $start = \Carbon\Carbon::parse($date . ' ' . $time, $tz)->toImmutable();
        $duration = (int) ($booking->service_duration_minutes ?? 90);
        $end = $start->addMinutes($duration);

        $uid = 'booking-' . ($booking->id ?? '0') . '@' . request()->getHost();
        $now = \Carbon\Carbon::now()->utc();
        $dtstamp = $now->format('Ymd\THis\Z');
        $dtstart = $start->utc()->format('Ymd\THis\Z');
        $dtend = $end->utc()->format('Ymd\THis\Z');
        $summary = addslashes($booking->service ?? 'Appointment');
        $description = addslashes('Booking ' . ($booking->confirmation_code ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT))) . "\nCustomer: " . ($booking->name ?? '') . "\nPhone: " . ($booking->phone ?? ''));

        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Dabs Beauty Touch//EN\r\nBEGIN:VEVENT\r\n";
        $ics .= "UID:{$uid}\r\nDTSTAMP:{$dtstamp}\r\nDTSTART:{$dtstart}\r\nDTEND:{$dtend}\r\n";
        $ics .= "SUMMARY:{$summary}\r\nDESCRIPTION:{$description}\r\n";
        $ics .= "END:VEVENT\r\nEND:VCALENDAR\r\n";

        $filename = 'booking-' . ($booking->confirmation_code ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT))) . '.ics';
        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    } catch (\Exception $e) {
        abort(500, 'Could not generate calendar file');
    }
});
