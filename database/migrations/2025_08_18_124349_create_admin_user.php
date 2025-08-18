<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create admin user if it doesn't exist
        $adminEmail = 'admin@dabsbeautytouch.com';
        
        $admin = User::where('email', $adminEmail)->first();
        
        if (!$admin) {
            User::create([
                'name' => 'System Administrator',
                'email' => $adminEmail,
                'password' => Hash::make('admin123!@#'),
                'is_admin' => true,
            ]);
            
            echo "Admin user created: {$adminEmail}\n";
        } else {
            // Ensure existing user has admin privileges
            if (!$admin->is_admin) {
                $admin->update(['is_admin' => true]);
                echo "Admin privileges granted to existing user: {$adminEmail}\n";
            } else {
                echo "Admin user already exists: {$adminEmail}\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove admin user
        User::where('email', 'admin@dabsbeautytouch.com')->delete();
    }
};
