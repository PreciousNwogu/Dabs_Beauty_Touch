<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class BookingAvailabilityController extends Controller
{
    public function unavailable(Request $request)
    {
        // Get all bookings (adjust table/fields as needed)
        $bookings = DB::table('bookings')->select('date', 'time')->get();

        // Group times by date
        $times = [];
        foreach ($bookings as $booking) {
            $date = $booking->date;
            $time = $booking->time;
            if (!isset($times[$date])) {
                $times[$date] = [];
            }
            $times[$date][] = $time;
        }

        // Optionally, mark fully booked dates (if all time slots are taken)
        $allTimes = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
        $dates = [];
        foreach ($times as $date => $bookedTimes) {
            if (count($bookedTimes) >= count($allTimes)) {
                $dates[] = $date;
            }
        }

        return Response::json([
            'dates' => $dates,
            'times' => $times
        ]);
    }
}
