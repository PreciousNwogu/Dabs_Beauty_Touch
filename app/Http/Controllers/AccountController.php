<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function myBookings(Request $request)
    {
        $user = Auth::user();

        // Auto-claim prior guest bookings by email (one-way link)
        if ($user && $user->email) {
            Booking::whereNull('user_id')
                ->where('email', $user->email)
                ->update(['user_id' => $user->id]);
        }

        $bookings = Booking::query()
            ->where('user_id', $user->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return view('account.bookings', [
            'bookings' => $bookings,
        ]);
    }
}

