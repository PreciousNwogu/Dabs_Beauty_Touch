<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PublicAuthController;
use App\Http\Controllers\AccountController;
use App\Exceptions\SlotUnavailableException;
use App\Services\BookingSlotGuard;
use App\Support\AdminBookingFilters;
use App\Support\ServiceDuration;
use App\Http\Controllers\Admin\ConvertCustomRequestController;
use App\Http\Controllers\Admin\BookingExportController;

// TEMPORARY: clear application caches.
// This is protected by a secret key. Remove when done.
Route::get('/__clear', function (Request $request) {
    // Require a secret key to prevent public abuse:
    // call as: /__clear?key=YOUR_CLEAR_CACHE_KEY
    $expectedKey = env('CLEAR_CACHE_KEY');
    // Hide the endpoint if the key isn't configured
    abort_unless(is_string($expectedKey) && $expectedKey !== '', 404);
    abort_unless(hash_equals($expectedKey, (string) $request->query('key', '')), 403);

    Artisan::call('optimize:clear');

    return response()->json([
        'success' => true,
        'message' => 'Caches cleared',
    ]);
});

// Main route - show the home page
Route::get('/', function () {
    \App\Support\AdultServiceCatalog::ensureRequiredCmsServices();
    // AppServiceProvider already overrides config('service_prices.*') with live DB values.
    $servicePrices = Service::pluck('base_price', 'slug')->toArray();

    // Slugs that are already rendered as hardcoded service cards on the homepage.
    // Any active non-kids service is shown dynamically via CMS cards.
    $forKidsExists = \Illuminate\Support\Facades\Schema::hasColumn('services', 'for_kids');
    $extraServicesQuery = Service::where('is_active', true);
    if ($forKidsExists) {
        $extraServicesQuery->where(function ($q) {
            $q->where('for_kids', false);
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'use_as_category_card')) {
                $q->orWhere('use_as_category_card', true);
            }
        });
    }
    $extraServices = $extraServicesQuery->orderBy('name')->get();

    return view('home', compact('servicePrices', 'extraServices'));
})->name('home');

// Admin CMS routes for services
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Service CMS
    Route::get('services',                       [AdminServiceController::class, 'index'])          ->name('services.index');
    Route::get('services/create',                [AdminServiceController::class, 'create'])         ->name('services.create');
    Route::post('services',                      [AdminServiceController::class, 'store'])          ->name('services.store');
    Route::get('services/{service}/edit',        [AdminServiceController::class, 'edit'])           ->name('services.edit');
    Route::get('services/{service}',             [AdminServiceController::class, 'show'])           ->name('services.show');
    Route::put('services/{service}',             [AdminServiceController::class, 'update'])         ->name('services.update');
    Route::patch('services/{service}/discount',  [AdminServiceController::class, 'updateDiscount'])->name('services.discount');
    Route::delete('services/{service}',          [AdminServiceController::class, 'destroy'])       ->name('services.destroy');

    Route::get('settings', [SiteSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SiteSettingsController::class, 'update'])->name('settings.update');
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
        // Disable a date only when pending/confirmed bookings reach the CMS daily cap.
        // Schedule blocks are handled separately by /schedules/blocked-dates.
        $maxBookingsPerDay = \App\Support\SiteSettings::maxBookingsPerDay();

        // Only get dates with pending or confirmed bookings (exclude cancelled and completed)
        $bookedDates = \App\Models\Booking::whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('appointment_date, COUNT(*) as booking_count')
            ->groupBy('appointment_date')
            ->get()
            ->map(function ($booking) use ($maxBookingsPerDay) {
                // Format date as YYYY-MM-DD for JavaScript
                $formattedDate = \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d');
                return [
                    'date' => $formattedDate,
                    'original_date' => $booking->appointment_date,
                    'count' => $booking->booking_count,
                    // Disable only when fully booked for the day.
                    'disabled' => ((int)($booking->booking_count ?? 0) >= (int)$maxBookingsPerDay)
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

// Public endpoints for blocked dates (used by booking calendar)
Route::get('/schedules/blocked-dates', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedDates'])->name('schedules.blocked-dates');
Route::get('/schedules/blocked-list', [\App\Http\Controllers\Admin\ScheduleController::class, 'blockedList'])->name('schedules.blocked-list');

// Sitemap.xml generator
Route::get('/sitemap.xml', function () {
    $baseUrl = config('app.url');
    $now = now()->toAtomString();

    $urls = [
        [
            'loc' => $baseUrl,
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ],
        [
            'loc' => $baseUrl . '/calendar',
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.9'
        ],
        [
            'loc' => $baseUrl . '/kids-selector',
            'lastmod' => $now,
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'loc' => $baseUrl . '/login',
            'lastmod' => $now,
            'changefreq' => 'monthly',
            'priority' => '0.4'
        ],
        [
            'loc' => $baseUrl . '/register',
            'lastmod' => $now,
            'changefreq' => 'monthly',
            'priority' => '0.4'
        ],
    ];

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    foreach ($urls as $url) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($url['loc']) . "</loc>\n";
        $xml .= "    <lastmod>" . htmlspecialchars($url['lastmod']) . "</lastmod>\n";
        $xml .= "    <changefreq>" . htmlspecialchars($url['changefreq']) . "</changefreq>\n";
        $xml .= "    <priority>" . htmlspecialchars($url['priority']) . "</priority>\n";
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Booking success page
Route::get('/booking/success', function () {
    // Check if we have booking details in session
    $bookingDetails = session('booking_details');
    return view('booking.success', compact('bookingDetails'));
})->name('booking.success');

// Calendar booking page
Route::get('/calendar', function () {
    \App\Support\AdultServiceCatalog::ensureRequiredCmsServices();
    // Same hardcoded slugs as home — anything NOT in this list is a CMS-added service
    $hardcodedSlugs = [
        'small-knotless','smedium-knotless','medium-knotless','jumbo-knotless',
        'small-boho','smedium-boho','medium-boho','jumbo-boho',
        'small-twist','medium-twist','jumbo-twist',
        'small-natural-hair-twist','medium-natural-hair-twist',
        'kinky-twist','passion-twist','twist-braids',
        'stitch-weave','cornrow-weave','under-wig-weave','weave-braid-mixed',
        'small-french-curl','smedium-french-curl','medium-french-curl','large-french-curl',
        'line-single','afro-crotchet','individual-loc','individual-crotchet','butterfly-locks','weave-crotchet',
        'natural-hair-treatment','chemical-relaxer',
        'kids-braids','stitch-braids','hair-mask',
        'weaving-crotchet','single-crotchet','natural-hair-twist','weaving-no-extension',
        'wig-installation','custom',
    ];
    // Exclude for_kids services — they appear only in the kids selector, not the main services section.
    $forKidsExists = \Illuminate\Support\Facades\Schema::hasColumn('services', 'for_kids');
    $calExtraQuery = \App\Models\Service::where('is_active', true);
    if ($forKidsExists) {
        $calExtraQuery->where(function ($q) {
            $q->where('for_kids', false);
            if (\Illuminate\Support\Facades\Schema::hasColumn('services', 'use_as_category_card')) {
                $q->orWhere('use_as_category_card', true);
            }
        });
    }
    $extraServices = $calExtraQuery->orderBy('name')->get();
    return view('calendar', compact('extraServices'));
})->name('calendar');

// Public auth (optional accounts)
Route::middleware('guest')->group(function () {
    Route::get('/login', [PublicAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [PublicAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [PublicAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [PublicAuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [PublicAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/my-bookings', [AccountController::class, 'myBookings'])->middleware('auth')->name('account.bookings');
Route::get('/my-bookings/{booking}', [AccountController::class, 'showBooking'])->middleware('auth')->name('account.bookings.show');

// Kids Braids Selector page
Route::get('/kids-selector', function () {
    \App\Support\KidsStyleCatalog::ensureCmsServices();
    // Pass service prices to the selector page (from config or Service model)
    $servicePrices = config('service_prices', []);
    $forKidsExists2 = \Illuminate\Support\Facades\Schema::hasColumn('services', 'for_kids');
    $cmsKidsServices = $forKidsExists2
        ? \App\Support\KidsStyleCatalog::customServices()
        : collect();
    return view('kids-selector', compact('servicePrices', 'cmsKidsServices'));
})->name('kids.selector');

// Handle kids selector submission (server-side) and redirect to home with flashed session
Route::post('/kids-selector/submit', function (Request $request) {
    $data = $request->validate([
        'kb_braid_type' => 'required|string',
        'kb_finish' => 'nullable|string',
        'kb_length' => 'required|string',
        'extras' => 'nullable|string',
        'kb_extras' => 'nullable|string',
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
        'extras' => $data['kb_extras'] ?? ($data['extras'] ?? null),
    ];

    // Flash to session for one-time consumption on home page
    return redirect()->route('home')->with('kids_selector', $payload);
})->name('kids.selector.submit');

// Price preview API (server-side canonical breakdown)
Route::post('/api/price/preview', [\App\Http\Controllers\AppointmentController::class, 'previewPrice'])->name('api.price.preview');

Route::get('/admin/login', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return view('admin.login-simple');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (! Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    if (! Auth::user()->is_admin) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return back()->withErrors(['email' => 'You do not have admin privileges.'])->withInput();
    }

    $request->session()->regenerate();

    return redirect()->route('admin.dashboard')->with('success', 'Welcome back!');
})->middleware('throttle:5,1')->name('admin.login.submit');

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // Admin dashboard (accessible after login)
    Route::get('/dashboard', function () {
        try {
            $query = AdminBookingFilters::apply(\App\Models\Booking::query(), request());

// Paginate bookings (10 per page)
            $bookings = $query->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                    ->paginate(10);

            $rescheduleRequests = collect();
            $pendingRescheduleCount = 0;
            try {
                if (\Illuminate\Support\Facades\Schema::hasColumn('bookings', 'reschedule_request_status')) {
                    $rescheduleRequests = \App\Models\Booking::query()
                        ->where('reschedule_request_status', 'pending')
                        ->whereNotIn('status', ['cancelled', 'completed'])
                        ->orderByDesc('reschedule_requested_at')
                        ->take(12)
                        ->get();
                    $pendingRescheduleCount = \App\Models\Booking::query()
                        ->where('reschedule_request_status', 'pending')
                        ->whereNotIn('status', ['cancelled', 'completed'])
                        ->count();
                }
            } catch (\Throwable $e) {
                $rescheduleRequests = collect();
            }

            // Revenue fallback: prefer final_price, then kids final price, then base+adjustment.
            $revenueAmountSql = 'COALESCE(final_price, kb_final_price, (COALESCE(base_price, 0) + COALESCE(length_adjustment, 0)), 0)';
            // Date fallback: some legacy completed rows may miss completed_at.
            $revenueDateSql = 'DATE(COALESCE(completed_at, appointment_date))';
            $todayRevenue = (float) (\App\Models\Booking::where('status', 'completed')
                ->whereRaw($revenueDateSql . ' = ?', [today()->toDateString()])
                ->selectRaw('COALESCE(SUM(' . $revenueAmountSql . '), 0) as total')
                ->value('total') ?? 0);
            $monthlyRevenue = (float) (\App\Models\Booking::where('status', 'completed')
                ->whereRaw($revenueDateSql . ' BETWEEN ? AND ?', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
                ->selectRaw('COALESCE(SUM(' . $revenueAmountSql . '), 0) as total')
                ->value('total') ?? 0);

            $stats = [
                'total_bookings' => \App\Models\Booking::count(),
                'pending_bookings' => \App\Models\Booking::where('status', 'pending')->count(),
                'awaiting_deposit' => \App\Models\Booking::where('status', 'pending')
                    ->where(function ($q) {
                        $q->whereNull('payment_status')->orWhere('payment_status', 'pending');
                    })->count(),
                'confirmed_bookings' => \App\Models\Booking::where('status', 'confirmed')->count(),
                'completed_bookings' => \App\Models\Booking::where('status', 'completed')->count(),
                'today_bookings' => \App\Models\Booking::whereDate('appointment_date', today())
                    ->whereIn('status', ['pending', 'confirmed', 'completed'])
                    ->count(),
                'this_week_bookings' => \App\Models\Booking::whereBetween('appointment_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                // Revenue calculations for completed bookings only
                'today_revenue' => $todayRevenue,
                'monthly_revenue' => $monthlyRevenue,
            ];

            // Also fetch recent custom service requests for admin review
            try {
                $customRequests = \App\Models\CustomServiceRequest::orderBy('created_at', 'desc')->take(10)->get();
            } catch (\Exception $e) {
                Log::warning('Failed to fetch custom service requests: ' . $e->getMessage());
                $customRequests = collect([]); // Empty collection as fallback
            }

            return view('admin.dashboard', compact('bookings', 'stats', 'customRequests', 'rescheduleRequests', 'pendingRescheduleCount'));
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

    Route::get('/bookings/export.csv', [BookingExportController::class, 'bookings'])->name('bookings.export');
    Route::get('/revenue/export.csv', [BookingExportController::class, 'revenue'])->name('revenue.export');

    // Completed services page
    Route::get('/completed-services', function () {
        $completedServicesQuery = \App\Models\Booking::completed()
            ->orderBy('completed_at', 'desc');

        if (request('date')) {
            $completedServicesQuery->whereDate('appointment_date', request('date'));
        }

        if (request('service')) {
            $completedServicesQuery->where('service', 'LIKE', '%' . request('service') . '%');
        }

        $completedServices = $completedServicesQuery->paginate(15)
            ->appends(request()->all());

        $stats = [
            'completed_bookings' => \App\Models\Booking::where('status', 'completed')->count(),
        ];

        return view('admin.completed-services', compact('completedServices', 'stats'));
    })->name('completed-services');

    // Revenue history page for growth tracking
    Route::get('/revenue-history', function () {
        $revenueAmountSql = 'COALESCE(final_price, kb_final_price, (COALESCE(base_price, 0) + COALESCE(length_adjustment, 0)), 0)';
        $revenueDateSql = 'DATE(COALESCE(completed_at, appointment_date))';

        $monthlyRows = \App\Models\Booking::where('status', 'completed')
            ->whereRaw($revenueDateSql . ' IS NOT NULL')
            ->selectRaw($revenueDateSql . ' as revenue_date')
            ->selectRaw($revenueAmountSql . ' as revenue_amount')
            ->get();

        $monthlyRevenueMap = [];
        foreach ($monthlyRows as $row) {
            if (!$row->revenue_date) {
                continue;
            }

            $monthKey = \Carbon\Carbon::parse($row->revenue_date)->format('Y-m');
            $monthlyRevenueMap[$monthKey] = ($monthlyRevenueMap[$monthKey] ?? 0) + (float) ($row->revenue_amount ?? 0);
        }

        $history = [];
        $cursor = now()->startOfMonth();
        for ($i = 0; $i < 12; $i++) {
            $monthKey = $cursor->format('Y-m');
            $monthLabel = $cursor->format('F Y');
            $currentRevenue = (float) ($monthlyRevenueMap[$monthKey] ?? 0);

            $prevKey = $cursor->copy()->subMonth()->format('Y-m');
            $prevRevenue = (float) ($monthlyRevenueMap[$prevKey] ?? 0);

            $growthPercent = null;
            if ($prevRevenue > 0) {
                $growthPercent = (($currentRevenue - $prevRevenue) / $prevRevenue) * 100;
            } elseif ($currentRevenue > 0) {
                $growthPercent = 100;
            }

            $history[] = [
                'month_key' => $monthKey,
                'month_label' => $monthLabel,
                'revenue' => $currentRevenue,
                'previous_revenue' => $prevRevenue,
                'growth_percent' => $growthPercent,
            ];

            $cursor->subMonth();
        }

        $summary = [
            'current_month_revenue' => (float) ($history[0]['revenue'] ?? 0),
            'previous_month_revenue' => (float) ($history[0]['previous_revenue'] ?? 0),
            'current_month_growth_percent' => $history[0]['growth_percent'] ?? null,
        ];

        return view('admin.revenue-history', compact('history', 'summary'));
    })->name('revenue-history');

    // Get booking details for modal
    Route::get('/booking-details/{id}', function ($id) {
        $booking = \App\Models\Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ]);
        }

        // Fallback: recover kids selector values from notes if kb_* columns are empty.
        try {
            $notes = (string) ($booking->notes ?? '');
            if (preg_match('/Selector:\s*(\{.*\})/s', $notes, $m)) {
                $selector = json_decode($m[1], true);
                if (is_array($selector)) {
                    if (empty($booking->kb_braid_type) && !empty($selector['braid_type'])) {
                        $booking->kb_braid_type = $selector['braid_type'];
                    }
                    if (empty($booking->kb_finish) && !empty($selector['finish'])) {
                        $booking->kb_finish = $selector['finish'];
                    }
                    if (empty($booking->kb_length) && !empty($selector['length'])) {
                        $booking->kb_length = $selector['length'];
                    }
                    if (empty($booking->kb_extras) && !empty($selector['extras'])) {
                        $booking->kb_extras = is_array($selector['extras']) ? implode(',', $selector['extras']) : (string) $selector['extras'];
                    }
                }
            }

            if (empty($booking->kb_length) && !empty($booking->length) && str_contains(strtolower((string) ($booking->service ?? '')), 'kids')) {
                $booking->kb_length = $booking->length;
            }
        } catch (\Throwable $e) {
            // Non-fatal: continue with persisted values.
        }

        $breakdown = [];
        try {
            $breakdown = $booking->getPricingBreakdown();
        } catch (\Throwable $e) {
            $breakdown = [];
        }

        return response()->json([
            'success' => true,
            'booking' => $booking,
            'breakdown' => $breakdown
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
            $previousStatus = $booking->status;

            if ($request->status === 'deposit_paid') {
                $booking->payment_status = 'deposit_paid';
                $booking->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Deposit marked as received',
                ]);
            }

            $booking->status = $request->status;

            // Add completion notes if provided
            if ($request->completion_notes) {
                $booking->completion_notes = $request->completion_notes;
            }

            // Update timestamps and completion data based on status
            if ($request->status === 'confirmed') {
                $booking->confirmed_at = now();
                if (($booking->payment_status ?? 'pending') === 'pending') {
                    $booking->payment_status = 'deposit_paid';
                }
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

            // Notify on confirm, complete, or cancel.
            try {
                if ($request->status === 'confirmed' && $booking->hasUsableEmail() && $previousStatus !== 'confirmed') {
                    \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                        ->notify(new \App\Notifications\BookingConfirmedNotification($booking));
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
            $breakdown = [];
            try { $breakdown = $booking->getPricingBreakdown(); } catch (\Throwable $e) { $breakdown = []; }
            return view('admin.booking', compact('booking', 'breakdown'));
        }

        // Fallback: check for custom service request with this id
        $customRequest = \App\Models\CustomServiceRequest::find($id);
        if ($customRequest) {
            return view('admin.booking', ['booking' => null, 'customRequest' => $customRequest]);
        }

        abort(404, 'Booking not found');
    })->name('bookings.show');

    Route::post('/bookings/{id}/reschedule-request/approve', [\App\Http\Controllers\Admin\BookingRescheduleRequestController::class, 'approve'])
        ->name('bookings.reschedule-request.approve');
    Route::post('/bookings/{id}/reschedule-request/decline', [\App\Http\Controllers\Admin\BookingRescheduleRequestController::class, 'decline'])
        ->name('bookings.reschedule-request.decline');

    Route::post('/bookings/{id}/update', function (\Illuminate\Http\Request $request, $id) {
        $booking = \App\Models\Booking::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:40',
            'service' => 'nullable|string|max:255',
            'length' => 'nullable|string|max:50',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string|max:20',
            'appointment_type' => 'nullable|string|in:in-studio,mobile',
            'address' => 'nullable|string|max:500',
            'parking_type' => 'nullable|string|in:free,paid',
            'message' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:5000',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'nullable|in:pending,deposit_paid,fully_paid',
            'final_price' => 'nullable|numeric|min:0',
            'base_price' => 'nullable|numeric|min:0',
            'length_adjustment' => 'nullable|numeric',
            'kb_braid_type' => 'nullable|string|max:100',
            'kb_finish' => 'nullable|string|max:100',
            'kb_length' => 'nullable|string|max:50',
            'kb_extras' => 'nullable|string|max:500',
            'hair_mask_option' => 'nullable|string|max:100',
            'stitch_rows_option' => 'nullable|string|max:100',
        ]);

        $before = [
            'service' => $booking->service,
            'appointment_date' => optional($booking->appointment_date)->format('Y-m-d'),
            'appointment_time' => $booking->appointment_time,
            'final_price' => $booking->final_price,
        ];

        try {
            $data['appointment_time'] = \Carbon\Carbon::parse($data['appointment_time'])->format('H:i');
        } catch (\Throwable $e) {
            // keep posted value
        }

        if (($data['appointment_type'] ?? '') !== 'mobile') {
            $data['address'] = $data['address'] ?? $booking->address;
            $data['parking_type'] = null;
        }

        $booking->fill($data);
        $becameConfirmed = $data['status'] === 'confirmed' && $booking->getOriginal('status') !== 'confirmed';
        if ($data['status'] === 'confirmed' && !$booking->confirmed_at) {
            $booking->confirmed_at = now();
        }
        if ($becameConfirmed && ($booking->payment_status ?? 'pending') === 'pending') {
            $booking->payment_status = 'deposit_paid';
        }
        if ($data['status'] === 'cancelled' && !$booking->cancelled_at) {
            $booking->cancelled_at = now();
        }
        $booking->save();

        if ($becameConfirmed && $booking->hasUsableEmail()) {
            try {
                \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                    ->notify(new \App\Notifications\BookingConfirmedNotification($booking));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to send booking confirmed email', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $after = [
            'service' => $booking->service,
            'appointment_date' => optional($booking->appointment_date)->format('Y-m-d'),
            'appointment_time' => $booking->appointment_time,
            'final_price' => $booking->final_price,
        ];

        if ($before != $after) {
            try {
                $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
                $notif = new \App\Notifications\BookingModifiedNotification($booking, $before, $after);
                if (!empty($booking->email) && $booking->email !== 'no-email@example.com') {
                    \Illuminate\Support\Facades\Notification::route('mail', $booking->email)->notify($notif);
                }
                if ($adminEmail) {
                    \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)->notify($notif);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Admin booking update notification failed', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('admin.bookings.show', ['id' => $booking->id])
            ->with('success', 'Booking updated.');
    })->name('bookings.update');

    // Update status for custom service requests
    Route::post('/custom-requests/{id}/status', function(Request $request, $id) {
        $request->validate(['status' => 'required|string']);

        $model = \App\Models\CustomServiceRequest::findOrFail($id);
        $model->status = $request->status;
        $model->save();

        return response()->json(['success' => true, 'message' => 'Status updated', 'status' => $model->status]);
    })->name('custom-requests.update-status');

    Route::get('/custom-requests/{id}', function ($id) {
        $customRequest = \App\Models\CustomServiceRequest::findOrFail($id);

        return view('admin.booking', ['booking' => null, 'customRequest' => $customRequest]);
    })->name('custom-requests.show');

    Route::post('/custom-requests/{id}/convert', [ConvertCustomRequestController::class, 'store'])
        ->name('custom-requests.convert');

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
    Route::post('/schedules/reuse-previous-month', [\App\Http\Controllers\Admin\ScheduleController::class, 'reusePreviousMonthBlockedDates'])->name('schedules.reuse-previous-month');
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

// Booking routes - simplified closure implementation
Route::post('/bookings', function(Request $request) {
    if (\App\Support\FormGuard::isBot($request)) {
        if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true]);
        }
        return redirect()->route('home');
    }

    // Handle sample_picture validation separately to avoid empty file issues
    $validationRules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => ['required','string','regex:/^[0-9+\-\s()]+$/','min:7','max:20'],
        'service' => 'nullable|string|max:255',
        'appointment_type' => 'required|string|in:in-studio,mobile',
        'address' => 'nullable|string|max:500|required_if:appointment_type,mobile',
        'parking_type' => 'nullable|string|in:free,paid|required_if:appointment_type,mobile',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required|string',
        'message' => 'nullable|string|max:1000',
        'hair_mask_option' => 'nullable|string|max:50',
        'stitch_rows_option' => 'nullable|string|in:ten_or_less,more_than_ten,fifteen_or_more',
        'frontback_addon' => 'nullable|string|in:yes,no',
        'final_price' => 'nullable|numeric|min:0|max:9999.99',
        // Must accept terms at submit time (server-side enforcement)
        'terms_accepted' => 'accepted',
        'booking_origin' => 'nullable|string|in:home,kids-selector',
        'parent_name' => 'nullable|string|max:255',
        'child_age' => 'nullable|integer|min:3|max:8',
        'hair_color' => 'nullable|string|max:80',
        'comments' => 'nullable|string|max:800',
    ];

    // Only validate sample_picture if a file was actually uploaded
    if ($request->hasFile('sample_picture')) {
        $file = $request->file('sample_picture');
        if ($file->isValid() && $file->getError() === UPLOAD_ERR_OK) {
            $validationRules['sample_picture'] = 'file|image|mimes:jpeg,png,jpg,gif|max:5120'; // 5MB max
        }
    }

    $isKidsBooking = str_contains(strtolower((string) ($request->input('service_type') ?: $request->input('service') ?: '')), 'kids')
        || $request->input('booking_origin') === 'kids-selector'
        || $request->filled('kb_braid_type');
    if ($isKidsBooking) {
        $validationRules['parent_name'] = 'required|string|max:255';
        $validationRules['child_age'] = 'required|integer|min:3|max:8';
    }

    // Validate the booking form
    $request->validate($validationRules);

    // Extra guard for mobile appointments: require a meaningful trimmed address.
    if ($request->input('appointment_type') === 'mobile') {
        $trimmedAddress = trim((string) $request->input('address', ''));
        $parkingType = trim((string) $request->input('parking_type', ''));
        if (mb_strlen($trimmedAddress) < 10) {
            $addressMessage = 'Please enter a complete mobile service address (at least 10 characters).';
            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => $addressMessage,
                    'errors' => ['address' => [$addressMessage]],
                ], 422);
            }

            return redirect()->route(\App\Support\BookingReturn::routeName($request))
                ->withErrors(['address' => $addressMessage])
                ->withInput()
                ->with([
                    'booking_error' => true,
                    'error_message' => $addressMessage,
                ]);
        }

        if (!in_array($parkingType, ['free', 'paid'], true)) {
            $parkingMessage = 'Please choose whether parking is free or paid for the mobile appointment address.';
            if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => $parkingMessage,
                    'errors' => ['parking_type' => [$parkingMessage]],
                ], 422);
            }

            return redirect()->route(\App\Support\BookingReturn::routeName($request))
                ->withErrors(['parking_type' => $parkingMessage])
                ->withInput()
                ->with([
                    'booking_error' => true,
                    'error_message' => $parkingMessage,
                ]);
        }

        $request->merge(['address' => $trimmedAddress]);
        $request->merge(['parking_type' => $parkingType]);
    }

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

        $kidsMessage = \App\Support\BookingReturn::composeKidsMessage($request);
        if ($kidsMessage) {
            $request->merge(['message' => $kidsMessage]);
        }

        $bookingData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $normalizedPhone,
            'address' => $request->address,
            'appointment_type' => $request->appointment_type,
            'parking_type' => $request->parking_type,
            'service' => $request->service ?: 'General Service',
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message' => $request->message, // Store in message field
            'notes' => $request->message,   // Also store in notes field for compatibility
            'sample_picture' => $samplePicturePath,
            'stitch_rows_option' => $request->input('stitch_rows_option') ?: null,
            'status' => 'pending',
            'payment_status' => 'pending',
        ];

        // Capture kids selector fields if present (supports both kb_* and plain selector keys)
        // and append to notes for email fidelity.
        try{
            $selectorFields = [];
            if($request->filled('kb_braid_type')) $selectorFields['braid_type'] = $request->input('kb_braid_type');
            if($request->filled('braid_type') && empty($selectorFields['braid_type'])) $selectorFields['braid_type'] = $request->input('braid_type');

            if($request->filled('kb_finish')) $selectorFields['finish'] = $request->input('kb_finish');
            if($request->filled('finish') && empty($selectorFields['finish'])) $selectorFields['finish'] = $request->input('finish');

            if($request->filled('kb_length')) $selectorFields['length'] = $request->input('kb_length');

            if($request->filled('kb_extras')) $selectorFields['extras'] = $request->input('kb_extras');
            if($request->filled('extras') && empty($selectorFields['extras'])) $selectorFields['extras'] = $request->input('extras');

            $serviceTypeInput = strtolower((string) ($request->input('service_type') ?? ''));
            $serviceNameInput = strtolower((string) ($request->input('service') ?? ''));
            $explicitKidsService = (
                $serviceTypeInput === 'kids-braids' ||
                str_contains($serviceTypeInput, 'kids') ||
                str_contains($serviceNameInput, 'kids braids')
            );

            // Only kids-specific selector signals should route to kids flow.
            // Generic length/hair_length fields are used by normal services too.
            $hasKidsSelectorSignals = (
                $request->filled('kb_braid_type') ||
                $request->filled('braid_type') ||
                $request->filled('kb_finish') ||
                $request->filled('finish') ||
                $request->filled('kb_extras') ||
                $request->filled('extras') ||
                $request->filled('kb_length')
            );

            // If this is explicitly a kids service and kb_length was not posted, allow
            // length/hair_length fallback to preserve older kids client payloads.
            if($explicitKidsService && empty($selectorFields['length'])) {
                if($request->filled('hair_length')) $selectorFields['length'] = $request->input('hair_length');
                if($request->filled('length') && empty($selectorFields['length'])) $selectorFields['length'] = $request->input('length');
            }

            $isKidsServiceSubmission = (
                $explicitKidsService ||
                $hasKidsSelectorSignals
            );

            if ($isKidsServiceSubmission) {
                $bookingData['service_type'] = 'kids-braids';
            }

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
                $typeAdj = ['protective'=>-20,'cornrows'=>-30,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];
                $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];

                $adjustments = 0; $addons = 0;
                $bt = $selectorFields['braid_type'] ?? null;
                $ln = $selectorFields['length'] ?? null;
                $fi = $selectorFields['finish'] ?? null;
                $ex = $selectorFields['extras'] ?? null;

                $catalogPrice = \App\Support\KidsStyleCatalog::startingPrice($bt);
                if ($catalogPrice !== null) {
                    $baseConfigured = $catalogPrice;
                } elseif ($bt && isset($typeAdj[$bt])) {
                    $adjustments += $typeAdj[$bt];
                }
                if (\App\Support\KidsStyleCatalog::usesLengthSteps($bt)) {
                    if ($ln && isset($lengthAdj[$ln])) $adjustments += $lengthAdj[$ln];
                    if ($fi && isset($finishAdj[$fi])) $adjustments += $finishAdj[$fi];
                }

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
                $bookingData['kb_addons_total'] = round($addons, 2);
                $bookingData['kb_final_price'] = $finalKidsPrice;
            } elseif ($isKidsServiceSubmission) {
                // Kids service without complete selector payload: still persist what we have
                // and compute an authoritative server-side total.
                $bookingData['kb_braid_type'] = $selectorFields['braid_type'] ?? null;
                $bookingData['kb_finish'] = $selectorFields['finish'] ?? null;
                $bookingData['kb_length'] = $selectorFields['length'] ?? null;
                $bookingData['kb_extras'] = $selectorFields['extras'] ?? null;

                $baseConfigured = (float) (config('service_prices.kids_braids', 80));
                $typeAdj = ['protective'=>-20,'cornrows'=>-30,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];
                $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];

                $adjustments = 0; $addons = 0;
                $bt = $bookingData['kb_braid_type'] ?? null;
                $ln = $bookingData['kb_length'] ?? null;
                $fi = $bookingData['kb_finish'] ?? null;
                $ex = $bookingData['kb_extras'] ?? null;

                $catalogPrice = \App\Support\KidsStyleCatalog::startingPrice($bt);
                if ($catalogPrice !== null) {
                    $baseConfigured = $catalogPrice;
                } elseif ($bt && isset($typeAdj[$bt])) {
                    $adjustments += $typeAdj[$bt];
                }
                if (\App\Support\KidsStyleCatalog::usesLengthSteps($bt)) {
                    if ($ln && isset($lengthAdj[$ln])) $adjustments += $lengthAdj[$ln];
                    if ($fi && isset($finishAdj[$fi])) $adjustments += $finishAdj[$fi];
                }

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
                $bookingData['kb_base_price'] = $baseConfigured;
                $bookingData['kb_length_adjustment'] = $adjustments;
                $bookingData['kb_addons_total'] = round($addons, 2);
                $bookingData['kb_final_price'] = $finalKidsPrice;
            }
        }catch(
        Exception $e){ /* noop */ }

        // If this is a kids-braids submission, ensure a length was provided (kb_length or length/hair_length)
        if (!empty($bookingData['service_type']) && $bookingData['service_type'] === 'kids-braids') {
            $providedBraid = $bookingData['kb_braid_type'] ?? $request->input('braid_type') ?? $request->input('kb_braid_type') ?? null;
            if (empty($providedBraid)) {
                if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json(['success' => false, 'message' => 'Please choose a braid type for kids braids.'], 422);
                }
                return redirect()->route('kids.selector')->withErrors(['kb_braid_type' => 'Please choose a braid type for kids braids'])->withInput()->with([
                    'booking_error' => true,
                    'error_message' => 'Please choose a braid type for kids braids.',
                ]);
            }
            $bookingData['kb_braid_type'] = strtolower(trim((string) $providedBraid));

            $providedLength = $bookingData['kb_length'] ?? $request->input('length') ?? $request->input('hair_length') ?? null;
            if (empty($providedLength)) {
                // Return early with a validation-like error so the user can correct the form
                if ($request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                    return response()->json(['success' => false, 'message' => 'Please select a hair length for kids braids.'], 422);
                }
                return redirect()->route('kids.selector')->withErrors(['length' => 'Please select a hair length for kids braids'])->withInput()->with([
                    'booking_error' => true,
                    'error_message' => 'Please select a hair length for kids braids.',
                ]);
            }

            // Normalize kb_length to canonical format server-side
            $norm = strtolower(trim((string)$providedLength));
            $norm = str_replace([' ', '-'], ['_', '_'], $norm);
            $norm = str_replace(['tail_bone','tail bone','tail-bone','tailbone','tail_bone'], 'tailbone', $norm);
            $norm = str_replace(['bra strap','bra-strap','bra_strap'], 'bra_strap', $norm);
            $bookingData['kb_length'] = $norm;

            // Normalize kids finish; default to plain when not provided.
            $providedFinish = $bookingData['kb_finish'] ?? $request->input('finish') ?? $request->input('kb_finish') ?? null;
            if (empty($providedFinish)) {
                $bookingData['kb_finish'] = 'plain';
            } else {
                $bookingData['kb_finish'] = strtolower(trim((string) $providedFinish));
            }
        }

        // Normalize incoming length (accept hair_length or length or kb_length)
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
            // Use the service name as the booking's canonical service, but strip UI suffixes like "(With Weave)"
            $serviceInput = $request->input('service') ?: $request->input('service_display') ?: null;
            $serviceInputClean = is_string($serviceInput)
                ? trim(preg_replace('/\s*\((?:with\s*weav(?:e|ing)|10\+\s*rows|front\s*\+\s*back)\)\s*/i', '', $serviceInput))
                : $serviceInput;
            if (!empty($serviceInputClean)) {
                $bookingData['service'] = $serviceInputClean;
            }

            $serviceModel = null;
            if ($serviceInputClean) {
                // Try slug first (exact match)
                $serviceModel = Service::where('slug', $serviceInputClean)->first();
                if (!$serviceModel) {
                    // Try by name (exact match)
                    $serviceModel = Service::where('name', $serviceInputClean)->first();
                }
                if (!$serviceModel) {
                    // Try by name case-insensitive
                    $serviceModel = Service::whereRaw('LOWER(name) = ?', [strtolower($serviceInputClean)])->first();
                }
                if (!$serviceModel) {
                    // Try by slug (convert service name to slug format for lookup)
                    $slugFromName = strtolower(str_replace([' ', '-'], '-', $serviceInputClean));
                    $serviceModel = Service::where('slug', $slugFromName)->first();
                }
            }

            // If this is NOT a kids-selector booking, compute authoritative pricing server-side
            // (kids pricing is computed earlier and stored in kb_* fields).
            if (empty($bookingData['kb_final_price'])) {
                $calculator = new \App\Services\PriceCalculator();
                $break = $calculator->calculate([
                    'service_input' => $serviceInputClean,
                    'service_model' => $serviceModel,
                    // service_type is often a slug posted by the UI; fall back to name
                    'service_type' => $request->input('service_type') ?: ($serviceInputClean ?? ''),
                    'length' => $length,
                    'hair_mask_option' => $request->input('hair_mask_option'),
                    'stitch_rows_option' => $request->input('stitch_rows_option'),
                    'frontback_addon' => $request->input('frontback_addon'),
                ]);

                $bookingData['base_price'] = $break['base_price'] ?? ($serviceModel ? (float)$serviceModel->base_price : (float) config('service_prices.default', 150));
                $bookingData['length_adjustment'] = $break['length_adjustment'] ?? 0.00;

                // Use client-submitted final_price if available (from size modal), otherwise use calculated price
                $clientFinalPrice = $request->input('final_price');
                if (!empty($clientFinalPrice) && is_numeric($clientFinalPrice)) {
                    $bookingData['final_price'] = (float)$clientFinalPrice;
                    Log::info('Using client-submitted final_price', ['final_price' => $clientFinalPrice]);
                } else {
                    $bookingData['final_price'] = $break['final_price'] ?? $bookingData['base_price'];
                    Log::info('Using server-calculated final_price', ['final_price' => $bookingData['final_price']]);
                }

                $bookingData['length'] = $length;

                // Persist hair mask option when provided (used in emails for "with weaving")
                if ($request->filled('hair_mask_option')) {
                    $bookingData['hair_mask_option'] = $request->input('hair_mask_option');
                }

                // Capture front/back add-on in notes for visibility (no DB column required)
                if ($request->input('frontback_addon') === 'yes') {
                    $bookingData['notes'] = trim(($bookingData['notes'] ?? '') . "\nFront + Back add-on: yes");
                }
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

        // Link booking to logged-in user (optional accounts)
        if (Auth::check()) {
            $bookingData['user_id'] = Auth::id();

            // If the booking email is empty/placeholder, use the account email
            $currentEmail = $bookingData['email'] ?? null;
            if (!$currentEmail || $currentEmail === 'no-email@example.com') {
                $bookingData['email'] = Auth::user()->email;
            }
        }

        if (!array_key_exists('parking_type', $bookingData)) {
            $bookingData['parking_type'] = $request->input('parking_type');
        }

        $durationHours = ServiceDuration::hoursForName($bookingData['service'] ?? null);
        $durationMinutes = ServiceDuration::toMinutes($durationHours)
            + ServiceDuration::extraMinutesForKidsExtras($bookingData['kb_extras'] ?? $request->input('kb_extras') ?? $request->input('extras'));
        $bookingData['service_duration_minutes'] = $durationMinutes;
        $durationHours = $durationMinutes / 60;

        // Create the booking (lock the date so two clients cannot take the same slot)
        Log::info('=== CREATING BOOKING ===', ['data' => $bookingData]);
        try {
            $booking = app(BookingSlotGuard::class)->reserve(
                (string) $bookingData['appointment_date'],
                (string) $bookingData['appointment_time'],
                fn () => \App\Models\Booking::create($bookingData),
                null,
                $durationHours
            );
        } catch (SlotUnavailableException $e) {
            $isApiRequest = $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
            if ($isApiRequest) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->route('home')->with([
                'booking_error' => true,
                'error_message' => $e->getMessage(),
            ]);
        }
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

        // Send ONE admin notification about new booking (guard against duplicates)
        try {
            // Only send admin notification if this is a fresh booking (not sent yet)
            if ($booking->status === 'pending' && !$booking->admin_notified) {
                $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
                \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                    ->notify(new \App\Notifications\AdminBookingNotification($booking));
                
                // Mark as notified to prevent duplicate sends
                $booking->admin_notified = true;
                $booking->save();
                
                Log::info('Admin booking notification queued/sent', ['booking_id' => $booking->id, 'admin_email' => $adminEmail]);
            }
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
                'appointment_type' => $booking->appointment_type,
                'address' => $booking->address,
                'appointment_type' => $booking->appointment_type,
                'address' => $booking->address,
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
})->middleware('throttle:8,1')->name('bookings.store');

Route::post('/contact', function(Request $request) {
    if (\App\Support\FormGuard::isBot($request)) {
        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }

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
            $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');

            if (empty($adminEmail) || $adminEmail === config('mail.from.address')) {
                Log::warning('Admin email not configured for contact form notification', [
                    'booking_notification_email' => env('BOOKING_NOTIFICATION_EMAIL'),
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
})->middleware('throttle:5,1')->name('contact.store');

// Custom service request form handler
Route::post('/custom-service', function(Request $request) {
    if (\App\Support\FormGuard::isBot($request)) {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with('success', 'Your custom service request has been submitted. We will contact you soon.');
    }

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
})->middleware('throttle:5,1')->name('custom-service.store');

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

Route::get('/bookings/details', function(Request $request) {
    return response()->json(['details' => []]);
})->name('bookings.details');

// Public booking confirmation link - shows booking details only when confirmation code matches
Route::get('/bookings/confirm/{id}/{code}', function($id, $code) {
    $booking = \App\Models\Booking::find($id);
    if (!$booking || ($booking->confirmation_code ?? '') !== $code) {
        return redirect()->route('home')->with(['booking_error' => true, 'error_message' => 'Invalid booking confirmation link.']);
    }

    // Render the booking details page (reuse booking.success view but pass richer context)
    $bookingDetails = [
        'id' => $booking->id,
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
        'appointment_type' => $booking->appointment_type,
        'address' => $booking->address,
        'sample_picture' => $booking->sample_picture,
        // Kids selector fields (if applicable)
        'kb_braid_type' => $booking->kb_braid_type,
        'kb_finish' => $booking->kb_finish,
        'kb_length' => $booking->kb_length,
        'kb_extras' => $booking->kb_extras,
        'status' => $booking->status,
    ];

    $breakdown = [];
    try { $breakdown = $booking->getPricingBreakdown(); } catch (\Throwable $e) { $breakdown = []; }

    return view('booking.success', [
        'bookingDetails' => $bookingDetails,
        'booking' => $booking,
        'breakdown' => $breakdown,
        'confirmId' => $id,
        'confirmCode' => $code,
    ]);
})->name('bookings.confirm');

// Public booking modification endpoint — clients cannot change style or time
Route::post('/bookings/confirm/{id}/{code}/modify', function(\Illuminate\Http\Request $request, $id, $code) {
    $booking = \App\Models\Booking::find($id);
    if (!$booking || ($booking->confirmation_code ?? '') !== $code) {
        return redirect()->route('home')->with(['booking_error' => true, 'error_message' => 'Invalid booking confirmation link.']);
    }

    return redirect()->route('bookings.confirm', ['id' => $id, 'code' => $code])
        ->with(['booking_error' => true, 'error_message' => 'Style and appointment time cannot be changed after booking. Please contact us at least 48 hours in advance to reschedule.']);
})->name('bookings.modify');

Route::post('/bookings/confirm/{id}/{code}/cancel', function (\Illuminate\Http\Request $request, $id, $code) {
    $booking = \App\Models\Booking::find($id);
    if (! $booking || ! hash_equals((string) ($booking->confirmation_code ?? ''), (string) $code)) {
        return redirect()->route('home')->with(['booking_error' => true, 'error_message' => 'Invalid booking confirmation link.']);
    }

    if (! $booking->canClientCancel()) {
        return redirect()->route('bookings.confirm', ['id' => $id, 'code' => $code])
            ->with(['booking_error' => true, 'error_message' => 'Cancellations need at least 48 hours’ notice, or contact us to cancel.']);
    }

    $booking->status = 'cancelled';
    $booking->cancelled_at = now();
    $booking->save();

    try {
        if ($booking->hasUsableEmail()) {
            \Illuminate\Support\Facades\Notification::route('mail', $booking->email)
                ->notify(new \App\Notifications\BookingCancelledNotification($booking, 'You'));
        }
        $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
        if ($adminEmail) {
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notify(new \App\Notifications\AdminCancellationNotice($booking, 'Client'));
        }
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::warning('Client cancel notification failed', [
            'booking_id' => $booking->id,
            'error' => $e->getMessage(),
        ]);
    }

    return redirect()->route('bookings.confirm', ['id' => $id, 'code' => $code])
        ->with('success', 'Your appointment has been cancelled.');
})->middleware('throttle:6,1')->name('bookings.cancel');

Route::post('/bookings/confirm/{id}/{code}/reschedule', function (\Illuminate\Http\Request $request, $id, $code) {
    $booking = \App\Models\Booking::find($id);
    if (! $booking || ! hash_equals((string) ($booking->confirmation_code ?? ''), (string) $code)) {
        return redirect()->route('home')->with(['booking_error' => true, 'error_message' => 'Invalid booking confirmation link.']);
    }

    if (! $booking->canClientRequestReschedule()) {
        return redirect()->route('bookings.confirm', ['id' => $id, 'code' => $code])
            ->with(['booking_error' => true, 'error_message' => 'Reschedule requests need at least 48 hours’ notice. Please contact us.']);
    }

    $data = $request->validate([
        'preferred_date' => 'required|date|after_or_equal:today',
        'preferred_time' => 'required|string|max:20',
        'note' => 'nullable|string|max:1000',
    ]);

    $preferredTime = \Carbon\Carbon::parse($data['preferred_time'])->format('H:i');
    $booking->notes = trim(($booking->notes ?? '')."\nReschedule request: ".$data['preferred_date'].' '.$preferredTime.($data['note'] ? ' — '.$data['note'] : ''));
    $booking->reschedule_requested_date = $data['preferred_date'];
    $booking->reschedule_requested_time = $preferredTime;
    $booking->reschedule_request_note = $data['note'] ?? null;
    $booking->reschedule_request_status = 'pending';
    $booking->reschedule_requested_at = now();
    $booking->save();

    try {
        $adminEmail = env('BOOKING_NOTIFICATION_EMAIL') ?: env('ADMIN_EMAIL') ?: config('mail.from.address');
        if ($adminEmail) {
            \Illuminate\Support\Facades\Notification::route('mail', $adminEmail)
                ->notify(new \App\Notifications\RescheduleRequestNotification(
                    $booking,
                    $data['preferred_date'],
                    $data['preferred_time'],
                    $data['note'] ?? null
                ));
        }
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::warning('Reschedule request email failed', [
            'booking_id' => $booking->id,
            'error' => $e->getMessage(),
        ]);
    }

    return redirect()->route('bookings.confirm', ['id' => $id, 'code' => $code])
        ->with('success', 'Your reschedule request was sent. We will confirm a new time by email.');
})->middleware('throttle:6,1')->name('bookings.reschedule-request');

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

// Serve an .ics calendar file for a booking (requires confirmation code)
Route::get('/bookings/{id}/{code}/calendar.ics', function ($id, $code) {
    $booking = \App\Models\Booking::find($id);
    $expected = (string) ($booking->confirmation_code ?? '');
    if (! $booking || $expected === '' || ! hash_equals($expected, (string) $code)) {
        abort(404);
    }

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
        $description = addslashes("Dab's Beauty Touch appointment\\nBooking " . $expected);

        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Dabs Beauty Touch//EN\r\nBEGIN:VEVENT\r\n";
        $ics .= "UID:{$uid}\r\nDTSTAMP:{$dtstamp}\r\nDTSTART:{$dtstart}\r\nDTEND:{$dtend}\r\n";
        $ics .= "SUMMARY:{$summary}\r\nDESCRIPTION:{$description}\r\n";
        $ics .= "END:VEVENT\r\nEND:VCALENDAR\r\n";

        $filename = 'booking-' . $expected . '.ics';
        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    } catch (\Exception $e) {
        abort(500, 'Could not generate calendar file');
    }
})->name('bookings.ics');

Route::get('/images/uploads/{path}', \App\Http\Controllers\PersistedImageController::class)
    ->where('path', '.*')
    ->name('images.uploads');
Route::get('/images/site/{path}', \App\Http\Controllers\PersistedImageController::class)
    ->where('path', '.*')
    ->name('images.site');
Route::get('/images/services/{path}', \App\Http\Controllers\PersistedImageController::class)
    ->where('path', '.*')
    ->name('images.services');
Route::get('/storage/service-images/{path}', \App\Http\Controllers\PersistedImageController::class)
    ->where('path', '.*')
    ->name('images.storage-services');
Route::get('/storage/site/{path}', \App\Http\Controllers\PersistedImageController::class)
    ->where('path', '.*')
    ->name('images.storage-site');
