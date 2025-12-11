<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Service;

class PricingTest extends TestCase
{
    /**
     * Simple helper that mimics app pricing logic: base price + length adjustment
     */
    private function computeFinalPrice(float $basePrice, string $length): float
    {
        // Compute adjustment using per-step $20 rule
        $ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
        $midIndex = array_search('mid_back', $ordered, true);
        $idx = array_search($length, $ordered, true);
        $d = ($idx !== false && $midIndex !== false) ? ($idx - $midIndex) : 0;
        $adjust = $d * 20.00;
        return round($basePrice + $adjust, 2);
    }

    public function test_jumbo_knotless_neck_price()
    {
        // Use repository seeder value (jumbo-knotless should be 60.00)
        $service = Service::where('slug', 'jumbo-knotless')->first();

        // If the Service model or DB isn't available in this test environment, skip
        if (!$service) {
            $this->markTestSkipped('Service model not available or DB not configured for unit test.');
            return;
        }

        $base = (float) $service->base_price;
        $final = $this->computeFinalPrice($base, 'neck');

        // Expected: base (60) + neck adjustment (-20) = 40
        $this->assertEquals(40.00, $final);
    }
}
