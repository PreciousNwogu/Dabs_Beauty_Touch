<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'appointment_type',
        'parking_type',
        'service',
        'length',
        'appointment_date',
        'appointment_time',
        'message',
        'status',
        'notes',
        'reschedule_requested_date',
        'reschedule_requested_time',
        'reschedule_request_note',
        'reschedule_request_status',
        'reschedule_requested_at',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
        'completed_by',
        'completion_notes',
        'service_duration_minutes',
        'final_price',
        // Kids selector fields
        'kb_braid_type',
        'kb_finish',
        'kb_length',
        'kb_extras',
        'kb_extras_total',
        'kb_base_price',
        'kb_length_adjustment',
        'kb_final_price',
        'base_price',
        'length_adjustment',
        'hair_mask_option',
        'stitch_rows_option',
    'confirmation_code',
    'sample_picture',
        'reminder_24_sent',
        'reminder_1_sent',
        'deposit_reminder_sent_at',
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
        'reschedule_requested_date' => 'date',
        'reschedule_requested_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'final_price' => 'decimal:2',
        'kb_base_price' => 'decimal:2',
        'kb_length_adjustment' => 'decimal:2',
        'kb_final_price' => 'decimal:2',
        'kb_extras_total' => 'decimal:2',
        'base_price' => 'decimal:2',
        'length_adjustment' => 'decimal:2',
    'hair_mask_option' => 'string',
    'stitch_rows_option' => 'string',
    'confirmation_code' => 'string',
    'sample_picture' => 'string',
        'reminder_24_sent' => 'boolean',
        'reminder_1_sent' => 'boolean',
        'deposit_reminder_sent_at' => 'datetime',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasUsableEmail(): bool
    {
        $email = strtolower(trim((string) $this->email));

        return $email !== '' && $email !== 'no-email@example.com';
    }

    public static function emailNeedsAccount(?string $email, mixed $userId = null): bool
    {
        if (! empty($userId)) {
            return false;
        }

        $email = strtolower(trim((string) $email));
        if ($email === '' || $email === 'no-email@example.com') {
            return false;
        }

        try {
            return ! User::query()->whereRaw('LOWER(email) = ?', [$email])->exists();
        } catch (\Throwable $e) {
            return true;
        }
    }

    public function needsAccountSignup(): bool
    {
        return self::emailNeedsAccount($this->email, $this->user_id);
    }

    public static function signupUrlFor(?string $email, ?string $name = null): string
    {
        return route('register', array_filter([
            'email' => $email ?: null,
            'name' => $name ?: null,
        ]));
    }

    public function accountSignupUrl(): string
    {
        return self::signupUrlFor($this->hasUsableEmail() ? $this->email : null, $this->name);
    }

    public function depositIsPending(): bool
    {
        return ($this->payment_status ?? 'pending') === 'pending';
    }

    public function appointmentStartsAt(): ?\Carbon\Carbon
    {
        if (! $this->appointment_date || ! $this->appointment_time) {
            return null;
        }

        try {
            $tz = config('app.timezone') ?: 'America/Toronto';
            $date = $this->appointment_date instanceof \Carbon\Carbon
                ? $this->appointment_date->format('Y-m-d')
                : \Carbon\Carbon::parse($this->appointment_date)->format('Y-m-d');
            $time = \Carbon\Carbon::parse($this->appointment_time)->format('H:i');

            return \Carbon\Carbon::createFromFormat('Y-m-d H:i', $date.' '.$time, $tz);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function hoursUntilAppointment(): ?float
    {
        $start = $this->appointmentStartsAt();
        if (! $start) {
            return null;
        }

        return now($start->getTimezone())->floatDiffInHours($start, false);
    }

    public function canClientCancel(): bool
    {
        if (! in_array($this->status, ['pending', 'confirmed'], true)) {
            return false;
        }

        if ($this->status === 'pending' && $this->depositIsPending()) {
            return true;
        }

        $hours = $this->hoursUntilAppointment();

        return $hours !== null && $hours >= 48;
    }

    public function canClientRequestReschedule(): bool
    {
        if (! in_array($this->status, ['pending', 'confirmed'], true)) {
            return false;
        }

        $hours = $this->hoursUntilAppointment();

        return $hours !== null && $hours >= 48;
    }

    public function hasPendingRescheduleRequest(): bool
    {
        if (! \Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'reschedule_request_status')) {
            return false;
        }

        return ($this->reschedule_request_status ?? '') === 'pending'
            && filled($this->reschedule_requested_date)
            && filled($this->reschedule_requested_time);
    }

    public function requestedRescheduleLabel(): string
    {
        if (! filled($this->reschedule_requested_date) || ! filled($this->reschedule_requested_time)) {
            return '';
        }

        try {
            $date = $this->reschedule_requested_date instanceof \Carbon\Carbon
                ? $this->reschedule_requested_date->format('F j, Y')
                : \Carbon\Carbon::parse($this->reschedule_requested_date)->format('F j, Y');
            $time = \Carbon\Carbon::parse($this->reschedule_requested_time)->format('g:i A');

            return $date.' at '.$time;
        } catch (\Throwable $e) {
            return trim((string) $this->reschedule_requested_date.' '.(string) $this->reschedule_requested_time);
        }
    }

    public function currentAppointmentLabel(): string
    {
        $date = $this->appointment_date
            ? ($this->appointment_date instanceof \Carbon\Carbon
                ? $this->appointment_date->format('F j, Y')
                : \Carbon\Carbon::parse($this->appointment_date)->format('F j, Y'))
            : '';
        $time = '';
        try {
            $time = $this->appointment_time ? \Carbon\Carbon::parse($this->appointment_time)->format('g:i A') : '';
        } catch (\Throwable $e) {
            $time = (string) $this->appointment_time;
        }

        return trim($date.($time !== '' ? ' at '.$time : ''));
    }

    public function settleRescheduleRequest(string $status): void
    {
        if (! in_array($status, ['approved', 'declined'], true)) {
            return;
        }
        if (! \Illuminate\Support\Facades\Schema::hasColumn($this->getTable(), 'reschedule_request_status')) {
            return;
        }
        if (($this->reschedule_request_status ?? '') !== 'pending') {
            return;
        }

        $this->reschedule_request_status = $status;
        $this->save();
    }

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
        $tz = 'America/Toronto';
        return collect($history)->map(function ($entry) use ($tz) {
            try {
                $ts = \Carbon\Carbon::parse($entry['timestamp'])->setTimezone($tz)->format('M j, Y g:i A');
            } catch (\Exception $e) {
                $ts = $entry['timestamp'];
            }

            return [
                'from' => ucfirst($entry['from']),
                'to' => ucfirst($entry['to']),
                'timestamp' => $ts,
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

        return $hours . 'hrs:' . $minutes . 'mins';
    }

    /**
     * Compute pricing breakdown for this booking.
     * Returns an array with resolved_base, length_adjust, addons_total,
     * adjustments_total, computed_total, final_price, selector, selector_friendly,
     * hide_length_finish, selector_base, selector_adjust, selector_addons
     */
    public function getPricingBreakdown(): array
    {
        $b = $this;

        // default values
        $resolvedBase = null;
        $lengthAdjust = 0.0;
        $addonsTotal = 0.0;
        $computed_total_final = null;
        $selector = null;
        $selector_friendly = null;
        $hideLengthFinish = false;
        $selector_base = null;
        $selector_adjust = null;
        $selector_addons = null;

        // try to extract selector from notes
        if (!empty($b->notes) && preg_match('/Selector:\s*(\{.*\})/s', $b->notes, $m)) {
            try {
                $selector = json_decode($m[1], true);
            } catch (\Exception $e) {
                $selector = null;
            }
        }

        // persisted base/adjust
        $basePrice = $b->base_price ?? null;
        $adjust = $b->length_adjustment ?? null;

        // service fallback for base price
        if (is_null($basePrice)) {
            try {
                $serviceModel = \App\Models\Service::where('slug', $b->service)
                    ->orWhere('name', $b->service)->first();
                if ($serviceModel) {
                    $basePrice = (float) $serviceModel->base_price;
                }
            } catch (\Exception $e) {
                $serviceModel = null;
            }
        }

        // compute length adjust if missing
        if (is_null($adjust) && $b->length) {
            // Length adjustment pricing with grouped lengths:
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
            
            $adjust = $lengthAdjustmentMap[$b->length] ?? 0.00;
        }

        // If we resolved an adjustment value from persisted fields or computation,
        // reflect it into the $lengthAdjust variable used for the returned breakdown.
        if (!is_null($adjust)) {
            $lengthAdjust = (float) $adjust;
        }

        // Compute kids/selector-based adjustments if applicable
        try {
            $computedTotal = null;
            $serviceType = strtolower((string) ($b->service_type ?? $b->service ?? ''));
            if ($serviceType === 'kids-braids' || stripos($b->service ?? '', 'kids') !== false || $selector) {
                $baseConfigured = (float) (config('service_prices.kids_braids', 80));
                $typeAdj = ['protective'=>-20,'cornrows'=>-30,'knotless_small'=>20,'knotless_med'=>0,'box_small'=>10,'box_med'=>0,'stitch'=>20];
                $lengthAdj = ['shoulder'=>0,'armpit'=>10,'mid_back'=>20,'waist'=>30];
                $finishAdj = ['curled'=>-10,'plain'=>0];

                $sel = $selector ?: [];
                $adjustments = 0; $addons = 0;
                $bt = $sel['braid_type'] ?? $b->kb_braid_type ?? null;
                $ln = $sel['length'] ?? $b->length ?? null;
                $fi = $sel['finish'] ?? $b->kb_finish ?? null;
                $ex = $sel['extras'] ?? $b->kb_extras ?? null;

                $catalogPrice = \App\Support\KidsStyleCatalog::startingPrice($bt);
                if ($catalogPrice !== null) {
                    $baseConfigured = $catalogPrice;
                } elseif ($bt && isset($typeAdj[$bt])) {
                    $adjustments += $typeAdj[$bt];
                }
                if ($ln && isset($lengthAdj[$ln])) $adjustments += $lengthAdj[$ln];
                if ($fi && isset($finishAdj[$fi])) $adjustments += $finishAdj[$fi];

                if ($ex) {
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    if (is_string($ex) && strpos($ex,'kb_add_')!==false) {
                        foreach (explode(',', $ex) as $it) { $it = trim($it); if (isset($addonMap[$it])) $addons += $addonMap[$it]; }
                    } else if (is_string($ex) && preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)) {
                        foreach (explode(',', $ex) as $n) { $addons += floatval($n); }
                    }
                }

                $computedTotal = round(($baseConfigured ?? 0) + $adjustments + $addons, 2);
                $selector_base = $baseConfigured ?? null;
                $selector_adjust = $adjustments;
                $selector_addons = $addons;
                $addonsTotal = $addons;
                $lengthAdjust = $adjustments;
            }
        } catch (\Exception $e) { /* noop */ }

        // friendly selector labels
        try {
            $friendlyBraid = ['protective' => 'Protective style','cornrows' => 'Cornrows','knotless_small' => 'Knotless (small)','knotless_med' => 'Knotless (medium)','box_small' => 'Box (small)','box_med' => 'Box (medium)','stitch' => 'Stitch','half_weave_braid' => '1/2 Weave & 1/2 Braid','half_weave_crotchet' => '1/2 Weave & 1/2 Crotchet','crotchet_style' => 'Crotchet Style'];
            $friendlyFinish = ['none' => '—','sleek' => 'Sleek finish','natural' => 'Natural finish','curled' => 'With curl','plain' => 'Without curl'];
            $friendlyLength = [
                'short' => 'Short',
                'neck' => 'Neck',
                'shoulder' => 'Shoulder',
                'armpit' => 'Armpit',
                'bra_strap' => 'Bra strap',
                'mid_back' => 'Mid Back',
                'waist' => 'Waist',
                'hip' => 'Hip',
                'tailbone' => 'Tailbone',
                'classic' => 'Classic',
                'long' => 'Long'
            ];
            $addonMap = ['kb_add_detangle' => 'Detangle', 'kb_add_beads' => 'Beads', 'kb_add_beads_full' => 'Beads (full)', 'kb_add_extension' => 'Extension', 'kb_add_rest' => '15-min break'];

            $sel = $selector ?: [];
            $bt = $sel['braid_type'] ?? $b->kb_braid_type ?? null;
            $fi = $sel['finish'] ?? $b->kb_finish ?? null;
            $ln = $sel['length'] ?? $b->kb_length ?? $b->length ?? null;
            $ex = $sel['extras'] ?? $b->kb_extras ?? null;

            $extrasList = [];
            if ($ex) {
                if (is_array($ex)) {
                    foreach ($ex as $it) { $it = trim($it); if ($it==='') continue; $extrasList[] = $addonMap[$it] ?? ucwords(str_replace(['_','-'], ' ', $it)); }
                } else {
                    foreach (explode(',', (string)$ex) as $it) { $it = trim($it); if ($it==='') continue; $extrasList[] = $addonMap[$it] ?? ucwords(str_replace(['_','-'], ' ', $it)); }
                }
            }

            $selector_friendly = ['braid_type' => $bt ? ($friendlyBraid[$bt] ?? \App\Support\KidsStyleCatalog::displayName($bt)) : null, 'finish' => $fi ? ($friendlyFinish[$fi] ?? ucwords(str_replace(['_','-'], ' ', $fi))) : null, 'length' => $ln ? ($friendlyLength[$ln] ?? ucwords(str_replace(['_','-'], ' ', $ln))) : null, 'extras' => $extrasList];
        } catch (\Exception $e) { $selector_friendly = null; }

        // Prefer persisted kb_addons_total if available (most authoritative)
        if (!empty($b->kb_addons_total) && is_numeric($b->kb_addons_total)) {
            $addonsTotal = (float) $b->kb_addons_total;
        } elseif ($addonsTotal === 0 && !empty($selector['extras'])) {
            // fallback for addons parsing when not computed above
            $ex = $selector['extras'];
            if (is_array($ex)) {
                $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                foreach ($ex as $it) { if (isset($addonMap[$it])) $addonsTotal += $addonMap[$it]; }
            } elseif (is_string($ex)) {
                if (preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)) {
                    foreach (explode(',', $ex) as $n) { $addonsTotal += floatval($n); }
                } else {
                    $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
                    foreach (explode(',', $ex) as $it) { $it = trim($it); if (isset($addonMap[$it])) $addonsTotal += $addonMap[$it]; }
                }
            }
        }

        // resolve base
        if (!is_null($basePrice) && is_numeric($basePrice)) {
            $resolvedBase = (float) $basePrice;
        } elseif (isset($selector_base) && is_numeric($selector_base)) {
            $resolvedBase = (float) $selector_base;
        } else {
            $resolvedBase = 0.0;
        }

        // Determine authoritative final_price for display in emails/pages.
        // IMPORTANT: Prefer persisted values (what the customer actually booked at that time).
        // Only compute if missing.
        if (!empty($b->kb_final_price) && is_numeric($b->kb_final_price)) {
            $final_price_to_pass = (float) $b->kb_final_price;
        } elseif (!empty($b->final_price) && is_numeric($b->final_price)) {
            $final_price_to_pass = (float) $b->final_price;
        } elseif (!is_null($computed_total_final)) {
            $final_price_to_pass = (float) $computed_total_final;
        } else {
            $final_price_to_pass = round($resolvedBase + $lengthAdjust + $addonsTotal, 2);
        }

        // For kids bookings, adjustments_total should include type + length + finish adjustments
        // This matches what the UI shows as "Adjustments"
        if (isset($selector_adjust) && is_numeric($selector_adjust)) {
            // Use selector_adjust which includes type + length + finish
            $adjustmentsTotal = round((float)$selector_adjust, 2);
        } else {
            // Fallback to lengthAdjust (which may only include length for non-kids bookings)
            $adjustmentsTotal = round($lengthAdjust, 2);
        }
        
        $addonsTotal = round($addonsTotal, 2);
        $computed_total_final = $computed_total_final ?? $final_price_to_pass;

        // hide length/finish for some braid types and services that don't require length adjustments
        $serviceName = strtolower((string)($b->service ?? ''));
        $rawBraid = strtolower((string)($selector['braid_type'] ?? $b->kb_braid_type ?? $b->service ?? ''));
        
        // Services that don't show length in notifications
        $noLengthServices = [
            'weaving crotchet',
            'single crotchet',
            'natural hair twist',
            'weaving no-extension',
            'weaving-no-extension',
            'weaving_crotchet',
            'single_crotchet',
            'natural_hair_twist',
            'hair mask',
            'hair-mask',
            'hair_mask',
            'mask/relax',
            'mask/relaxing',
            'relaxing',
            'retouching',
            'retouch'
        ];
        
        // Check if this is a hair mask/relaxing/retouching service
        $isHairMaskService = (
            stripos($serviceName, 'hair mask') !== false ||
            stripos($serviceName, 'hair-mask') !== false ||
            stripos($serviceName, 'mask/relax') !== false ||
            stripos($serviceName, 'relaxing') !== false ||
            stripos($serviceName, 'retouching') !== false ||
            stripos($serviceName, 'retouch') !== false ||
            !empty($b->hair_mask_option)
        );
        
        $hideLengthFinish = (
            stripos($rawBraid, 'protect') !== false ||
            stripos($rawBraid, 'cornrow') !== false ||
            preg_match('/protective|cornrows|cornrow|half[_ -]?weave|crotchet[_ -]?style/i', $rawBraid) ||
            in_array($serviceName, $noLengthServices, true) ||
            in_array(str_replace([' ', '-'], ['_', '_'], $serviceName), $noLengthServices, true) ||
            $isHairMaskService
        );

        return [
            'resolved_base' => $resolvedBase,
            'length_adjust' => $lengthAdjust,
            'addons_total' => $addonsTotal,
            'adjustments_total' => $adjustmentsTotal,
            'computed_total' => $computed_total_final,
            'final_price' => $final_price_to_pass,
            'selector' => $selector,
            'selector_friendly' => $selector_friendly,
            'hide_length_finish' => $hideLengthFinish,
            'selector_base' => $selector_base,
            'selector_adjust' => $selector_adjust,
            'selector_addons' => $selector_addons,
        ];
    }
}
