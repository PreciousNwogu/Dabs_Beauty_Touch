<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Models\CustomServiceRequest;
use App\Notifications\CustomServiceRequest as AdminCustomServiceNotification;
use App\Notifications\UserCustomServiceConfirmation;

class CustomServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_service_submission_creates_record_and_sends_notifications()
    {
        Notification::fake();

        $payload = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'service' => 'Custom Style',
            'appointment_date' => now()->addDays(3)->toDateString(),
            'appointment_time' => '14:00',
            'message' => 'Please provide a quote.'
        ];

        $response = $this->postJson(route('custom-service.store'), $payload);

        $response->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseHas('custom_service_requests', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'service' => 'Custom Style'
        ]);

        $record = CustomServiceRequest::where('email', 'test@example.com')->first();
        $this->assertNotNull($record);

        // Notifications should be sent (at least one admin and one user)
        Notification::assertSent(AdminCustomServiceNotification::class, function ($notification, $channels) use ($record) {
            return true;
        });

        Notification::assertSent(UserCustomServiceConfirmation::class, function ($notification, $channels) use ($record) {
            return true;
        });
    }
}
