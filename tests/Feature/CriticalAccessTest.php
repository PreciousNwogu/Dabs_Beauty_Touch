<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CriticalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_open_the_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('admin.login'));
    }

    public function test_clients_cannot_open_the_admin_dashboard(): void
    {
        $client = User::factory()->create(['is_admin' => false]);

        $this->actingAs($client)
            ->get('/admin/dashboard')
            ->assertRedirect(route('home'));
    }

    public function test_admins_can_open_the_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_client_login_is_rejected_on_the_admin_form(): void
    {
        $client = User::factory()->create([
            'email' => 'client@example.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        $this->post('/admin/login', [
            'email' => $client->email,
            'password' => 'password',
        ])->assertRedirect()->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_public_debug_routes_are_gone(): void
    {
        $this->get('/create-admin')->assertNotFound();
        $this->get('/check-db')->assertNotFound();
        $this->get('/test-db')->assertNotFound();
        $this->get('/_debug/mail')->assertNotFound();
        $this->get('/admin/test')->assertNotFound();
    }

    public function test_calendar_file_requires_the_confirmation_code(): void
    {
        $booking = Booking::factory()->pending()->create([
            'confirmation_code' => 'CONFTEST1',
            'phone' => '3432458848',
            'appointment_date' => now()->addDays(5)->toDateString(),
            'appointment_time' => '10:00',
        ]);

        $this->get('/bookings/'.$booking->id.'/calendar.ics')->assertNotFound();
        $this->get('/bookings/'.$booking->id.'/wrongcode/calendar.ics')->assertNotFound();

        $this->get('/bookings/'.$booking->id.'/CONFTEST1/calendar.ics')
            ->assertOk()
            ->assertHeader('content-type', 'text/calendar; charset=utf-8')
            ->assertDontSee('3432458848');
    }
}
