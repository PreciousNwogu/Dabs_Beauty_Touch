<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\PriceCalculator;
use App\Support\InteracDeposit;
use App\Support\KidsStyleCatalog;
use App\Support\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSettingsCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_and_save_business_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin/settings')
            ->assertOk()
            ->assertSee('Business Settings');

        $this->actingAs($admin)
            ->put('/admin/settings', [
                'interac_email' => 'deposit@example.com',
                'interac_amount' => 25,
                'max_bookings_per_day' => 3,
                'finished_tip_amount' => 30,
                'front_back_amount' => 15,
                'length' => [
                    'neck' => -50,
                    'shoulder' => -50,
                    'armpit' => -50,
                    'bra_strap' => 0,
                    'mid_back' => 0,
                    'waist' => 25,
                    'hip' => 45,
                    'tailbone' => 70,
                    'classic' => 70,
                ],
                'category' => [
                    'knotless' => ['label' => 'Knotless Looks', 'visible' => 1, 'sort' => 5],
                    'kids' => ['label' => 'Kids Styles', 'visible' => 0, 'sort' => 90],
                ],
                'kids' => [
                    'protective' => ['label' => 'Natural Twists', 'visible' => 1, 'sort' => 1],
                    'cornrows' => ['label' => 'Cornrows', 'visible' => 0, 'sort' => 2],
                ],
                'promo_enabled' => 1,
                'promo_title' => 'Spring promo',
                'promo_text' => 'Book this week',
            ])
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertSame('deposit@example.com', InteracDeposit::email());
        $this->assertSame(25.0, InteracDeposit::amount());
        $this->assertSame(3, SiteSettings::maxBookingsPerDay());
        $this->assertSame(30.0, SiteSettings::finishedTipAmount());
        $this->assertFalse(SiteSettings::categoryVisible('kids'));
        $this->assertSame('Knotless Looks', SiteSettings::categoryLabel('knotless'));
        $this->assertSame('Natural Twists', KidsStyleCatalog::displayName('protective'));
        $this->assertFalse(collect(KidsStyleCatalog::selectorCards())->contains(fn ($c) => $c['key'] === 'cornrows'));

        $cards = KidsStyleCatalog::selectorCards();
        $this->assertNotEmpty($cards);
        $protective = collect($cards)->firstWhere('key', 'protective');
        $this->assertNotNull($protective);
        $this->assertNotSame('', $protective['image']);
        $this->assertNotSame('', $protective['duration']);
        $this->assertStringContainsString('kids-natual-hair-twist', $protective['image']);

        $pricing = app(PriceCalculator::class)->calculate([
            'service_input' => 'Jumbo Knotless Braids',
            'service_type' => 'jumbo_knotless',
            'length' => 'waist',
            'tip_option' => 'finished',
            'service_model' => (object) ['has_length' => true, 'has_tip_finish' => true, 'base_price' => 100],
        ]);
        $this->assertSame(25.0, (float) $pricing['length_adjustment']);
        $this->assertTrue((bool) $pricing['tip_addon_applied']);
    }

    public function test_guests_cannot_open_settings(): void
    {
        $this->get('/admin/settings')->assertRedirect(route('admin.login'));
    }

    public function test_kids_selector_shows_photos_time_and_mobile_total(): void
    {
        $this->get('/kids-selector')
            ->assertOk()
            ->assertSee('kbMobileTotalBar', false)
            ->assertSee('data-duration', false)
            ->assertSee('kids-natual-hair-twist', false)
            ->assertSee('1–2 hrs', false)
            ->assertSee('braids-length-guide.jpg', false)
            ->assertSee('Before you come', false)
            ->assertSee('Kids usually sit about', false)
            ->assertSee('15-min break', false)
            ->assertSee('Child&#039;s first name', false)
            ->assertSee('kidsBookingModal', false)
            ->assertSee('calendarModal', false);
    }

    public function test_kids_booking_notes_include_parent_age_and_color(): void
    {
        $request = \Illuminate\Http\Request::create('/bookings', 'POST', [
            'parent_name' => 'Jane Parent',
            'child_age' => 6,
            'hair_color' => 'burgundy',
            'comments' => 'First visit',
        ]);

        $message = \App\Support\BookingReturn::composeKidsMessage($request);
        $this->assertStringContainsString('Parent/Guardian: Jane Parent', $message);
        $this->assertStringContainsString('Child age: 6', $message);
        $this->assertStringContainsString('burgundy', $message);
        $this->assertStringContainsString('First visit', $message);
        $this->assertSame('kids.selector', \App\Support\BookingReturn::routeName(
            \Illuminate\Http\Request::create('/bookings', 'POST', ['booking_origin' => 'kids-selector'])
        ));
    }
}
