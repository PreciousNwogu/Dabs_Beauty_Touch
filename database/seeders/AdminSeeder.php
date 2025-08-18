<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::updateOrCreate(
            ['email' => 'admin@dabsbeautytouch.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@dabsbeautytouch.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        echo "Admin user created: admin@dabsbeautytouch.com / admin123\n";
    }
}
