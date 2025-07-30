<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'email',
        'phone',
        'service',
        'appointment_date',
        'appointment_time',
        'duration',
        'status',
        'notes',
        'confirmation_code'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    /**
     * Boot the model and generate unique IDs
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->booking_id)) {
                $appointment->booking_id = 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
            if (empty($appointment->confirmation_code)) {
                $appointment->confirmation_code = strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Get available time slots for a specific date
     */
    public static function getAvailableSlots($date, $service = null)
    {
        $workingHours = [
            'start' => '09:00',
            'end' => '18:00',
            'break_start' => '12:00',
            'break_end' => '13:00'
        ];

        $slotDuration = 60; // 60 minutes per slot
        $slots = [];

        $start = strtotime($workingHours['start']);
        $end = strtotime($workingHours['end']);
        $breakStart = strtotime($workingHours['break_start']);
        $breakEnd = strtotime($workingHours['break_end']);

        for ($time = $start; $time < $end; $time += ($slotDuration * 60)) {
            $slotTime = date('H:i', $time);
            
            // Skip break time
            if ($time >= $breakStart && $time < $breakEnd) {
                continue;
            }

            // Check if slot is available
            $isBooked = self::where('appointment_date', $date)
                ->where('appointment_time', $slotTime)
                ->where('status', '!=', 'cancelled')
                ->exists();

            if (!$isBooked) {
                $slots[] = [
                    'time' => $slotTime,
                    'available' => true,
                    'formatted_time' => date('g:i A', $time)
                ];
            } else {
                $slots[] = [
                    'time' => $slotTime,
                    'available' => false,
                    'formatted_time' => date('g:i A', $time)
                ];
            }
        }

        return $slots;
    }

    /**
     * Check if a specific time slot is available
     */
    public static function isSlotAvailable($date, $time)
    {
        return !self::where('appointment_date', $date)
            ->where('appointment_time', $time)
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    /**
     * Get appointments for a date range
     */
    public static function getAppointmentsForDateRange($startDate, $endDate)
    {
        return self::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
    }

    /**
     * Get today's appointments
     */
    public static function getTodaysAppointments()
    {
        return self::where('appointment_date', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_time')
            ->get();
    }

    /**
     * Get upcoming appointments
     */
    public static function getUpcomingAppointments($limit = 10)
    {
        return self::where('appointment_date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit($limit)
            ->get();
    }
} 