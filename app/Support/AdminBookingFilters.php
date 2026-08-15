<?php

namespace App\Support;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AdminBookingFilters
{
    public static function apply(Builder $query, Request $request): Builder
    {
        $status = trim((string) $request->input('status', ''));
        if ($status === 'deposit_pending') {
            $query->where('status', 'pending')
                ->where(function ($q) {
                    $q->whereNull('payment_status')->orWhere('payment_status', 'pending');
                });
        } elseif ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->input('date'));
        } else {
            if ($request->filled('from')) {
                $query->whereDate('appointment_date', '>=', $request->input('from'));
            }
            if ($request->filled('to')) {
                $query->whereDate('appointment_date', '<=', $request->input('to'));
            }
        }

        if ($request->filled('service')) {
            $query->where('service', 'LIKE', '%'.$request->input('service').'%');
        }

        return $query;
    }

    public static function amount(Booking $booking): float
    {
        if ($booking->final_price !== null && $booking->final_price !== '') {
            return round((float) $booking->final_price, 2);
        }

        if ($booking->kb_final_price !== null && $booking->kb_final_price !== '') {
            return round((float) $booking->kb_final_price, 2);
        }

        return round((float) $booking->base_price + (float) $booking->length_adjustment, 2);
    }
}
