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
            'blocked' => ['bg' => '#ffd6d6', 'border' => '#ff9c9c'],
        ];

        $chosen = $colors[$type] ?? $colors['availability'];

        $event = [
            'id' => 'slot-' . $this->id,
            'title' => $this->title ?? ucfirst($type),
            'start' => $this->start?->toIso8601String(),
            'end' => $this->end?->toIso8601String(),
            'allDay' => $type === 'blocked',
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
            // set a default text color for legibility
            $event['textColor'] = '#000000';
        }

        return $event;
    }
}
