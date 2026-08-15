<?php

namespace Tests\Unit;

use App\Exceptions\SlotUnavailableException;
use App\Models\Booking;
use App\Services\BookingSlotGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingSlotGuardTest extends TestCase
{
    use RefreshDatabase;

    private function weekdayDate(): string
    {
        $date = now()->addDays(10)->startOfDay();
        while ($date->isWeekend()) {
            $date->addDay();
        }

        return $date->toDateString();
    }

    public function test_it_allows_a_free_weekday_slot(): void
    {
        $guard = app(BookingSlotGuard::class);

        $guard->assertAvailable($this->weekdayDate(), '10:00');

        $this->assertTrue(true);
    }

    public function test_it_rejects_a_time_inside_an_existing_four_hour_window(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
        ]);

        $this->expectException(SlotUnavailableException::class);

        app(BookingSlotGuard::class)->assertAvailable($date, '11:00');
    }

    public function test_it_allows_a_slot_when_the_four_hour_window_has_ended(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
        ]);

        app(BookingSlotGuard::class)->assertAvailable($date, '14:00');

        $this->assertTrue(true);
    }

    public function test_it_rejects_a_third_booking_on_the_same_day(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '08:00',
        ]);
        Booking::factory()->confirmed()->create([
            'appointment_date' => $date,
            'appointment_time' => '14:00',
        ]);

        $this->expectException(SlotUnavailableException::class);

        app(BookingSlotGuard::class)->assertAvailable($date, '18:00');
    }

    public function test_cancelled_bookings_do_not_block_the_slot(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
            'status' => 'cancelled',
        ]);

        app(BookingSlotGuard::class)->assertAvailable($date, '10:00');

        $this->assertTrue(true);
    }

    public function test_a_two_hour_booking_frees_the_slot_after_it_ends(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
            'service_duration_minutes' => 120,
        ]);

        app(BookingSlotGuard::class)->assertAvailable($date, '12:00', null, 3);

        $this->assertTrue(true);
    }

    public function test_a_six_hour_booking_still_blocks_the_two_pm_slot(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
            'service_duration_minutes' => 360,
        ]);

        $this->expectException(SlotUnavailableException::class);

        app(BookingSlotGuard::class)->assertAvailable($date, '14:00');
    }
}
