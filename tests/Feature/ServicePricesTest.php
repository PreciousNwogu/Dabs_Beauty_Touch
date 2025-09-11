<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;

class ServicePricesTest extends TestCase
{
    use RefreshDatabase;

    public function test_prices_endpoint_returns_service_prices()
    {
        // seed a service
        Service::create(['name' => 'Test Service', 'slug' => 'test-service', 'base_price' => 123.45]);

        $response = $this->getJson('/api/services/prices');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertArrayHasKey('test-service', $data);
        $this->assertEquals(123.45, $data['test-service']);
    }
}
