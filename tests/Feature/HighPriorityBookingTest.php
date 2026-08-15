<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class HighPriorityBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_requires_email(): void
    {
        $this->post('/bookings', [
            'name' => 'Test Client',
            'phone' => '3432458848',
            'appointment_type' => 'in-studio',
            'appointment_date' => now()->addDays(10)->toDateString(),
            'appointment_time' => '10:00',
            'terms_accepted' => '1',
        ])->assertSessionHasErrors('email');
    }

    public function test_honeypot_does_not_create_a_booking(): void
    {
        $this->postJson('/bookings', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'phone' => '3432458848',
            'appointment_type' => 'in-studio',
            'appointment_date' => now()->addDays(10)->toDateString(),
            'appointment_time' => '10:00',
            'terms_accepted' => '1',
            'company_website' => 'http://spam.test',
        ])->assertOk();

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_pending_client_can_cancel(): void
    {
        Notification::fake();

        $booking = Booking::factory()->pending()->create([
            'confirmation_code' => 'CONFHIGH1',
            'email' => 'client@example.com',
            'appointment_date' => now()->addDays(10)->toDateString(),
            'appointment_time' => '10:00',
            'payment_status' => 'pending',
        ]);

        $this->post('/bookings/confirm/'.$booking->id.'/CONFHIGH1/cancel')
            ->assertRedirect();

        $this->assertSame('cancelled', $booking->fresh()->status);
    }

    public function test_confirmed_booking_cannot_cancel_inside_48_hours(): void
    {
        $booking = Booking::factory()->confirmed()->create([
            'confirmation_code' => 'CONFHIGH2',
            'email' => 'client@example.com',
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:00',
            'payment_status' => 'deposit_paid',
        ]);

        $this->from('/bookings/confirm/'.$booking->id.'/CONFHIGH2')
            ->post('/bookings/confirm/'.$booking->id.'/CONFHIGH2/cancel')
            ->assertRedirect();

        $this->assertSame('confirmed', $booking->fresh()->status);
    }
}
