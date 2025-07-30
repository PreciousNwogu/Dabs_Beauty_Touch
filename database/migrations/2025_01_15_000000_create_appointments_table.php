<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique(); // Unique booking reference
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('service');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('duration')->default('60'); // Duration in minutes
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('confirmation_code')->unique(); // For client reference
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['appointment_date', 'appointment_time']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
}; 