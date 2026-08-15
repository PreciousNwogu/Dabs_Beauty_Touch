<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\SlotUnavailableException;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomServiceRequest;
use App\Notifications\BookingConfirmation;
use App\Services\BookingSlotGuard;
use App\Support\ServiceDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class ConvertCustomRequestController extends Controller
{
    public function store(Request $request, int $id, BookingSlotGuard $guard)
    {
        $customRequest = CustomServiceRequest::findOrFail($id);

        if (Schema::hasColumn('custom_service_requests', 'converted_booking_id') && $customRequest->converted_booking_id) {
            return redirect()->route('admin.bookings.show', ['id' => $customRequest->converted_booking_id])
                ->with('success', 'This request was already converted to a booking.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:40',
            'service' => 'required|string|max:255',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string|max:20',
            'appointment_type' => 'required|in:in-studio,mobile',
            'address' => 'nullable|string|max:500|required_if:appointment_type,mobile',
            'final_price' => 'nullable|numeric|min:0|max:9999.99',
            'message' => 'nullable|string|max:2000',
        ]);

        if ($data['appointment_type'] === 'mobile' && mb_strlen(trim((string) ($data['address'] ?? ''))) < 10) {
            return back()->withErrors(['address' => 'Enter a complete mobile service address.'])->withInput();
        }

        try {
            $data['appointment_time'] = \Carbon\Carbon::parse($data['appointment_time'])->format('H:i');
        } catch (\Throwable $e) {
            return back()->withErrors(['appointment_time' => 'Enter a valid appointment time.'])->withInput();
        }

        $hours = ServiceDuration::hoursForName($data['service']);
        $notes = trim(
            'Converted from custom request #'.$customRequest->id."\n".
            ($data['message'] ?? $customRequest->message ?? '')
        );

        $bookingPayload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?: $customRequest->phone,
            'service' => $data['service'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_type' => $data['appointment_type'],
            'address' => $data['appointment_type'] === 'mobile' ? trim((string) $data['address']) : null,
            'message' => $data['message'] ?? $customRequest->message,
            'notes' => $notes !== '' ? $notes : null,
            'final_price' => $data['final_price'] ?? null,
            'status' => 'pending',
            'payment_status' => 'pending',
            'service_duration_minutes' => ServiceDuration::toMinutes($hours),
        ];

        try {
            $booking = $guard->reserve(
                (string) $bookingPayload['appointment_date'],
                (string) $bookingPayload['appointment_time'],
                fn () => Booking::create($bookingPayload),
                null,
                $hours
            );
        } catch (SlotUnavailableException $e) {
            return back()
                ->withErrors(['appointment_time' => $e->getMessage()])
                ->withInput()
                ->with('error', $e->getMessage());
        }

        $booking->confirmation_code = 'CONF'.strtoupper(substr(md5($booking->id.time()), 0, 8));
        $booking->save();

        if (Schema::hasColumn('custom_service_requests', 'converted_booking_id')) {
            $customRequest->converted_booking_id = $booking->id;
        }
        $customRequest->status = 'handled';
        $customRequest->save();

        try {
            if ($booking->email && $booking->email !== 'no-email@example.com') {
                Notification::route('mail', $booking->email)
                    ->notify(new BookingConfirmation($booking));
            }
        } catch (\Throwable $e) {
            Log::warning('Convert custom request confirmation email failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.bookings.show', ['id' => $booking->id])
            ->with('success', 'Custom request converted to booking #'.sprintf('BK%06d', $booking->id).'.');
    }
}
