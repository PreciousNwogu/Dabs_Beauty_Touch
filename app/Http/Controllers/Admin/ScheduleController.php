<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
                    // Parse the stored datetime in UTC (as stored)
                    $startParsed = Carbon::parse($slot->start)->utc();
                    $endParsed = Carbon::parse($slot->end)->utc();
                    
                    // Check if this is an all-day block (times are 00:00:00 UTC)
                    $isAllDay = $startParsed->format('H:i:s') === '00:00:00' && 
                                 $endParsed->format('H:i:s') === '00:00:00' &&
                                 $startParsed->format('Y-m-d') !== $endParsed->format('Y-m-d');
                    
                    if ($isAllDay) {
                        // For all-day blocks, get date strings in UTC
                        $startDateStr = $startParsed->format('Y-m-d');
                        $endDateStr = $endParsed->format('Y-m-d');
                        
                        // Create UTC dates from the date strings to ensure no timezone shift
                        $start = Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' 00:00:00', 'UTC')->startOfDay();
                        $end = Carbon::createFromFormat('Y-m-d H:i:s', $endDateStr . ' 00:00:00', 'UTC')->startOfDay();

                        // Iterate day-by-day (end is exclusive, so we loop from start to end-1)
                        // Example: start=2026-01-07, end=2026-01-09 means we want Jan 7 and Jan 8
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
                                    // Preserve original stored range so the admin UI can edit the block
                                    // without relying on the per-day expanded event's start/end.
                                    'orig_start' => $startParsed->toIso8601String(),
                                    'orig_end' => $endParsed->toIso8601String(),
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
                    } else {
                        // For time-specific blocks, only add the original event
                        // FullCalendar will handle displaying it correctly in both month and time grid views
                        $events[] = $slot->toEvent();
                    }
                } catch (\Exception $e) {
                    // fallback to original single event when parsing fails
                    Log::warning('Failed to expand blocked range: ' . $e->getMessage(), [
                        'slot_id' => $slot->id ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
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
                    $startIso = $data['start'];
                    $endIso = $data['end'];
                    
                    // Parse the ISO strings to check if this is an all-day block
                    // All-day blocks have times at 00:00:00 UTC
                    $startParsed = Carbon::parse($startIso)->utc();
                    $endParsed = Carbon::parse($endIso)->utc();
                    
                    $isAllDay = $startParsed->format('H:i:s') === '00:00:00' && 
                                $endParsed->format('H:i:s') === '00:00:00';
                    
                    if ($isAllDay) {
                        // For all-day blocks, extract date parts and normalize to 00:00:00 UTC
                        $startDateStr = $startParsed->format('Y-m-d');
                        $endDateStr = $endParsed->format('Y-m-d');
                        
                        // Create UTC dates directly from the date components (no timezone conversion)
                        $s = Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' 00:00:00', 'UTC')->startOfDay();
                        $e = Carbon::createFromFormat('Y-m-d H:i:s', $endDateStr . ' 00:00:00', 'UTC')->startOfDay();
                        
                        // Update the data array with normalized UTC dates to ensure correct storage
                        $data['start'] = $s->toIso8601String();
                        $data['end'] = $e->toIso8601String();
                    } else {
                        // For time-specific blocks, preserve the exact times
                        $data['start'] = $startParsed->toIso8601String();
                        $data['end'] = $endParsed->toIso8601String();
                        $s = $startParsed;
                        $e = $endParsed;
                    }
                    
                    Log::info('Blocked range processing', [
                        'original_start' => $startIso,
                        'original_end' => $endIso,
                        'is_all_day' => $isAllDay,
                        'stored_start' => $data['start'],
                        'stored_end' => $data['end']
                    ]);

                    // Find any pending/confirmed bookings that fall within [s, e)
                    // For all-day blocks, use date comparison. For time-specific, use full datetime
                    if ($isAllDay) {
                        $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                            ->whereDate('appointment_date', '>=', $s->toDateString())
                            ->whereDate('appointment_date', '<', $e->toDateString())
                            ->get();
                    } else {
                        $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                            ->whereRaw('CONCAT(appointment_date, " ", appointment_time) >= ?', [$s->format('Y-m-d H:i:s')])
                            ->whereRaw('CONCAT(appointment_date, " ", appointment_time) < ?', [$e->format('Y-m-d H:i:s')])
                            ->get();
                    }

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

        // If updating a blocked range, apply the same timezone handling as store
        if (($data['type'] ?? '') === 'blocked' || $slot->type === 'blocked') {
            try {
                $startIso = $data['start'];
                $endIso = $data['end'];
                
                // Parse the ISO strings to check if this is an all-day block
                $startParsed = Carbon::parse($startIso)->utc();
                $endParsed = Carbon::parse($endIso)->utc();
                
                $isAllDay = $startParsed->format('H:i:s') === '00:00:00' && 
                            $endParsed->format('H:i:s') === '00:00:00';
                
                if ($isAllDay) {
                    // For all-day blocks, extract date parts and normalize to 00:00:00 UTC
                    $startDateStr = $startParsed->format('Y-m-d');
                    $endDateStr = $endParsed->format('Y-m-d');
                    
                    $s = Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' 00:00:00', 'UTC')->startOfDay();
                    $e = Carbon::createFromFormat('Y-m-d H:i:s', $endDateStr . ' 00:00:00', 'UTC')->startOfDay();
                    
                    $data['start'] = $s->toIso8601String();
                    $data['end'] = $e->toIso8601String();
                } else {
                    // For time-specific blocks, preserve the exact times (already in UTC from JavaScript)
                    $data['start'] = $startParsed->toIso8601String();
                    $data['end'] = $endParsed->toIso8601String();
                    $s = $startParsed;
                    $e = $endParsed;
                }

                // Find any pending/confirmed bookings that fall within [s, e)
                if ($isAllDay) {
                    $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                        ->whereDate('appointment_date', '>=', $s->toDateString())
                        ->whereDate('appointment_date', '<', $e->toDateString())
                        ->get();
                } else {
                    $conflicts = Booking::whereIn('status', ['pending', 'confirmed'])
                        ->whereRaw('CONCAT(appointment_date, " ", appointment_time) >= ?', [$s->format('Y-m-d H:i:s')])
                        ->whereRaw('CONCAT(appointment_date, " ", appointment_time) < ?', [$e->format('Y-m-d H:i:s')])
                        ->get();
                }

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

        // Prevent rescheduling cancelled/completed bookings
        if (in_array(($booking->status ?? ''), ['cancelled', 'completed'], true)) {
            return response()->json(['success' => false, 'message' => 'This booking cannot be rescheduled (already cancelled/completed).'], 422);
        }

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

        // Also prevent rescheduling into an already-booked slot (pending/confirmed)
        // Normalize time to H:i for comparison.
        $newDate = $start->toDateString();
        $newTime = $start->format('H:i');
        $sameDayBookings = Booking::whereDate('appointment_date', $newDate)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->where('id', '!=', $booking->id)
            ->get(['id', 'name', 'appointment_time']);

        foreach ($sameDayBookings as $b) {
            try {
                $t = $b->appointment_time ? Carbon::parse($b->appointment_time)->format('H:i') : null;
                if ($t && $t === $newTime) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected slot is already booked',
                        'conflict' => ['booking_id' => $b->id, 'name' => $b->name, 'time' => $b->appointment_time],
                    ], 422);
                }
            } catch (\Exception $e) {
                // ignore parse errors and continue
            }
        }

        $booking->appointment_date = $newDate;
        // Store appointment_time as 24h "H:i" (matches slot APIs and avoids SQL concat issues)
        $booking->appointment_time = $newTime;
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
                // Parse dates - use UTC (as stored) for all-day blocks to avoid timezone issues
                $appTz = config('app.timezone') ?: date_default_timezone_get();
                $sParsedUTC = Carbon::parse($slot->start)->utc();
                $eParsedUTC = Carbon::parse($slot->end)->utc();
                
                // Check if this is an all-day block (times are 00:00:00 UTC)
                $isAllDay = $sParsedUTC->format('H:i:s') === '00:00:00' && 
                             $eParsedUTC->format('H:i:s') === '00:00:00';
                
                if ($isAllDay) {
                    // For all-day blocks, extract dates from UTC (as stored)
                    $sDateOnly = $sParsedUTC->format('Y-m-d');
                    $eDateOnly = $eParsedUTC->format('Y-m-d');
                    
                    // Create dates in UTC (as stored) for comparison
                    $s = Carbon::createFromFormat('Y-m-d H:i:s', $sDateOnly . ' 00:00:00', 'UTC')->startOfDay();
                    $e = Carbon::createFromFormat('Y-m-d H:i:s', $eDateOnly . ' 00:00:00', 'UTC')->startOfDay();
                    
                    // Convert requested month range to UTC for comparison
                    $startUTC = $start->copy()->setTimezone('UTC');
                    $endUTC = $end->copy()->setTimezone('UTC');

                    // Overlap window clipped to requested month (in UTC)
                    $iterStart = $s->copy()->max($startUTC);
                    $iterEnd = $e->copy()->min($endUTC);

                    // Iterate through dates: from iterStart (inclusive) to iterEnd (exclusive)
                    // But we need to output dates in app timezone format for the frontend
                    for ($d = $iterStart->copy(); $d->lt($iterEnd); $d->addDay()) {
                        // Convert the UTC date to app timezone for the date string
                        $dAppTz = $d->copy()->setTimezone($appTz);
                        $dateStr = $dAppTz->format('Y-m-d');

                        $dates[] = [
                            'date' => $dateStr,
                            'title' => $slot->title ?? 'Blocked',
                            'slot_id' => $slot->id,
                            'start_time' => '00:00',
                            'end_time' => '23:59',
                            'full_day' => true,
                        ];
                    }
                } else {
                    // For time-specific blocks, include all dates that the block covers
                    $sParsed = $sParsedUTC->copy()->setTimezone($appTz);
                    $eParsed = $eParsedUTC->copy()->setTimezone($appTz);
                    
                    $sDateOnly = $sParsed->format('Y-m-d');
                    $eDateOnly = $eParsed->format('Y-m-d');
                    
                    // Determine the date range this block covers
                    $blockStartDate = Carbon::createFromFormat('Y-m-d H:i:s', $sDateOnly . ' 00:00:00', $appTz)->startOfDay();
                    // For end date, if the block ends at a specific time, we still want to include that date
                    $blockEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $eDateOnly . ' 00:00:00', $appTz)->startOfDay();
                    
                    // Overlap window clipped to requested month
                    $iterStart = $blockStartDate->copy()->max($start);
                    $iterEnd = $blockEndDate->copy()->addDay()->min($end); // Add day because end date should be inclusive

                    // Iterate through dates covered by this block
                    for ($d = $iterStart->copy(); $d->lt($iterEnd); $d->addDay()) {
                        $dateStr = $d->format('Y-m-d');

                        // Determine the blocked window that applies to this particular day
                        $dayStart = $d->copy()->startOfDay();
                        $dayEnd = $d->copy()->endOfDay();

                        // Block window is the intersection of the slot range and this day
                        $blockStart = $sParsed->copy();
                        if ($blockStart->lt($dayStart)) $blockStart = $dayStart->copy();

                        $blockEnd = $eParsed->copy();
                        if ($blockEnd->gt($dayEnd)) $blockEnd = $dayEnd->copy();

                        // Format times as HH:MM
                        $startTime = $blockStart->format('H:i');
                        $endTime = $blockEnd->format('H:i');

                        // Check if this is effectively a full day for this specific date
                        $fullDay = ($blockStart->format('H:i') === '00:00' && 
                                   ($blockEnd->format('H:i') === '23:59' || 
                                    $blockEnd->format('H:i') === '00:00' ||
                                    $blockEnd->format('H:i:s') === '23:59:59'));

                        $dates[] = [
                            'date' => $dateStr,
                            'title' => $slot->title ?? 'Blocked',
                            'slot_id' => $slot->id,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'full_day' => $fullDay,
                        ];
                    }
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
