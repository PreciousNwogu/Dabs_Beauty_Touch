<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some sample bookings
        Booking::factory(20)->create();

        // Create some specific test bookings
        Booking::factory()->pending()->create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@example.com',
            'service' => 'Knotless Braids',
        ]);

        Booking::factory()->confirmed()->today()->create([
            'name' => 'Amara Wilson',
            'email' => 'amara@example.com',
            'service' => 'Box Braids',
        ]);
    }
}
