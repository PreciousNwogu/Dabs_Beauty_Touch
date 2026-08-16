<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Notifications\DepositReminderNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DepositReminderTest extends TestCase
{
    use RefreshDatabase;

    private function pendingBooking(array $overrides = []): Booking
    {
        return Booking::factory()->pending()->create(array_merge([
            'email' => 'client@example.com',
            'payment_status' => 'pending',
            'created_at' => now()->subHours(2)->subMinutes(5),
            'appointment_date' => now('America/Toronto')->addDays(3)->toDateString(),
            'appointment_time' => '14:00',
        ], $overrides));
    }

    public function test_sends_deposit_reminder_two_hours_after_booking(): void
    {
        Notification::fake();

        $booking = $this->pendingBooking();

        $this->artisan('bookings:send-deposit-reminders')
            ->expectsOutput('Sent 1 deposit reminder(s).')
            ->assertSuccessful();

        Notification::assertSentOnDemand(DepositReminderNotification::class);
        $this->assertNotNull($booking->fresh()->deposit_reminder_sent_at);
    }

    public function test_does_not_send_before_two_hours(): void
    {
        Notification::fake();

        $this->pendingBooking([
            'created_at' => now()->subHour(),
        ]);

        $this->artisan('bookings:send-deposit-reminders')
            ->expectsOutput('Sent 0 deposit reminder(s).')
            ->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_does_not_send_when_deposit_already_paid(): void
    {
        Notification::fake();

        $this->pendingBooking([
            'payment_status' => 'deposit_paid',
        ]);

        $this->artisan('bookings:send-deposit-reminders')
            ->expectsOutput('Sent 0 deposit reminder(s).')
            ->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_does_not_send_twice(): void
    {
        Notification::fake();

        $this->pendingBooking([
            'deposit_reminder_sent_at' => now()->subHour(),
        ]);

        $this->artisan('bookings:send-deposit-reminders')
            ->expectsOutput('Sent 0 deposit reminder(s).')
            ->assertSuccessful();

        Notification::assertNothingSent();
    }

    public function test_still_sends_when_utc_date_has_rolled_over_before_toronto(): void
    {
        Notification::fake();
        $this->travelTo(\Carbon\Carbon::parse('2026-08-17 02:15:00', 'UTC'));

        $this->pendingBooking([
            'created_at' => now()->subHours(3),
            'appointment_date' => '2026-08-16',
            'appointment_time' => '23:00',
        ]);

        $this->artisan('bookings:send-deposit-reminders')
            ->expectsOutput('Sent 1 deposit reminder(s).')
            ->assertSuccessful();

        Notification::assertSentOnDemand(DepositReminderNotification::class);
    }
}
