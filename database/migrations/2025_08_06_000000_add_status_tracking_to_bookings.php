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
        Schema::table('bookings', function (Blueprint $table) {
            // Add additional status tracking columns
            $table->timestamp('confirmed_at')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('confirmed_at');
            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
            $table->string('completed_by')->nullable()->after('cancelled_at'); // Staff member who completed service
            $table->text('completion_notes')->nullable()->after('completed_by'); // Notes about the completed service
            $table->integer('service_duration_minutes')->nullable()->after('completion_notes'); // Actual service duration
            $table->decimal('final_price', 8, 2)->nullable()->after('service_duration_minutes'); // Final price charged
            $table->enum('payment_status', ['pending', 'deposit_paid', 'fully_paid'])->default('pending')->after('final_price');
            $table->text('status_history')->nullable()->after('payment_status'); // JSON field to track status changes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed_at',
                'completed_at', 
                'cancelled_at',
                'completed_by',
                'completion_notes',
                'service_duration_minutes',
                'final_price',
                'payment_status',
                'status_history'
            ]);
        });
    }
};
