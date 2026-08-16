<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountSignupPromptTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_confirmation_page_invites_account_signup(): void
    {
        $booking = Booking::factory()->pending()->create([
            'name' => 'Pat Guest',
            'email' => 'pat@example.com',
            'confirmation_code' => 'CONFACC1',
            'user_id' => null,
            'appointment_date' => now()->addDays(10)->toDateString(),
            'appointment_time' => '10:00',
        ]);

        $this->get('/bookings/confirm/'.$booking->id.'/CONFACC1')
            ->assertOk()
            ->assertSee('Coming back next time?')
            ->assertSee('Create account')
            ->assertSee('register?email=pat', false);
    }

    public function test_signed_in_client_does_not_see_account_signup_prompt(): void
    {
        $user = User::factory()->create(['email' => 'member@example.com']);
        $booking = Booking::factory()->pending()->create([
            'email' => 'member@example.com',
            'confirmation_code' => 'CONFACC2',
            'user_id' => $user->id,
            'appointment_date' => now()->addDays(10)->toDateString(),
            'appointment_time' => '10:00',
        ]);

        $this->actingAs($user)
            ->get('/bookings/confirm/'.$booking->id.'/CONFACC2')
            ->assertOk()
            ->assertDontSee('Coming back next time?');
    }

    public function test_confirmation_email_invites_guest_to_create_an_account(): void
    {
        $booking = Booking::factory()->pending()->create([
            'name' => 'Pat Guest',
            'email' => 'pat@example.com',
            'user_id' => null,
        ]);

        $html = view('emails.booking_confirmation', [
            'booking' => $booking,
            'is_recipient_owner' => true,
        ])->render();

        $this->assertStringContainsString('Coming back next time?', $html);
        $this->assertStringContainsString('Create account', $html);
        $this->assertStringContainsString('register?email=pat', $html);
    }

    public function test_register_form_prefills_name_and_email(): void
    {
        $this->get('/register?email=pat@example.com&name=Pat+Guest')
            ->assertOk()
            ->assertSee('value="pat@example.com"', false)
            ->assertSee('value="Pat Guest"', false);
    }
}
