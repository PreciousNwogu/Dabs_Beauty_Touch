<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCsvExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_download_bookings_csv(): void
    {
        $this->get('/admin/bookings/export.csv')->assertRedirect(route('admin.login'));
    }

    public function test_clients_cannot_download_bookings_csv(): void
    {
        $client = User::factory()->create(['is_admin' => false]);

        $this->actingAs($client)
            ->get('/admin/bookings/export.csv')
            ->assertRedirect(route('home'));
    }

    public function test_admin_can_download_filtered_bookings_csv(): void
    {
        $admin = User::factory()->admin()->create();

        Booking::factory()->pending()->create([
            'name' => 'Pending Client',
            'email' => 'pending@example.com',
            'service' => 'Kids Cornrows',
            'appointment_date' => now()->addDays(8)->toDateString(),
            'appointment_time' => '10:00',
            'final_price' => 80,
        ]);
        Booking::factory()->create([
            'name' => 'Done Client',
            'email' => 'done@example.com',
            'service' => 'Small Knotless Braids',
            'status' => 'completed',
            'appointment_date' => now()->subDays(2)->toDateString(),
            'appointment_time' => '14:00',
            'final_price' => 220.50,
        ]);

        $csv = $this->actingAs($admin)
            ->get('/admin/bookings/export.csv?status=completed')
            ->assertOk()
            ->assertHeader('content-disposition')
            ->streamedContent();

        $this->assertStringContainsString('Booking ID', $csv);
        $this->assertStringContainsString('Done Client', $csv);
        $this->assertStringContainsString('220.50', $csv);
        $this->assertStringNotContainsString('Pending Client', $csv);
    }

    public function test_admin_can_download_monthly_revenue_csv(): void
    {
        $admin = User::factory()->admin()->create();

        Booking::factory()->create([
            'status' => 'completed',
            'completed_at' => now(),
            'appointment_date' => now()->toDateString(),
            'final_price' => 150,
        ]);

        $csv = $this->actingAs($admin)
            ->get('/admin/revenue/export.csv')
            ->assertOk()
            ->streamedContent();

        $this->assertStringContainsString('Month', $csv);
        $this->assertStringContainsString('Revenue', $csv);
        $this->assertStringContainsString(now('America/Toronto')->format('F Y'), $csv);
        $this->assertStringContainsString('150.00', $csv);
    }
}
