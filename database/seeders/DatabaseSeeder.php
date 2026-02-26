<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Precious',
            'email' => 'precious@dabsbeautytouch.com',
        ]);

        // Seed bookings
        $this->call([
            ServiceSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
