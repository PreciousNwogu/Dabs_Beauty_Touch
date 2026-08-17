<?php

namespace Tests\Feature;

use App\Mail\BookingRescheduleDeclinedMail;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingRescheduledNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RescheduleRequestAdminTest extends TestCase
{
    use RefreshDatabase;

    private function futureBooking(array $overrides = []): Booking
    {
        return Booking::factory()->confirmed()->create(array_merge([
            'confirmation_code' => 'CONFRESCH1',
            'email' => 'client@example.com',
            'appointment_date' => now()->addDays(12)->toDateString(),
            'appointment_time' => '10:00',
            'service' => 'Knotless Braids',
            'payment_status' => 'deposit_paid',
        ], $overrides));
    }

    public function test_client_reschedule_request_is_saved_as_pending(): void
    {
        Notification::fake();

        $booking = $this->futureBooking();
        $newDate = now()->addDays(20)->toDateString();

        $this->post('/bookings/confirm/'.$booking->id.'/CONFRESCH1/reschedule', [
            'preferred_date' => $newDate,
            'preferred_time' => '14:30',
            'note' => 'School pickup',
        ])->assertRedirect();

        $booking->refresh();
        $this->assertSame('pending', $booking->reschedule_request_status);
        $this->assertSame($newDate, $booking->reschedule_requested_date->toDateString());
        $this->assertSame('14:30', $booking->reschedule_requested_time);
        $this->assertSame('School pickup', $booking->reschedule_request_note);
        $this->assertSame('10:00', $booking->appointment_time);
    }

    public function test_admin_can_approve_a_reschedule_request(): void
    {
        Notification::fake();
        $admin = User::factory()->admin()->create();
        $booking = $this->futureBooking([
            'reschedule_requested_date' => now()->addDays(20)->toDateString(),
            'reschedule_requested_time' => '14:30',
            'reschedule_request_status' => 'pending',
            'reschedule_requested_at' => now(),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.bookings.show', $booking->id))
            ->post(route('admin.bookings.reschedule-request.approve', $booking->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        $booking->refresh();
        $this->assertSame('approved', $booking->reschedule_request_status);
        $this->assertSame(now()->addDays(20)->toDateString(), $booking->appointment_date->toDateString());
        $this->assertSame('14:30', $booking->appointment_time);

        Notification::assertSentOnDemand(BookingRescheduledNotification::class);
    }

    public function test_admin_can_decline_a_reschedule_request(): void
    {
        Mail::fake();
        $admin = User::factory()->admin()->create();
        $booking = $this->futureBooking([
            'reschedule_requested_date' => now()->addDays(20)->toDateString(),
            'reschedule_requested_time' => '14:30',
            'reschedule_request_status' => 'pending',
            'reschedule_requested_at' => now(),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.bookings.show', $booking->id))
            ->post(route('admin.bookings.reschedule-request.decline', $booking->id))
            ->assertRedirect()
            ->assertSessionHas('success');

        $booking->refresh();
        $this->assertSame('declined', $booking->reschedule_request_status);
        $this->assertSame('10:00', $booking->appointment_time);
        $this->assertSame(now()->addDays(12)->toDateString(), $booking->appointment_date->toDateString());

        Mail::assertSent(BookingRescheduleDeclinedMail::class, function (BookingRescheduleDeclinedMail $mail) use ($booking) {
            return $mail->hasTo('client@example.com')
                && $mail->booking->is($booking)
                && str_contains($mail->requestedLabel, '2:30');
        });

        $html = view('emails.reschedule_request_declined', [
            'booking' => $booking,
            'requestedLabel' => 'August 20, 2026 at 2:30 PM',
            'note' => null,
        ])->render();
        $this->assertStringContainsString('original appointment is still booked', $html);
        $this->assertStringContainsString('/bookings/confirm/'.$booking->id.'/CONFRESCH1', $html);
    }

    public function test_approve_is_blocked_when_the_slot_is_taken(): void
    {
        Notification::fake();
        $admin = User::factory()->admin()->create();
        $newDate = now()->addDays(20)->toDateString();
        Booking::factory()->confirmed()->create([
            'appointment_date' => $newDate,
            'appointment_time' => '14:30',
            'status' => 'confirmed',
        ]);
        $booking = $this->futureBooking([
            'reschedule_requested_date' => $newDate,
            'reschedule_requested_time' => '14:30',
            'reschedule_request_status' => 'pending',
            'reschedule_requested_at' => now(),
        ]);

        $this->actingAs($admin)
            ->from(route('admin.bookings.show', $booking->id))
            ->post(route('admin.bookings.reschedule-request.approve', $booking->id))
            ->assertRedirect()
            ->assertSessionHas('error');

        $booking->refresh();
        $this->assertSame('pending', $booking->reschedule_request_status);
        $this->assertSame('10:00', $booking->appointment_time);
        Notification::assertNothingSent();
    }

    public function test_guests_cannot_approve_reschedule_requests(): void
    {
        $booking = $this->futureBooking([
            'reschedule_requested_date' => now()->addDays(20)->toDateString(),
            'reschedule_requested_time' => '14:30',
            'reschedule_request_status' => 'pending',
        ]);

        $this->post(route('admin.bookings.reschedule-request.approve', $booking->id))
            ->assertRedirect();

        $this->assertSame('pending', $booking->fresh()->reschedule_request_status);
    }
}
