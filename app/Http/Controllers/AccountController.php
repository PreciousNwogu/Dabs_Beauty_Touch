<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function showBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();
        abort_unless($booking->user_id && $booking->user_id === $user->id, 403);

        $serviceName = (string) ($booking->service ?? '');

        // Best-effort mapping to the service_type used by the booking modal JS
        $serviceTypeMap = [
            'Small Knotless Braids' => 'small-knotless',
            'Smedium Knotless Braids' => 'smedium-knotless',
            'Medium Knotless Braids' => 'medium-knotless',
            'Jumbo Knotless Braids' => 'jumbo-knotless',
            'Wig Installation' => 'wig-installation',
            'Hair Mask/Relaxing' => 'hair-mask',
            '8–10 Rows Stitch Braids' => 'stitch-braids',
            '8-10 Rows Stitch Braids' => 'stitch-braids',
            'Smedium Boho Braids' => 'boho-braids',
            'Kids Braids' => 'kids-braids',
        ];

        $serviceType = $serviceTypeMap[$serviceName] ?? null;

        if (!$serviceType) {
            $serviceRow = Service::query()
                ->whereRaw('LOWER(name) = ?', [strtolower($serviceName)])
                ->first();
            $serviceType = $serviceRow?->slug ?: Str::slug($serviceName);
        }

        return view('account.booking-details', [
            'booking' => $booking,
            'serviceName' => $serviceName,
            'serviceType' => $serviceType,
        ]);
    }
}

