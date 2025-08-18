<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'service',
        'length',
        'appointment_date',
        'appointment_time',
        'message',
        'status',
        'notes',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'completed_by',
        'completion_notes',
        'service_duration_minutes',
        'final_price',
        'payment_status',
        'status_history',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_date' => 'date',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'final_price' => 'decimal:2',
        'status_history' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the status badge color.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Scope for pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for today's bookings.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    /**
     * Scope for upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', today());
    }

    /**
     * Scope for completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Update booking status with timestamp tracking
     */
    public function updateStatus($newStatus, $completedBy = null, $completionNotes = null, $finalPrice = null, $serviceDuration = null)
    {
        $oldStatus = $this->status;
        $now = now();

        // Update the main status
        $this->status = $newStatus;

        // Update timestamp fields based on status
        switch ($newStatus) {
            case 'confirmed':
                $this->confirmed_at = $now;
                break;
            case 'completed':
                $this->completed_at = $now;
                $this->completed_by = $completedBy;
                $this->completion_notes = $completionNotes;
                $this->final_price = $finalPrice;
                $this->service_duration_minutes = $serviceDuration;
                break;
            case 'cancelled':
                $this->cancelled_at = $now;
                break;
        }

        // Track status history
        $statusHistory = $this->status_history ?: [];
        $statusHistory[] = [
            'from' => $oldStatus,
            'to' => $newStatus,
            'timestamp' => $now->toDateTimeString(),
            'updated_by' => $completedBy ?: 'system',
            'notes' => $completionNotes
        ];
        $this->status_history = $statusHistory;

        $this->save();

        // Send notification when service is completed
        if ($newStatus === 'completed' && $this->email) {
            try {
                \Illuminate\Support\Facades\Notification::route('mail', $this->email)
                    ->notify(new \App\Notifications\ServiceCompletedNotification($this));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to send completion notification', [
                    'booking_id' => $this->id,
                    'email' => $this->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $this;
    }

    /**
     * Get formatted status history
     */
    public function getFormattedStatusHistory()
    {
        $history = $this->status_history ?: [];
        return collect($history)->map(function ($entry) {
            return [
                'from' => ucfirst($entry['from']),
                'to' => ucfirst($entry['to']),
                'timestamp' => \Carbon\Carbon::parse($entry['timestamp'])->format('M j, Y g:i A'),
                'updated_by' => $entry['updated_by'],
                'notes' => $entry['notes']
            ];
        });
    }

    /**
     * Check if booking can be marked as completed
     */
    public function canBeCompleted()
    {
        return in_array($this->status, ['confirmed', 'pending']) && 
               $this->appointment_date <= today();
    }

    /**
     * Get service duration in formatted string
     */
    public function getFormattedDuration()
    {
        if (!$this->service_duration_minutes) {
            return null;
        }

        $hours = floor($this->service_duration_minutes / 60);
        $minutes = $this->service_duration_minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
        }
        
        return $minutes . 'm';
    }
}
