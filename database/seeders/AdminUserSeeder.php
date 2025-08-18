<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user if it doesn't exist
        $adminEmail = 'admin@dabsbeautytouch.com';
        
        $admin = User::where('email', $adminEmail)->first();
        
        if (!$admin) {
            User::create([
                'name' => 'System Administrator',
                'email' => $adminEmail,
                'password' => Hash::make('admin123!@#'), // Change this in production
                'is_admin' => true,
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: ' . $adminEmail);
            $this->command->info('Password: admin123!@# (Please change this after first login)');
        } else {
            // Ensure existing user has admin privileges
            if (!$admin->is_admin) {
                $admin->update(['is_admin' => true]);
                $this->command->info('Admin privileges granted to existing user: ' . $adminEmail);
            } else {
                $this->command->info('Admin user already exists: ' . $adminEmail);
            }
        }
    }
}
