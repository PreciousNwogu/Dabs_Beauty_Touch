<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\CustomServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MediumPriorityBookingTest extends TestCase
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

    public function test_slots_respect_a_shorter_existing_booking(): void
    {
        $date = $this->weekdayDate();

        Booking::factory()->pending()->create([
            'appointment_date' => $date,
            'appointment_time' => '10:00',
            'service_duration_minutes' => 120,
        ]);

        $times = collect($this->getJson('/bookings/slots?date='.$date.'&service=Kids%20Cornrows')
            ->assertOk()
            ->json('slots'))->pluck('time');

        $this->assertContains('12:00', $times->all());
        $this->assertNotContains('10:00', $times->all());
        $this->assertNotContains('11:00', $times->all());
    }

    public function test_new_bookings_store_service_duration(): void
    {
        Notification::fake();

        $this->post('/bookings', [
            'name' => 'Duration Client',
            'email' => 'duration@example.com',
            'phone' => '3432458848',
            'service' => 'Kids Cornrows',
            'appointment_type' => 'in-studio',
            'appointment_date' => $this->weekdayDate(),
            'appointment_time' => '10:00',
            'terms_accepted' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'email' => 'duration@example.com',
            'service_duration_minutes' => 180,
        ]);
    }

    public function test_admin_can_convert_a_custom_request_into_a_booking(): void
    {
        Notification::fake();

        $admin = User::factory()->admin()->create();
        $request = CustomServiceRequest::create([
            'name' => 'Custom Client',
            'email' => 'custom@example.com',
            'phone' => '3432458848',
            'service' => 'Custom knotless',
            'status' => 'new',
            'message' => 'Please quote a full install.',
        ]);

        $date = $this->weekdayDate();

        $this->actingAs($admin)
            ->post('/admin/custom-requests/'.$request->id.'/convert', [
                'name' => 'Custom Client',
                'email' => 'custom@example.com',
                'phone' => '3432458848',
                'service' => 'Custom knotless',
                'appointment_date' => $date,
                'appointment_time' => '10:00',
                'appointment_type' => 'in-studio',
                'final_price' => 250,
                'message' => 'Please quote a full install.',
            ])
            ->assertRedirect();

        $booking = Booking::query()->where('email', 'custom@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertSame('pending', $booking->status);
        $this->assertSame(240, (int) $booking->service_duration_minutes);
        $this->assertSame('handled', $request->fresh()->status);
        $this->assertSame($booking->id, $request->fresh()->converted_booking_id);
    }

    public function test_guests_cannot_convert_a_custom_request(): void
    {
        $request = CustomServiceRequest::create([
            'name' => 'Custom Client',
            'email' => 'custom@example.com',
            'service' => 'Custom',
            'status' => 'new',
        ]);

        $this->post('/admin/custom-requests/'.$request->id.'/convert', [
            'name' => 'Custom Client',
            'email' => 'custom@example.com',
            'service' => 'Custom',
            'appointment_date' => $this->weekdayDate(),
            'appointment_time' => '10:00',
            'appointment_type' => 'in-studio',
        ])->assertRedirect();

        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_homepage_schema_does_not_invent_reviews(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertDontSee('aggregateRating', false)
            ->assertSee('areaServed', false);
    }

    public function test_sitemap_includes_core_public_pages(): void
    {
        $xml = $this->get('/sitemap.xml')->assertOk()->getContent();

        $this->assertStringContainsString('/calendar', $xml);
        $this->assertStringContainsString('/kids-selector', $xml);
        $this->assertStringContainsString('/login', $xml);
        $this->assertStringContainsString('/register', $xml);
    }
}
