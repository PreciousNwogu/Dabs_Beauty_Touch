<?php

namespace Tests\Unit;

use App\Support\ServiceDuration;
use Tests\TestCase;

class ServiceDurationTest extends TestCase
{
    public function test_it_uses_the_high_end_of_a_range(): void
    {
        $this->assertSame(4.0, ServiceDuration::parseToHours('3–4 hrs'));
        $this->assertSame(2.0, ServiceDuration::parseToHours('1-2 hrs'));
    }

    public function test_it_converts_minutes(): void
    {
        $this->assertSame(1.5, ServiceDuration::parseToHours('90 min'));
    }

    public function test_kids_services_default_to_three_hours(): void
    {
        $this->assertSame(3.0, ServiceDuration::hoursForName('Kids Cornrows'));
    }

    public function test_kids_rest_addon_adds_fifteen_minutes(): void
    {
        $this->assertSame(15, ServiceDuration::extraMinutesForKidsExtras('kb_add_detangle,kb_add_rest'));
        $this->assertSame(0, ServiceDuration::extraMinutesForKidsExtras('kb_add_beads'));
    }

    public function test_unknown_adult_services_default_to_four_hours(): void
    {
        $this->assertSame(4.0, ServiceDuration::hoursForName('Small Knotless Braids'));
    }
}
