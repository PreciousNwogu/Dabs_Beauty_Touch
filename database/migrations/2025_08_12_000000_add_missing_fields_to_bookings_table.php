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
            // Add missing fields that are used in the model and controller
            $table->string('address')->nullable()->after('phone');
            $table->string('length')->nullable()->after('service');
            $table->string('sample_picture')->nullable()->after('message');
            
            // Add status tracking fields
            $table->timestamp('confirmed_at')->nullable()->after('notes');
            $table->timestamp('completed_at')->nullable()->after('confirmed_at');
            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
            $table->string('completed_by')->nullable()->after('cancelled_at');
            $table->text('completion_notes')->nullable()->after('completed_by');
            $table->integer('service_duration_minutes')->nullable()->after('completion_notes');
            $table->decimal('final_price', 8, 2)->nullable()->after('service_duration_minutes');
            $table->enum('payment_status', ['pending', 'deposit_paid', 'fully_paid'])->default('pending')->after('final_price');
            $table->json('status_history')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'length', 
                'sample_picture',
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
