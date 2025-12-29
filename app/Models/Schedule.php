<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'title',
        'staff_id',
        'start',
        'end',
        'type',
        'meta',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'meta' => 'array',
    ];

    // Helper to produce a FullCalendar friendly array
    public function toEvent(): array
    {
        $type = $this->type ?? 'availability';
        $colors = [
            'availability' => ['bg' => '#cfe9ff', 'border' => '#9ec8ff'],
            'blocked' => ['bg' => '#dc3545', 'border' => '#a71e2a'],
        ];

        $chosen = $colors[$type] ?? $colors['availability'];

        // Determine if this is an all-day event
        // For blocked types, check if start and end are at 00:00:00 UTC
        $isAllDay = false;
        if ($type === 'blocked' && $this->start && $this->end) {
            $startUTC = \Carbon\Carbon::parse($this->start)->utc();
            $endUTC = \Carbon\Carbon::parse($this->end)->utc();
            // All-day blocks have times at 00:00:00 UTC
            // For single-day: end is next day at 00:00:00 (dates differ)
            // For multi-day: both dates are at 00:00:00 (dates differ)
            // For time-specific: times are NOT 00:00:00
            $isAllDay = $startUTC->format('H:i:s') === '00:00:00' && 
                        $endUTC->format('H:i:s') === '00:00:00';
        } else {
            // For availability or other types, default behavior
            $isAllDay = $type === 'blocked';
        }

        $event = [
            'id' => 'slot-' . $this->id,
            'title' => $this->title ?? ucfirst($type),
            'start' => $this->start?->toIso8601String(),
            'end' => $this->end?->toIso8601String(),
            'allDay' => $isAllDay,
            'extendedProps' => [
                'type' => $type,
                'staff_id' => $this->staff_id,
                'meta' => $this->meta,
            ],
            'editable' => false,
            // By default availability remains a background stripe; blocked ranges
            // should show their title text so admins can read the reason.
            'display' => $type === 'blocked' ? 'auto' : 'background',
            'backgroundColor' => $chosen['bg'],
            'borderColor' => $chosen['border']
        ];

        // Add a class name for blocked ranges to allow specific styling in the UI
        if ($type === 'blocked') {
            $event['classNames'] = ['blocked-range'];
            // ensure blocked slots are not draggable and do not overlap other events
            $event['overlap'] = false;
            $event['display'] = 'auto';
            // set a default text color for legibility (white for dark red background)
            $event['textColor'] = '#ffffff';
        }

        return $event;
    }
}
