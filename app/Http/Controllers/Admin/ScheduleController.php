<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingRescheduledNotification;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    // Return the main schedule view (optional - we embed calendar in dashboard)
    public function index()
    {
        return view('admin.schedule');
    }

    // Return JSON events for FullCalendar (schedules and bookings)
    public function events(Request $request)
    {
        $events = [];

        // Schedules (availability / blocked slots)
        $schedules = Schedule::all();
        foreach ($schedules as $slot) {
            // For blocked ranges we want the text to appear on each day cell.
            // Expand blocked ranges into separate all-day events per day so
            // FullCalendar will render the title on each date.
            if (($slot->type ?? '') === 'blocked' && $slot->start && $slot->end) {
                try {
                    // Parse the stored datetime and extract date part in UTC to avoid timezone conversion
                    // The datetime is stored in UTC, so we parse it as UTC and extract the date
                    $startParsed = Carbon::parse($slot->start)->utc();
                    $endParsed = Carbon::parse($slot->end)->utc();
                    
                    // Get date strings in UTC
                    $startDateStr = $startParsed->format('Y-m-d');
                    $endDateStr = $endParsed->format('Y-m-d');
                    
                    // Create UTC dates from the date strings to ensure no timezone shift
                    $start = Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' 00:00:00', 'UTC')->startOfDay();
                    $end = Carbon::createFromFormat('Y-m-d H:i:s', $endDateStr . ' 00:00:00', 'UTC')->startOfDay();

                    // iterate day-by-day (end is exclusive)
                    for ($d = $start->copy(); $d->lt($end); $d->addDay()) {
                        $events[] = [
                            'id' => 'slot-' . $slot->id . '-' . $d->format('Ymd'),
                            'title' => $slot->title ?? 'Blocked',
                            'start' => $d->toIso8601String(),
                            'end' => $d->copy()->addDay()->toIso8601String(),
                            'allDay' => true,
                            'extendedProps' => [
                                'type' => 'blocked',
                                'orig_slot_id' => $slot->id,
                                'meta' => $slot->meta,
                            ],
                            'editable' => false,
                            'display' => 'auto',
                            'classNames' => ['blocked-range'],
                            'backgroundColor' => $slot->toEvent()['backgroundColor'] ?? '#ffd6d6',
                            'borderColor' => $slot->toEvent()['borderColor'] ?? '#ff9c9c',
                            'textColor' => '#000000',
                        ];
                    }
                } catch (\Exception $e) {
                    // fallback to original single event when parsing fails
                    $events[] = $slot->toEvent();
                }
            } else {
                $events[] = $slot->toEvent();
            }
        }

        // Bookings shown as events - include ALL bookings regardless of status
        $bookings = Booking::whereNotNull('appointment_date')
            ->whereNotNull('appointment_time')
            ->get();
        
        foreach ($bookings as $b) {
            try {
                // Compose start from appointment_date + appointment_time
                if (!$b->appointment_date || !$b->appointment_time) {
                    continue;
                }
                $start = Carbon::parse($b->appointment_date->format('Y-m-d') . ' ' . $b->appointment_time);
                // Default duration 1 hour
                $end = (clone $start)->addHour();

                // Determine background color based on status
                $backgroundColor = match($b->status) {
                    'confirmed' => '#d1ffd6',  // Light green
                    'pending' => '#fff3cd',     // Light yellow
                    'completed' => '#cfe2ff',   // Light blue
                    'cancelled' => '#f8d7da',   // Light red
                    default => '#e9ecef'        // Light gray
                };

                $events[] = [
                    'id' => 'booking-' . $b->id,
                    'title' => ($b->name ? $b->name . ' — ' : '') . ($b->service ?: 'Service') . ' (' . ucfirst($b->status) . ')',
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'extendedProps' => [
                        'booking_id' => $b->id,
                        'status' => $b->status,
                    ],
                    'editable' => $b->status === 'confirmed' || $b->status === 'pending',
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => '#888'
                ];
            } catch (\Exception $e) {
                Log::warning('Failed to convert booking to event: ' . $e->getMessage(), ['booking_id' => $b->id]);
                continue;
            }
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'nullable|string|max:255',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'staff_id' => 'nullable|integer',
                'type' => 'nullable|string',
            ]);

            // If creating a blocked range, validate it does not overlap existing bookings
            if (($data['type'] ?? '') === 'blocked') {
                try {
                    // Extract date directly from ISO string to avoid timezone conversion issues
                    // ISO format: "2025-12-31T00:00:00.000Z" - extract YYYY-MM-DD part
                    $startIso = $data['start'];
                    $endIso = $data['end'];
                    
                    // Extract date part from ISO string (before the 'T')
                    preg_match('/^(\d{4}-\d{2}-\d{2})T/', $startIso, $startMatch);
                    preg_match('/^(\d{4}-\d{2}-\d{2})T/', $endIso, $endMatch);
                    
                    if (!$startMatch || !$endMatch) {
                        throw new \Exception('Invalid date format in ISO string');
                    }
                    
                    $startDateStr = $startMatch[1]; // e.g., "2025-12-31"
                    $endDateStr = $endMatch[1];     // e.g., "2026-01-01"
                    
                    // Parse the date components
                    list($startYear, $startMonth, $startDay) = explode('-', $startDateStr);
                    list($endYear, $endMonth, $endDay) = explode('-', $endDateStr);
                    
                    // Create UTC dates directly from the date components (no timezone conversion)
                    $s = Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' 00:00:00', 'UTC')->startOfDay();
                    $e = Carbon::createFromFormat('Y-m-d H:i:s', $endDateStr . ' 00:00:00', 'UTC')->startOfDay();
                    
                    // Update the data array with normalized UTC dates to ensure correct storage
                    $data['start'] = $s->toIso8601String();
                    $data['end'] = $e->toIso8601String();
                    
                    Log::info('Blocked range date normalization', [
                        'original_start' => $startIso,
                        'original_end' => $endIso,
                        'extracted_start_date' => $startDateStr,
                        'extracted_end_date' => $endDateStr,
                        'normalized_start' => $data['start'],
                        'normalized_end' => $data['end']
                    ]);

                    // Find any pending/confirmed bookings that fall within [s, e)
                    $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                        ->whereDate('appointment_date', '>=', $s->toDateString())
                        ->whereDate('appointment_date', '<', $e->toDateString())
                        ->get();

                    if ($conflicts->isNotEmpty()) {
                        $list = $conflicts->map(function ($b) {
                            return [
                                'id' => $b->id,
                                'name' => $b->name,
                                'date' => $b->appointment_date?->toDateString(),
                                'time' => $b->appointment_time,
                            ];
                        });

                        return response()->json([
                            'success' => false,
                            'message' => 'Blocked range overlaps existing pending/confirmed bookings',
                            'conflicts' => $list,
                        ], 422);
                    }
                } catch (\Exception $e) {
                    // If parsing fails, continue and let creation happen (but log)
                    Log::warning('Failed to validate blocked range against bookings: ' . $e->getMessage());
                }
            }

            $slot = Schedule::create($data);

            return response()->json(['success' => true, 'slot' => $slot]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Failed to create schedule slot: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create blocked range: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $slot = Schedule::findOrFail($id);
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'staff_id' => 'nullable|integer',
            'type' => 'nullable|string',
        ]);

        // If updating to a blocked range, validate it does not overlap existing bookings
        if (($data['type'] ?? '') === 'blocked') {
            try {
                $s = Carbon::parse($data['start'])->startOfDay();
                $e = Carbon::parse($data['end'])->startOfDay();

                $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                    ->whereDate('appointment_date', '>=', $s->toDateString())
                    ->whereDate('appointment_date', '<', $e->toDateString())
                    ->get();

                if ($conflicts->isNotEmpty()) {
                    $list = $conflicts->map(function ($b) {
                        return [
                            'id' => $b->id,
                            'name' => $b->name,
                            'date' => $b->appointment_date?->toDateString(),
                            'time' => $b->appointment_time,
                        ];
                    });

                    return response()->json([
                        'success' => false,
                        'message' => 'Blocked range overlaps existing pending/confirmed bookings',
                        'conflicts' => $list,
                    ], 422);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to validate blocked range against bookings (update): ' . $e->getMessage());
            }
        }

        $slot->update($data);

        return response()->json(['success' => true, 'slot' => $slot]);
    }

    public function destroy($id)
    {
        $slot = Schedule::findOrFail($id);
        $slot->delete();
        return response()->json(['success' => true]);
    }

    // Reschedule a booking (called from FullCalendar eventDrop)
    public function reschedule(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'start' => 'required|date',
            'end' => 'nullable|date'
        ]);

        $booking = Booking::findOrFail($data['booking_id']);

        // Format the old date/time using application timezone for clarity
        $oldTimeFormatted = null;
        try {
            if ($booking->appointment_date && $booking->appointment_time) {
                $oldStart = Carbon::parse($booking->appointment_date->format('Y-m-d') . ' ' . $booking->appointment_time);
                $oldTimeFormatted = $oldStart->format('g:i A');
            }
        } catch (\Exception $e) { $oldTimeFormatted = $booking->appointment_time; }

        $old = [
            'date' => $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : null,
            'time' => $oldTimeFormatted ?? $booking->appointment_time
        ];

        $start = Carbon::parse($data['start']);
        $end = isset($data['end']) ? Carbon::parse($data['end']) : (clone $start)->addHour();

        // Prevent rescheduling into blocked ranges
        $blockedExists = Schedule::where('type', 'blocked')
            ->where('start', '<', $end)
            ->where('end', '>', $start)
            ->exists();

        if ($blockedExists) {
            return response()->json(['success' => false, 'message' => 'Selected time overlaps a blocked date/range'], 422);
        }

        $booking->appointment_date = $start->toDateString();
        $booking->appointment_time = $start->format('h:i A');
        $booking->save();

        $new = [
            'date' => $booking->appointment_date ? Carbon::parse($booking->appointment_date)->format('F j, Y') : null,
            'time' => $booking->appointment_time
        ];

        // Notify customer
        try {
            if ($booking->email && $booking->email !== 'no-email@example.com') {
                Notification::route('mail', $booking->email)
                    ->notify(new BookingRescheduledNotification($booking, ['old' => $old, 'new' => $new]));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send reschedule notification: ' . $e->getMessage(), ['booking_id' => $booking->id]);
        }

        return response()->json(['success' => true, 'booking' => $booking]);
    }

    // Public helper endpoint: return per-day blocked dates for a given month
    public function blockedDates(Request $request)
    {
        $year = $request->query('year') ? intval($request->query('year')) : now()->year;
        $month = $request->query('month') ? intval($request->query('month')) : now()->month;

        // Normalize to first day of month and first day of next month
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = (clone $start)->addMonth()->startOfDay();

        $blocked = Schedule::where('type', 'blocked')
            ->where('start', '<', $end)
            ->where('end', '>', $start)
            ->get();

        $dates = [];

        foreach ($blocked as $slot) {
            try {
                // Parse dates using the application timezone and extract date-only parts
                // Avoid forcing UTC here because that can shift local-midnight values back one day.
                $appTz = config('app.timezone') ?: date_default_timezone_get();
                $sParsed = Carbon::parse($slot->start)->setTimezone($appTz);
                $sDateOnly = $sParsed->format('Y-m-d'); // YYYY-MM-DD in app timezone
                $s = Carbon::createFromFormat('Y-m-d H:i:s', $sDateOnly . ' 00:00:00', $appTz)->startOfDay();

                // End date: use the date part only (exclusive boundary - represents start of day after last blocked day)
                $eParsed = Carbon::parse($slot->end)->setTimezone($appTz);
                $eDateOnly = $eParsed->format('Y-m-d'); // YYYY-MM-DD in app timezone
                $e = Carbon::createFromFormat('Y-m-d H:i:s', $eDateOnly . ' 00:00:00', $appTz)->startOfDay();

                // overlap window clipped to requested month
                $iterStart = $s->copy()->max($start);
                $iterEnd = $e->copy()->min($end);

                // Log for debugging
                Log::debug('Processing blocked slot', [
                    'slot_id' => $slot->id,
                    'slot_start' => $slot->start,
                    'slot_end' => $slot->end,
                    'parsed_start' => $s->toDateString(),
                    'parsed_end' => $e->toDateString(),
                    'requested_month_start' => $start->toDateString(),
                    'requested_month_end' => $end->toDateString(),
                    'iter_start' => $iterStart->toDateString(),
                    'iter_end' => $iterEnd->toDateString(),
                ]);

                // Iterate through dates: from iterStart (inclusive) to iterEnd (exclusive)
                // This ensures we only block the selected date(s), not the day before
                for ($d = $iterStart->copy(); $d->lt($iterEnd->copy()); $d->addDay()) {
                    // Ensure date is formatted consistently as YYYY-MM-DD in UTC
                    $dateStr = $d->format('Y-m-d');
                    $dates[] = [
                        'date' => $dateStr,
                        'title' => $slot->title ?? 'Blocked',
                        'slot_id' => $slot->id,
                    ];
                    Log::debug('Added blocked date', [
                        'date' => $dateStr,
                        'title' => $slot->title ?? 'Blocked',
                        'slot_id' => $slot->id,
                    ]);
                }
            } catch (\Exception $e) {
                // Log error instead of silently ignoring
                Log::warning('Failed to process blocked slot', [
                    'slot_id' => $slot->id ?? 'unknown',
                    'error' => $e->getMessage(),
                ]);
                continue;
            }
        }

        // unique by date (keep first title)
        $unique = [];
        foreach ($dates as $d) {
            if (!isset($unique[$d['date']])) {
                $unique[$d['date']] = $d;
            }
        }

        $out = array_values($unique);
        
        // Log final result for debugging
        Log::debug('Blocked dates API response', [
            'year' => $year,
            'month' => $month,
            'requested_range' => $start->toDateString() . ' to ' . $end->toDateString(),
            'total_blocked_slots' => $blocked->count(),
            'dates_found' => count($out),
            'dates' => array_column($out, 'date'),
        ]);

        return response()->json(['success' => true, 'blocked_dates' => $out]);
    }

    // Public helper endpoint: return upcoming blocked ranges (original slots)
    public function blockedList(Request $request)
    {
        $now = Carbon::now()->startOfDay();

        $blocked = Schedule::where('type', 'blocked')
            ->where('end', '>', $now)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'end', 'meta']);

        $out = $blocked->map(function ($s) {
            try {
                $start = Carbon::parse($s->start)->toDateString();
                // represent end as exclusive date - show last blocked day as one day before end
                $end = Carbon::parse($s->end)->subDay()->toDateString();
            } catch (\Exception $e) {
                $start = $s->start;
                $end = $s->end;
            }

            return [
                'id' => $s->id,
                'title' => $s->title ?? 'Blocked',
                'start' => $start,
                'end' => $end,
                'meta' => $s->meta ?? null,
            ];
        })->values();

        return response()->json(['success' => true, 'blocked' => $out]);
    }
}
